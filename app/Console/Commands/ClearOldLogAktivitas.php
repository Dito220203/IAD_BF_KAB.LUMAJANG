<?php

namespace App\Console\Commands;

use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearOldLogAktivitas extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logaktivitas:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus log aktivitas yang lebih dari 1 bulan';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $deleted = \App\Models\LogAktivitas::where('created_at', '<', now()->subMonth())->delete();

        LogAktivitas::info("Command logaktivitas:clear jalan. Terhapus: $deleted data pada " . now());
    }
}
