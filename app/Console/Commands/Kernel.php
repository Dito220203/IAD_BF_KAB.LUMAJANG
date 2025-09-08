<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftarkan command artisan kustom di sini.
     */
    protected $commands = [
        //
    ];

    /**
     * Definisikan schedule untuk command artisan.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan tiap bulan sekali
        // $schedule->command('logaktivitas:clear')->monthly();
        $schedule->command('logaktivitas:clear')->everyMinute();
    }

    /**
     * Daftarkan closure-based commands.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
