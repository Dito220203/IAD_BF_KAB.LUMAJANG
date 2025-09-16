<?php

use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\GambaranUmumController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KthController;
use App\Http\Controllers\KupsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonevController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\Passwordcontroller;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PotensiController;
use App\Http\Controllers\ProgreskerjaController;
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\RencanakerjaController;
use App\Http\Controllers\SubProgramController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\PotensiKupsController;
use App\Http\Controllers\ProdukKupsController;
use App\Http\Controllers\RencanaAksi_6TahunController;
use App\Http\Controllers\SubpotensiKehutananController;
use App\Models\Pesan;
use App\Models\RencanaKerja;
use Illuminate\Support\Facades\Route;

//client
Route::get('/', [ClientController::class, 'index'])->name('client');
// routes/web.php

Route::get('/get-desa/client/{kecamatanId}', [ClientController::class, 'getDesaByKecamatan']);
Route::get('/profil-kawasan/search', [ClientController::class, 'searchPotensi'])->name('profilkawasan.search');
Route::get('/profil', [ClientController::class, 'Daftarprofilkawasan'])
    ->name('client.Daftarprofilkawasan');
Route::get('/profil-kawasan/{id}', [ClientController::class, 'profilkawasandetail'])
    ->name('profilkawasan.detail');



Route::prefix('subprogram/{id}')->group(function () {
    Route::get('/tentangkegiatan', [ClientController::class, 'tentangkegiatan'])->name('client.tentangkegiatan');
    Route::get('/rencanaaksi', [ClientController::class, 'rencanaaksi'])->name('client.rencanaaksi');
    Route::get('/rencanakegiatan', [ClientController::class, 'rencanakegiatan'])->name('client.rencanakegiatan');
    Route::get('/progreskegiatan', [ClientController::class, 'progreskegiatan'])->name('client.progreskegiatan');
    Route::get('/petasebarankegiatan', [ClientController::class, 'petasebarankegiatan'])
        ->name('client.petasebarankegiatan');
});
Route::get('/progres-kegiatandetail/{id}', [ClientController::class, 'progreskegiatandetail'])->name('client.progreskegiatandetail');

Route::get('/regulasi-client', [ClientController::class, 'regulasi'])->name('client.regulasi');
Route::get('/detail-regulasi/{id}', [ClientController::class, 'detailregulasi'])->name('client.detailregulasi');

//detail card
Route::get('/detailluasperhutanan', [ClientController::class, 'detailluasperhutanan'])->name('client.detailluasperhutanan');
Route::get('/detail-kth', [ClientController::class, 'detailkth_kups'])->name('client.detailkth_kups');
Route::get('/detail-kups', [ClientController::class, 'detailkups'])->name('client.detailkups');
Route::get('/detail-ekonomi', [ClientController::class, 'detailekonomi'])->name('client.detailekonomi');

//detail berita&video
Route::get('/detail-informasi/{id}', [ClientController::class, 'detailinformasi'])->name('informasi.show');
Route::get('/detail-video', [ClientController::class, 'detailvideo'])->name('client.detailvideo');


Route::get('/daftar-potensi/{id}', [ClientController::class, 'daftarpotensi'])->name('client.daftarpotensi');
Route::get('/detail-potensi/{id}', [ClientController::class, 'detailpotensi'])
    ->name('client.detailpotensi');
Route::get('/kups/chart-data/{tahun}', [ClientController::class, 'chartData']);

Route::get('/footer', [ClientController::class, 'footer'])->name('client.footer');


//admin
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

Route::middleware(['authadmin', 'noCache'])->group(function () {

    Route::get('/admin', [DasboardAdminController::class, 'index'])->name('dashboard');

    Route::get('/banner', [BannerController::class, 'index'])->name('banner');
    Route::post('/banner-save', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner-edit/{id}', [BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banner-update/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('/banner-delete/{id}', [BannerController::class, 'destroy'])->name('banner.delete');

    Route::get('/gambaran-umum', [GambaranUmumController::class, 'index'])->name('gambaran');
    Route::post('/gambaran-create', [GambaranUmumController::class, 'store'])->name('creategambaran');
    Route::put('/gambaran-update/{id}', [GambaranUmumController::class, 'update'])->name('updategambaran');
    Route::delete('/gambaran-delete/{id}', [GambaranUmumController::class, 'destroy'])->name('deletegambaran');

    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
    Route::get('/informasi-create', [InformasiController::class, 'create'])->name('informasicreate');
    Route::post('/informasi-sive', [InformasiController::class, 'store'])->name('informasi.store');
    Route::get('/informasi-edit/{id}', [InformasiController::class, 'edit'])->name('informasi.edit');
    Route::put('/informasi-update/{id}', [InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/hapusInformasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.delete');

    Route::get('/video', [VideoController::class, 'index'])->name('video');
    Route::post('/video-create', [VideoController::class, 'store'])->name('video.store');
    Route::get('/video-edit/{id}', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('/video-update/{id}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('/video-delete/{id}', [VideoController::class, 'destroy'])->name('deletevideo');

    Route::get('/kth', [KthController::class, 'index'])->name('kth');
    Route::post('/kth-store', [KthController::class, 'store'])->name('kth.store');
    Route::get('/kth-edit/{id}', [KthController::class, 'edit'])->name('kth.edit');
    Route::put('/kth-update/{id}', [KthController::class, 'update'])->name('kth.update');
    Route::delete('/kth-delete/{id}', [KthController::class, 'destroy'])->name('kth.delete');

    Route::get('/kups', [KupsController::class, 'index'])->name('kups');
    Route::post('/kups-store', [KupsController::class, 'store'])->name('kups.store');
    Route::get('/kups-edit/{id}', [KupsController::class, 'edit'])->name('kups.edit');
    Route::put('/kups-update/{id}', [KupsController::class, 'update'])->name('kups.update');
    Route::delete('/kups-delete/{id}', [KupsController::class, 'destroy'])->name('kups.delete');

    Route::get('/produk-kups', [ProdukKupsController::class, 'index'])->name('produkKups');
    Route::post('/produk-kups', [ProdukKupsController::class, 'store'])->name('produkKups.store');
    Route::get('/produk-kups/{id}', [ProdukKupsController::class, 'edit'])->name('produkKups.edit');
    Route::put('/produk-kups/{id}', [ProdukKupsController::class, 'update'])->name('produkKups.update');
    Route::delete('/produk-kups/{id}', [ProdukKupsController::class, 'destroy'])->name('produkKups.delete');

    Route::get('subpotensi-kehutanan', [SubpotensiKehutananController::class, 'index'])->name('SubpotensiKehutanan');
    Route::post('subpotensi-kehutanan', [SubpotensiKehutananController::class, 'store'])->name('subpotensi.store');
    Route::put('subpotensi-kehutanan/{id}', [SubpotensiKehutananController::class, 'update'])->name('subpotensi.update');
    Route::delete('subpotensi-kehutanan/{id}', [SubpotensiKehutananController::class, 'destroy'])->name('subpotensi.delete');

    // Route::get('potensi-kehutanan', [SubpotensiKehutananController::class, 'index'])->name('SubpotensiKehutanan');
    Route::post('potensi-kehutanan', [SubpotensiKehutananController::class, 'potensiKehutananStore'])->name('potensikehutanan.store');
    Route::put('potensi-kehutanan/update/{id}', [SubpotensiKehutananController::class, 'potensiKehutananUpdate'])->name('potensikehutanan.update');
    Route::delete('potensi-kehutanan/delete/{id}', [SubpotensiKehutananController::class, 'potensiKehutananDelete'])->name('potensikehutanan.delete');



    Route::get('/subProgram', [SubProgramController::class, 'index'])->name('subprogram');
    Route::post('/subprogram-create', [SubProgramController::class, 'store'])->name('subrogram.store');
    Route::post('/store-produk', [SubProgramController::class, 'storeProduk'])->name('produk.store');
    Route::put('/subprogram-update/{id}', [SubProgramController::class, 'update'])->name('subprogram.update');
    Route::delete('/supprogram-delete/{id}', [SubProgramController::class, 'destroy'])->name('subrogram.delete');
    Route::put('/sub-produk-update/{id}', [SubProgramController::class, 'updateProduk'])->name('update.produk');
    Route::delete('/sub-produk/{id}/delete', [SubProgramController::class, 'destroyProduk'])->name('delete.produk');


    Route::get('/rencan-aksi', [RencanaAksi_6TahunController::class, 'index'])->name('rencana6tahun');
    Route::get('/rencana-aksi/export-excel', [RencanaAksi_6TahunController::class, 'exportExcelAksi'])
        ->name('rencanaAksi.export.excel');
    Route::get('/rencan-aksi-create', [RencanaAksi_6TahunController::class, 'create'])->name('rencanaAksi.create');
    Route::post('/rencan-aksi-save', [RencanaAksi_6TahunController::class, 'store'])->name('rencanaAksi.store');
    Route::get('/rencan-aksi-edit/{id}', [RencanaAksi_6TahunController::class, 'edit'])->name('rencanaAksi.edit');
    Route::put('/rencan-aksi-update/{id}', [RencanaAksi_6TahunController::class, 'update'])->name('rencanaAksi.update');
    Route::delete('/rencan-aksi-delete/{id}', [RencanaAksi_6TahunController::class, 'destroy'])->name('rencanaAksi.destroy');

    Route::get('/rencan-kerja', [RencanakerjaController::class, 'index'])->name('rencanakerja');
    Route::get('/rencana/export-excel', [RencanakerjaController::class, 'exportExcel'])
        ->name('rencana.export.excel');
    Route::get('/get-rencana-aksi/{id_subprogram}', [RencanakerjaController::class, 'getRencanaAksi'])
        ->name('get.rencana.aksi');
    Route::get('/get-detail-rencana-aksi/{id}', [RencanakerjaController::class, 'getDetail']);
    Route::get('/rencana-create', [RencanakerjaController::class, 'create'])->name('rencana.create');
    Route::post('/rencana-store', [RencanakerjaController::class, 'store'])->name('rencana.store');
    Route::put('/rencana/{id}/validasi', [RencanakerjaController::class, 'updateStatus'])->name('rencana.validasi');
    Route::get('/rencana-kerja/{id}', [RencanakerjaController::class, 'show'])->name('rencana.show');
    Route::get('/rencana-edit/{id}', [RencanakerjaController::class, 'edit'])->name('rencana.edit');
    Route::put('/rencana-update/{id}', [RencanakerjaController::class, 'update'])->name('rencana.update');
    Route::delete('/rencana-delete/{id}', [RencanakerjaController::class, 'destroy'])->name('rencana.delete');

    Route::get('/progres', [ProgreskerjaController::class, 'index'])->name('progres');
    Route::get('/progres-create', [ProgreskerjaController::class, 'create'])->name('progrescreate');
    Route::post('/progres-sive', [ProgreskerjaController::class, 'store'])->name('progres.store');
    Route::put('/progres/{id}/status', [ProgreskerjaController::class, 'updateStatus'])->name('progres.updateStatus');
    Route::get('/progres/{id}', [ProgresKerjaController::class, 'show'])->name('progres.show');
    Route::get('/progres-edit/{id}', [ProgreskerjaController::class, 'edit'])->name('progres.edit');
    Route::put('/progres-update/{id}', [ProgreskerjaController::class, 'update'])->name('progres.update');
    Route::delete('/progres-delete/{id}', [ProgreskerjaController::class, 'destroy'])->name('progres.delete');


    Route::get('/monev', [MonevController::class, 'index'])->name('monev');
    Route::get('/monev-create', [MonevController::class, 'create'])->name('monev.create');
    Route::get('/get-rencana-kerja/{id_subprogram}', [MonevController::class, 'getRencanaKerja']);
    Route::get('/get-detail-rencana-kerja/{id}', [MonevController::class, 'getDetailRencanaKerja']);
    Route::post('/monev-sive', [MonevController::class, 'store'])->name('monev.store');
    Route::post('/monev/{id}/lanjut', [MonevController::class, 'lanjut'])->name('monev.lanjut');
    Route::put('/monev/{id}/pesan', [MonevController::class, 'updatePesan'])->name('monev.pesan');
    Route::get('/monev/export', [MonevController::class, 'exportPDF'])->name('monev.export');
    Route::put('/monev/{id}/validasi', [MonevController::class, 'updateStatus'])->name('monev.validasi');
    Route::get('/monev-edit/{id}', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/monev-update/{id}', [MonevController::class, 'update'])->name('monev.update');
    Route::delete('/monev-delete/{id}', [MonevController::class, 'destroy'])->name('monev.delete');

    // Route::get('/potensi', [PotensiController::class, 'index'])->name('potensi');
    Route::get('/potensi', [PotensiController::class, 'index'])->name('potensi');
    Route::get('/potensi-create', [PotensiController::class, 'create'])->name('potensi.create');
    Route::post('/potensi-store', [PotensiController::class, 'store'])->name('potensi.store');
    Route::get('/get-desa/{code}', [PotensiController::class, 'getDesa'])->name('get-desa');
    Route::get('/potensi-edit/{id}', [PotensiController::class, 'edit'])->name('potensi.edit');
    Route::put('/potensi-update/{id}', [PotensiController::class, 'update'])->name('potensi.update');
    Route::delete('/potensi-delete/{id}', [PotensiController::class, 'destroy'])->name('potensi.destroy');

    Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi');
    Route::get('/regulasi-create', [RegulasiController::class, 'create'])->name('regulasi.create');
    Route::post('/regulasi-store', [RegulasiController::class, 'store'])->name('regulasi.store');
    Route::get('/regulasi-edit/{id}', [RegulasiController::class, 'edit'])->name('regulasi.edit');
    Route::put('/regulasi-update/{id}', [RegulasiController::class, 'update'])->name('regulasi.update');
    Route::delete('regulasi-delete/{id}', [RegulasiController::class, 'destroy'])->name('regulasi.delete');

    Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');;
    Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

    Route::get('/opd', [OpdController::class, 'index'])->name('opd');
    Route::post('/opd-store', [OpdController::class, 'store'])->name('opd.store');
    Route::put('/opd-update/{id}', [OpdController::class, 'update'])->name('opd.update');
    Route::delete('/opd-delete/{id}', [OpdController::class, 'destroy'])->name('opd.destroy');

    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/pengguna-create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna-store', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna-edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna-update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna-delete/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas');
    Route::post('/ganti-password', [LoginController::class, 'update_password'])->name('update.password');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
