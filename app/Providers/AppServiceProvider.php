<?php

namespace App\Providers;

use App\Models\Kecamatan;
use App\Models\Potensi;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('componentsclient.navbar', function ($view) {
            // Ambil kecamatan yang ada di potensi
            $kecamatanIds = Potensi::distinct('id_kecamatan')->pluck('id_kecamatan');
            $kecamatan = Kecamatan::whereIn('id', $kecamatanIds)->get();

            // Ambil potensi terakhir / tertentu untuk default desa
            $potensi = Potensi::latest()->first(); // Bisa ganti kriteria sesuai kebutuhan

            $view->with([
                'kecamatan' => $kecamatan,
                'selectedKecamatan' => $potensi->id_kecamatan ?? null,
                'selectedDesa' => $potensi->id_desa ?? null,
            ]);
        });
    }
}
