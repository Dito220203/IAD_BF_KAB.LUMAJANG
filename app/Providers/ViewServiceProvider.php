<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\RencanaKerja;
use App\Models\ProgresKerja;
use App\Models\Monev;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share $notifikasi ke view components.navbar
        View::composer('components.navbar', function ($view) {
            $rencana = RencanaKerja::where('status', '!=', 'Valid')
                ->latest()
                ->take(5)
                ->get();

            $progres = ProgresKerja::where('status', '!=', 'Valid')
                ->latest()
                ->take(5)
                ->get();

            $monev = Monev::where('status', '!=', 'Valid')
                ->latest()
                ->take(5)
                ->get();

            $notifikasi = $rencana
                ->concat($progres)
                ->concat($monev)
                ->sortByDesc('created_at')
                ->take(5);

            $view->with('notifikasi', $notifikasi);
        });
    }
}
