<?php

namespace App\Http\Controllers;

use App\Exports\RencanaAksiExport;
use App\Exports\RencanaExport;
use App\Helpers\LogHelper;
use App\Models\Monev;
use App\Models\Opd;
use App\Models\ProgresKerja;
use App\Models\RencanaAksi_6_tahun;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RencanaAksi_6TahunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil input dari request
        $search = $request->input('search');
        $selectedTahun = $request->input('tahun'); // Ambil input tahun

        // =============================================================
        // BAGIAN BARU 1: Mengambil daftar tahun unik dari database
        // =============================================================
        $tahuns = RencanaAksi_6_tahun::select('tahun')
            ->where('delete_at', '0')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $query = RencanaAksi_6_tahun::with(['subprogram', 'opd'])
            ->where('delete_at', '0');

        // =============================================================
        // BAGIAN BARU 2: Terapkan filter tahun jika dipilih
        // =============================================================
        if ($selectedTahun) {
            $query->where('tahun', $selectedTahun);
        }

        // Logika pencarian Anda (tidak berubah)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('rencana_aksi', 'like', "%{$search}%")
                    ->orWhere('nama_program', 'like', "%{$search}%")
                    ->orWhere('kegiatan', 'like', "%{$search}%")
                    ->orWhere('sub_kegiatan', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    // ->orWhere('tahun', 'like', "%{$search}%") // Sebaiknya dihapus agar tidak bentrok dengan filter
                    ->orWhere('volume', 'like', "%{$search}%")
                    ->orWhere('satuan', 'like', "%{$search}%")
                    ->orWhere('anggaran', 'like', "%{$search}%")
                    ->orWhere('sumberdana', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('opd', function ($subq) use ($search) {
                        $subq->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subprogram', function ($subq) use ($search) {
                        $subq->where('subprogram', 'like', "%{$search}%");
                    });
            });
        }

        $rencanaAksi = $query->latest()->paginate(10); // Menambahkan latest() agar data terbaru di atas

        // Kirim semua filter (search & tahun) saat pindah halaman paginasi
        $rencanaAksi->appends($request->only('search', 'tahun'));

        // =============================================================
        // BAGIAN BARU 3: Kirim variabel $tahuns ke view
        // =============================================================
        return view('admin.RencanAksi6Tahun.index', compact('rencanaAksi', 'search', 'tahuns'));
    }

    // public function index()
    // {
    //     $rencanaAksi = RencanaAksi_6_tahun::where('delete_at', '0')->paginate(10);
    //     return view('admin.RencanAksi6Tahun.index', compact('rencanaAksi'));
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subprogram = Subprogram::where('delete_at', '0')->get();
        $opds = Opd::where('delete_at', '0')->get();
        return view('admin.RencanAksi6Tahun.create', compact('subprogram', 'opds'));
    }
    public function exportExcelAksi()
    {
        return Excel::download(new RencanaAksiExport, 'rencana_aksi.xlsx');
    }
    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $validate = $request->validate([
            'sub_program' => 'required|exists:subprograms,id',
            'nama_program' => 'required',
            'rencanaAksi' => 'required',
            'kegiatan' => 'required',
            'sub_kegiatan' => 'required',
            'tahun' => 'required',
            'anggaran' => 'required|array',
            'anggaran.*' => 'required|string',
            'sumberdana' => 'required|array',
            'sumberdana.*' => 'required|string',
            'lokasi' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'id_opd' => 'required|exists:opds,id',
            'keterangan' => 'required'
        ]);

        // 2. Ubah array anggaran dan sumberdana menjadi string dengan pemisah ';'
        $anggaranString = implode('; ', $validate['anggaran']);
        $sumberdanaString = implode('; ', $validate['sumberdana']);

        RencanaAksi_6_tahun::create([
            'id_pengguna'   => Auth::guard('pengguna')->id(),
            'id_subprogram' => $validate['sub_program'],
            'rencana_aksi'  => $validate['rencanaAksi'],
            'nama_program'  => $validate['nama_program'],
            'kegiatan'      => $validate['kegiatan'],
            'sub_kegiatan'  => $validate['sub_kegiatan'],
            'tahun'         => $validate['tahun'],
            'anggaran'      => $anggaranString,
            'sumberdana'    => $sumberdanaString,
            'lokasi'        => $validate['lokasi'],
            'volume'        => $validate['volume'],
            'satuan'        => $validate['satuan'],
            'id_opd'        => $validate['id_opd'],
            'keterangan'    => $validate['keterangan'],
        ]);

        $rencana = RencanaKerja::create([
            'id_pengguna'   => Auth::guard('pengguna')->id(),
            'id_subprogram' => $validate['sub_program'],
            'rencana_aksi'  => $validate['rencanaAksi'],
            'nama_program'  => $validate['nama_program'],
            'kegiatan'      => $validate['kegiatan'],
            'sub_kegiatan'  => $validate['sub_kegiatan'],
            'tahun'         => $validate['tahun'],
            'anggaran'      => $anggaranString,
            'sumberdana'    => $sumberdanaString,
            'lokasi'        => $validate['lokasi'],
            'volume'        => $validate['volume'],
            'satuan'        => $validate['satuan'],
            'id_opd'        => $validate['id_opd'],
            'keterangan'    => $validate['keterangan'],
        ]);

        $monev = Monev::create([
            'id_pengguna'   => $rencana->id_pengguna,
            'id_subprogram' => $rencana->id_subprogram,
            'rencana_aksi'  => $rencana->id,
            'sub_kegiatan'  => $rencana->sub_kegiatan,
            'kegiatan'      => $rencana->kegiatan,
            'nama_program'  => $rencana->nama_program,
            'lokasi'        => $rencana->lokasi,
            'volume'        => $rencana->volume,
            'satuan'        => $rencana->satuan,
            'anggaran'      => $anggaranString,
            'sumberdana'    => $sumberdanaString,
            'tahun'         => $rencana->tahun,
            'id_opd'        => $rencana->id_opd,
            'status'        => 'Belum divalidasi',
        ]);

        ProgresKerja::create([
            'id_pengguna' => $monev->id_pengguna,
            'id_monev'    => $monev->id,

        ]);


        LogHelper::add('Menambah Data Rencana Aksi + Rencana Kerja + Monev');

        return redirect()->route('rencana6tahun')
            ->with('success', 'Rencana Aksi, Rencana Kerja, dan Monev berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rencanaAksi = RencanaAksi_6_tahun::findOrFail($id);
        $subprogram = Subprogram::where('delete_at', '0')->get();
        $opds = Opd::where('delete_at', '0')->get();

        // PECAH STRING MENJADI ARRAY SEBELUM DIKIRIM KE VIEW
        $rencanaAksi->anggaran = explode('; ', $rencanaAksi->anggaran);
        $rencanaAksi->sumberdana = explode('; ', $rencanaAksi->sumberdana);

        return view('admin.RencanAksi6Tahun.update', compact('rencanaAksi', 'subprogram', 'opds'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $validate = $request->validate([
            'sub_program'   => 'required|exists:subprograms,id',
            'rencanaAksi'   => 'required',
            'nama_program'  => 'required',
            'kegiatan'      => 'required',
            'sub_kegiatan'  => 'required',
            'tahun'         => 'required',
            'anggaran'      => 'required|array',
            'anggaran.*'    => 'required|string',
            'sumberdana'    => 'required|array',
            'sumberdana.*'  => 'required|string',
            'lokasi'        => 'required',
            'volume'        => 'required',
            'satuan'        => 'required',
            'id_opd'        => 'required|exists:opds,id',
            'keterangan'    => 'required'
        ]);

        // 2. Ubah array jadi string
        $anggaranString = implode('; ', $validate['anggaran']);
        $sumberdanaString = implode('; ', $validate['sumberdana']);

        // 3. Data update
        $updateData = [
            'id_subprogram' => $validate['sub_program'],
            'rencana_aksi'  => $validate['rencanaAksi'],
            'nama_program'  => $validate['nama_program'],
            'kegiatan'      => $validate['kegiatan'],
            'sub_kegiatan'  => $validate['sub_kegiatan'],
            'tahun'         => $validate['tahun'],
            'anggaran'      => $anggaranString,
            'sumberdana'    => $sumberdanaString,
            'lokasi'        => $validate['lokasi'],
            'id_opd'        => $validate['id_opd'],
            'volume'        => $validate['volume'],
            'satuan'        => $validate['satuan'],
            'keterangan'    => $validate['keterangan'],
        ];

        // 4. Ambil data lama Rencana Aksi
        $rencanaAksi = RencanaAksi_6_tahun::findOrFail($id);
        $oldRencanaAksi = $rencanaAksi->replicate();

        // 5. Update Rencana Aksi
        $rencanaAksi->update($updateData);

        // 6. Cari & Update Renja (berdasarkan rencana_aksi lama)
        $rencanaKerja = RencanaKerja::where('rencana_aksi', $oldRencanaAksi->rencana_aksi)
            ->where('tahun', $oldRencanaAksi->tahun)
            ->first();

        if ($rencanaKerja) {
            $rencanaKerja->update($updateData);

            // 7. Cari & Update Monev (berdasarkan id renja)
            $monev = Monev::where('rencana_aksi', $rencanaKerja->id)->first();
            if ($monev) {
                // ⚠️ Jangan update kolom rencana_aksi di Monev karena itu integer (id renja)
                $monevUpdate = $updateData;
                unset($monevUpdate['rencana_aksi']);

                $monev->update($monevUpdate);
            }
        }

        LogHelper::add('Mengedit Data Rencana Aksi, Rencana Kerja, dan Monev');

        return redirect()->route('rencana6tahun')
            ->with('success', 'Data berhasil diperbarui!');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rencanaAksi = RencanaAksi_6_tahun::findOrFail($id);
        $rencanaAksi->update([
            'delete_at' => '1'
        ]);
        LogHelper::add('Menghapus Data Rencana Aksi');
        return redirect()->route('rencana6tahun')
            ->with('success', 'Rencana Aksi berhasil dihapus!');
    }
}
