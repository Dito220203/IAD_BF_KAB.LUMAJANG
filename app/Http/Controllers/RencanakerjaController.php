<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Opd;
use App\Models\RencanaAksi_6_tahun;
use App\Models\RencanaKerja;
use App\Models\Subprogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RencanaExport;
use App\Models\Monev;

class RencanakerjaController extends Controller
{

    // app/Http/Controllers/RencanakerjaController.php

public function index(Request $request)
{
    $user   = Auth::guard('pengguna')->user();
    $search = $request->input('search');
    $tahun  = $request->input('tahun'); // <-- AMBIL INPUT TAHUN DARI REQUEST

    // Ambil semua tahun unik dari database untuk dropdown filter
    // distinct() untuk mengambil nilai unik & pluck() untuk mengambil satu kolom saja
    $daftarTahun = RencanaKerja::query()
        ->active() // Hanya dari data yang aktif
        ->select('tahun')
        ->distinct()
        ->orderBy('tahun', 'desc') // Urutkan dari tahun terbaru
        ->pluck('tahun');

    $query = RencanaKerja::with(['subprogram', 'opd'])
        ->active();

    if ($user->level !== 'Super Admin') {
        $query->where('id_pengguna', $user->id);
    }

    // TERAPKAN FILTER TAHUN JIKA ADA
    if ($tahun) {
        $query->where('tahun', $tahun);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('rencana_aksi', 'like', "%{$search}%")
              // ... sisa query pencarian Anda tidak berubah ...
              ->orWhere('keterangan', 'like', "%{$search}%");
        })
        ->orWhereHas('opd', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        })
        ->orWhereHas('subprogram', function ($q) use ($search) {
            $q->where('subprogram', 'like', "%{$search}%");
        });
    }

    $rencana = $query->paginate(10);
    // Tambahkan 'tahun' agar pagination tetap mengingat filter tahun yang dipilih
    $rencana->appends($request->only('search', 'tahun'));

    // KIRIM VARIABEL BARU KE VIEW
    return view('admin.RencanaKerja.index', compact('rencana', 'search', 'daftarTahun', 'tahun'));
}
//     public function index(Request $request)
// {
//     $user   = Auth::guard('pengguna')->user();
//     $search = $request->input('search');

//     $query = RencanaKerja::with(['subprogram', 'opd'])
//         ->active(); // pakai scopeActive dari model

//     // Kalau bukan super admin, filter data hanya milik user
//     if ($user->level !== 'Super Admin') {
//         $query->where('id_pengguna', $user->id);
//     }

//     // Fitur pencarian
//     if ($search) {
//         $query->where(function ($q) use ($search) {
//             $q->where('rencana_aksi', 'like', "%{$search}%")
//               ->orWhere('nama_program', 'like', "%{$search}%")
//               ->orWhere('kegiatan', 'like', "%{$search}%")
//               ->orWhere('sub_kegiatan', 'like', "%{$search}%")
//               ->orWhere('lokasi', 'like', "%{$search}%")
//               ->orWhere('tahun', 'like', "%{$search}%")
//               ->orWhere('anggaran', 'like', "%{$search}%")
//               ->orWhere('volume', 'like', "%{$search}%")
//               ->orWhere('satuan', 'like', "%{$search}%")
//               ->orWhere('sumberdana', 'like', "%{$search}%")
//               ->orWhere('keterangan', 'like', "%{$search}%");
//         })
//         ->orWhereHas('opd', function ($q) use ($search) {
//             $q->where('nama', 'like', "%{$search}%");
//         })
//         ->orWhereHas('subprogram', function ($q) use ($search) {
//             $q->where('subprogram', 'like', "%{$search}%");
//         });
//     }

//     $rencana = $query->paginate(10);
//     $rencana->appends($request->only('search'));

//     return view('admin.RencanaKerja.index', compact('rencana', 'search'));
// }



    public function getRencanaAksi($id_subprogram)
    {
        $rencanaAksi = RencanaAksi_6_tahun::where('id_subprogram', $id_subprogram)->where('delete_at', '0')
            ->get();

        return response()->json($rencanaAksi);
    }
    public function getDetail($id)
    {
        $data = RencanaAksi_6_tahun::with(['subprogram'])->findOrFail($id);

        return response()->json([
            'sub_kegiatan' => $data->sub_kegiatan,
            'kegiatan'     => $data->kegiatan,
            'nama_program' => $data->nama_program,
            // 'tahun'        => $data->tahun,
        ]);
    }




    public function create()
    {
        $subprogram = Subprogram::where('delete_at', '0')->get();
        $opd = Opd::where('delete_at', '0')->get();
        $rencanaAksi =  RencanaAksi_6_tahun::where('delete_at', '0')->get();

        return view('admin.RencanaKerja.create', compact('subprogram', 'opd', 'rencanaAksi'));
    }
    public function exportExcel()
    {
        $user = Auth::guard('pengguna')->user();

        return Excel::download(new RencanaExport($user), 'rencana_kerja.xlsx');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'id_subprogram'  => 'required|exists:subprograms,id',
            'rencanaAksi'    => 'required',
            'sub_kegiatan'   => 'required',
            'kegiatan'       => 'required',
            'nama_program'   => 'required',
            'tahun'          => 'required',
            'volume'         => 'required',
            'satuan'         => 'required',
            'anggaran'       => 'required',
            'sumberdana'     => 'required',
            'lokasi'         => 'required',
            'id_opd'         => 'required|exists:opds,id',
            'keterangan'     => 'required'
        ]);

        // simpan ke tabel rencana kerja
        $rencana = RencanaKerja::create([
            'id_pengguna'   => Auth::guard('pengguna')->id(),
            'id_subprogram' => $validate['id_subprogram'],
            'rencana_aksi'  => $validate['rencanaAksi'],
            'sub_kegiatan'  => $validate['sub_kegiatan'],
            'kegiatan'      => $validate['kegiatan'],
            'nama_program'  => $validate['nama_program'],
            'lokasi'        => $validate['lokasi'],
            'volume'        => $validate['volume'],
            'satuan'        => $validate['satuan'],
            'anggaran'      => $validate['anggaran'],
            'sumberdana'    => $validate['sumberdana'],
            'tahun'         => $validate['tahun'],
            'id_opd'        => $validate['id_opd'],
            'status'        => 'Belum divalidasi',
            'keterangan'    => $validate['keterangan'],
        ]);

        // otomatis simpan juga ke tabel monev
        Monev::create([
            'id_pengguna'   => $rencana->id_pengguna,
            'id_subprogram' => $rencana->id_subprogram,
            'rencana_aksi'  => $rencana->id,
            'sub_kegiatan'  => $rencana->sub_kegiatan,
            'kegiatan'      => $rencana->kegiatan,
            'nama_program'  => $rencana->nama_program,
            'lokasi'        => $rencana->lokasi,
            'volume'        => $rencana->volume,
            'satuan'        => $rencana->satuan,
            'anggaran'      => $rencana->anggaran,
            'sumberdana'    => $rencana->sumberdana,
            'tahun'         => $rencana->tahun,
            'id_opd'        => $rencana->id_opd,
            'status'        => $rencana->status,



        ]);

        LogHelper::add('Menambah Data Rencana Kerja + otomatis ke Monev');

      return redirect()->route('rencanakerja')
            ->with('success', 'Rencana Kerja berhasil ditambahkan!');
}



    public function validasi(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);
        $rencana->status = 'Valid';
        $rencana->save();

        LogHelper::add('Memvalidasi data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Status berhasil divalidasi');
    }

    public function updateStatus(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);
        $rencana->status = $rencana->status === 'Valid' ? 'Belum divalidasi' : 'Valid';
        $rencana->save();

        LogHelper::add('Mengubah status data Rencana Kerja');
        return redirect()->route('rencanakerja')->with('success', 'Status berhasil diperbarui');
    }

    public function show(string $id)
    {
        $rencana = RencanaKerja::with(['subprogram', 'opd'])->findOrFail($id);

        LogHelper::add('Melihat detail data Rencana Kerja');
        return view('admin.RencanaKerja.show', compact('rencana'));
    }


    public function edit(string $id)
    {
        // Pastikan hanya user yang berhak yang bisa mengedit
        $user = Auth::guard('pengguna')->user();
        $rencana = RencanaKerja::findOrFail($id);

        // Jika bukan Super Admin, cek apakah data ini miliknya
        if ($user->level !== 'Super Admin' && $rencana->id_pengguna !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

        $subprogram = Subprogram::where('delete_at', '0')->get();
        $opd = Opd::where('delete_at', '0')->get();

        return view('admin.RencanaKerja.update', compact('rencana', 'subprogram', 'opd'));
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'id_subprogram' => 'required|exists:subprograms,id',
            'rencanaAksi'   => 'required',
            'sub_kegiatan'  => 'required',
            'kegiatan'      => 'required',
            'nama_program'  => 'required',
            'tahun'         => 'required',
            'volume'        => 'required',
            'satuan'        => 'required',
            'anggaran'      => 'required',
            'sumberdana'    => 'required',
            'lokasi'        => 'required',
            'id_opd'        => 'required|exists:opds,id',
            'keterangan'    => 'required'
        ]);

        // Bersihkan format 'Rp.' dan titik dari anggaran sebelum disimpan
        $validate['anggaran'] = preg_replace('/[^\d]/', '', $validate['anggaran']);

        $rencana = RencanaKerja::findOrFail($id);

        // Pastikan hanya user yang berhak yang bisa update
        $user = Auth::guard('pengguna')->user();
        if ($user->level !== 'Super Admin' && $rencana->id_pengguna !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate data ini.');
        }

        // Ubah nama field 'rencanaAksi' menjadi 'rencana_aksi' sesuai kolom database
        $updateData = $validate;
        $updateData['rencana_aksi'] = $validate['rencanaAksi'];
        unset($updateData['rencanaAksi']);

        // Update data di tabel rencana kerja
        $rencana->update($updateData);

        // Cari dan update juga data di tabel monev yang terkait
        $monev = Monev::where('rencana_aksi', $rencana->id)->first();
        if ($monev) {
            $monev->update([
                'id_subprogram' => $rencana->id_subprogram,
                'sub_kegiatan'  => $rencana->sub_kegiatan,
                'kegiatan'      => $rencana->kegiatan,
                'nama_program'  => $rencana->nama_program,
                'lokasi'        => $rencana->lokasi,
                'volume'        => $rencana->volume,
                'satuan'        => $rencana->satuan,
                'anggaran'      => $rencana->anggaran,
                'sumberdana'    => $rencana->sumberdana,
                'tahun'         => $rencana->tahun,
                'id_opd'        => $rencana->id_opd,
            ]);
        }

        LogHelper::add('Mengedit Data Rencana Kerja (ID: ' . $id . ') + otomatis update Monev');

        return redirect()->route('rencanakerja')
            ->with('success', 'Rencana Kerja berhasil diperbarui!');
    }


    public function destroy(string $id)
    {
        $rencana = RencanaKerja::findOrFail($id);

        if ($rencana->file && Storage::disk('public')->exists($rencana->file)) {
            Storage::disk('public')->delete($rencana->file);
        }

        $rencana->update([
            'delete_at' => '1'
        ]);
        LogHelper::add('Menghapus data Rencana Kerja');

        return redirect()->route('rencanakerja')->with('success', 'Data berhasil dihapus');
    }
}
