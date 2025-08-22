<?php

use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\GambaranUmumController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonevController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PotensiController;
use App\Http\Controllers\ProgreskerjaController;
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\RencanakerjaController;
use App\Http\Controllers\SubProgramController;
use App\Http\Controllers\VideoController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Kontak;
use App\Models\Monev;
use App\Models\Pengguna;
use App\Models\Regulasi;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;




// Admin
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');


Route::middleware(['authadmin', 'noCache'])->group(function () {

    Route::get('/admin', [DasboardAdminController::class, 'index'])->name('dashboard');

    Route::get('/Banner', [BannerController::class, 'index'])->name('banner');
    // Route::get('/TambahBanner', [BannerController::class, 'create'])->name('create.banner');
    Route::post('/Save', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner/{id}/edit', [BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banner/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('/banner/{id}/delete', [BannerController::class, 'destroy'])->name('banner.delete');

    Route::get('/gambaranumum', [GambaranUmumController::class, 'index'])->name('gambaran');
    Route::post('/create-gambaranUmum', [GambaranUmumController::class, 'store'])->name('creategambaran');
    Route::put('/update-gambaranUmum/{id}', [GambaranUmumController::class, 'update'])->name('updategambaran');
    Route::delete('/delete-gambaranUmum/{id}', [GambaranUmumController::class, 'destroy'])->name('deletegambaran');

    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
    Route::get('/tambah-informasi', [InformasiController::class, 'create'])->name('informasicreate');
    Route::post('/sive-informasi', [InformasiController::class, 'store'])->name('informasi.store');
    Route::get('/informasi/{id}/Edit', [InformasiController::class, 'edit'])->name('informasi.edit');
    Route::put('/informasi/{id}/Update', [InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/HapusInformasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.delete');

    Route::get('/Video', [VideoController::class, 'index'])->name('video');
    Route::post('/TambahVideo', [VideoController::class, 'store'])->name('video.store');
    Route::get('/Edit/{id}', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('/Update/{id}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('/DeleteVideo/{id}', [VideoController::class, 'destroy'])->name('deletevideo');

    Route::get('/kth', [KthController::class, 'index'])->name('kth');
    Route::post('/kth-store', [KthController::class, 'store'])->name('kth.store');
    Route::get('/kth-edit/{id}', [KthController::class, 'edit'])->name('kth.edit');
    Route::put('/kth-update/{id}', [KthController::class, 'update'])->name('kth.update');
    Route::delete('/kth-delete/{id}', [KthController::class, 'destroy'])->name('kth.delete');

    Route::get('/SubProgram', [SubProgramController::class, 'index'])->name('subprogram');
    Route::post('/create', [SubProgramController::class, 'store'])->name('subrogram.store');
    Route::put('/Subprogram/{id}/update', [SubProgramController::class, 'update'])->name('subprogram.update');
    Route::delete('/Supprogram/{id}/delete', [SubProgramController::class, 'destroy'])->name('subrogram.delete');

    Route::get('/RencanKerja', [RencanakerjaController::class, 'index'])->name('rencanakerja');
    Route::get('/Rencana/create', [RencanakerjaController::class, 'create'])->name('rencana.create');
    Route::post('/Rencana/store', [RencanakerjaController::class, 'store'])->name('rencana.store');
    Route::put('/rencana/{id}/validasi', [RencanakerjaController::class, 'updateStatus'])->name('rencana.validasi');
    Route::get('/rencanakerja/{id}', [RencanakerjaController::class, 'show'])->name('rencana.show');
    Route::get('/rencana/edit/{id}', [RencanakerjaController::class, 'edit'])->name('rencana.edit');
    Route::put('/rencana/{id}/update', [RencanakerjaController::class, 'update'])->name('rencana.update');
    Route::delete('/Delete/{id}', [RencanakerjaController::class, 'destroy'])->name('rencana.delete');

    Route::get('/Progres', [ProgreskerjaController::class, 'index'])->name('progres');
    Route::get('/TambahProgres', [ProgreskerjaController::class, 'create'])->name('progrescreate');
    Route::post('/Progres/sive', [ProgreskerjaController::class, 'store'])->name('progres.store');
    Route::put('/progres/{id}/status', [ProgreskerjaController::class, 'updateStatus'])->name('progres.updateStatus');
    Route::get('/progres/{id}', [ProgresKerjaController::class, 'show'])->name('progres.show');
    Route::get('/Progres/edit/{id}', [ProgreskerjaController::class, 'edit'])->name('progres.edit');
    Route::put('/Progres/update/{id}', [ProgreskerjaController::class, 'update'])->name('progres.update');
    Route::delete('/Progres/delete/{id}', [ProgreskerjaController::class, 'destroy'])->name('progres.delete');

    Route::get('/Monev', [MonevController::class, 'index'])->name('monev');
    Route::get('/create-monev', [MonevController::class, 'create'])->name('monev.create');
    Route::post('/sive-monev', [MonevController::class, 'store'])->name('monev.store');
    Route::put('/monev/{id}/validasi', [MonevController::class, 'updateStatus'])->name('monev.validasi');
    Route::get('/monev-edit/{id}', [MonevController::class, 'edit'])->name('monev.edit');
    Route::put('/monev-update/{id}', [MonevController::class, 'update'])->name('monev.update');
    Route::get('/monev-show/{id}', [MonevController::class, 'show'])->name('monev.show');
    Route::delete('/monev-delete/{id}', [MonevController::class, 'destroy'])->name('monev.delete');

    Route::get('/Potensi', [PotensiController::class, 'index'])->name('potensi');
    Route::get('/potensi/create', [PotensiController::class, 'create'])->name('potensi.create');
    Route::get('/Potensi', [PotensiController::class, 'index'])->name('potensi');
    Route::post('/potensi/store', [PotensiController::class, 'store'])->name('potensi.store');
    Route::get('/get-desa/{id_kec}', [PotensiController::class, 'getDesa']);
    Route::get('/potensi/edit/{id}', [PotensiController::class, 'edit'])->name('potensi.edit');
    Route::put('/potensi/update/{id}', [PotensiController::class, 'update'])->name('potensi.update');
    Route::delete('/potensi/delete/{id}', [PotensiController::class, 'destroy'])->name('potensi.destroy');

    Route::get('/Regulasi', [RegulasiController::class, 'index'])->name('regulasi');
    Route::get('/Regulasi/create', [RegulasiController::class, 'create'])->name('regulasi.create');
    Route::post('/Regulasi/store', [RegulasiController::class, 'store'])->name('regulasi.store');
    Route::get('/Regulasi/edit/{id}', [RegulasiController::class, 'edit'])->name('regulasi.edit');
    Route::put('/Regulasi/update/{id}', [RegulasiController::class, 'update'])->name('regulasi.update');
    Route::delete('Regulasi/delete/{id}', [RegulasiController::class, 'destroy'])->name('regulasi.delete');

    Route::get('/Kontak', [KontakController::class, 'index'])->name('kontak');;
    Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

    Route::get('/Opd', [OpdController::class, 'index'])->name('opd');
    Route::post('/Opd/store', [OpdController::class, 'store'])->name('opd.store');
    Route::put('/Opd/update/{id}', [OpdController::class, 'update'])->name('opd.update');
    Route::delete('/Opd/delete/{id}', [OpdController::class, 'destroy'])->name('opd.destroy');

    Route::get('/Pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/store', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/delete/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
