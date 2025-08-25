<?php

use App\Http\Controllers\BannerConroller;
use App\Http\Controllers\DasboardAdminController;
use App\Http\Controllers\GambaranUmumController;
use App\Http\Controllers\InformasiConroller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgreskerjaController;
use App\Http\Controllers\SubProgramController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

//client
Route::get('/', [ClientController::class, 'index'])->name('client');




Route::get('/Login',[LoginController::class,'index'])->name('login');
Route::get('/admin',[DasboardAdminController::class,'index'])->name('dashboard');




Route::get('/Banner', [BannerConroller::class, 'index'])->name('banner');
Route::get('/TambahBanner', [BannerConroller::class, 'create'])->name('create.banner');
Route::post('/Save', [BannerConroller::class, 'store'])->name('banner.store');
Route::get('/banner/{id}/edit', [BannerConroller::class, 'edit'])->name('banner.edit');
Route::put('/banner/{id}', [BannerConroller::class, 'update'])->name('update.banner');
Route::delete('/Delete/{id}', [BannerConroller::class, 'destroy'])->name('banner.delete');

Route::get('/GambaranUmum', [GambaranUmumController::class, 'index'])->name('gambaran');
Route::post('/CreateGambaranUmum', [GambaranUmumController::class, 'store'])->name('creategambaran');
Route::put('/UpdateGambaranUmum/{id}', [GambaranUmumController::class, 'update'])->name('updategambaran');
Route::delete('/DeleteGambaranUmum/{id}', [GambaranUmumController::class, 'destroy'])->name('deletegambaran');

Route::get('/Informasi', [InformasiConroller::class, 'index'])->name('informasi');
Route::get('/TambahInformasi', [InformasiConroller::class, 'create'])->name('informasicreate');
Route::post('/TambahInformasi', [InformasiConroller::class, 'store'])->name('informasi.store');
Route::get('/Informasi/{id}/Edit', [InformasiConroller::class, 'edit'])->name('informasi.edit');
Route::put('/Informasi/{id}/Update', [InformasiConroller::class, 'update'])->name('informasi.update');
Route::delete('/HapusInformasi/{id}', [InformasiConroller::class, 'destroy'])->name('informasi.delete');

Route::get('/Video', [VideoController::class, 'index'])->name('video');
Route::get('/TambahVideo', [VideoController::class, 'create'])->name('createvideo');
Route::post('/TambahVideo', [VideoController::class, 'store'])->name('storevideo');
Route::get('/Edit/{id}', [VideoController::class, 'edit'])->name('video.edit');
Route::put('/Update/{id}', [VideoController::class, 'update'])->name('video.update');
Route::delete('/DeleteVideo/{id}', [VideoController::class, 'destroy'])->name('deletevideo');

Route::get('/SubProgram', [SubProgramController::class, 'index'])->name('subprogram');
Route::post('/create', [SubProgramController::class, 'store'])->name('subrogram.store');

Route::get('/Progres', [ProgreskerjaController::class, 'index'])->name('progres');
Route::get('/TambahProgres', [ProgreskerjaController::class, 'create'])->name('progrescreate');
