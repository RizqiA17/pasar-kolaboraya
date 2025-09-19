<?php

namespace App\Console\Commands;

use App\Models\ConnectionQr;
use Illuminate\Console\Command;

class CleanupExpiredConnectionQrs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connection-qr:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired connection QR codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedCount = ConnectionQr::cleanupExpired();
        
        $this->info("Cleaned up {$deletedCount} expired connection QR codes.");
        
        return Command::SUCCESS;
    }
}