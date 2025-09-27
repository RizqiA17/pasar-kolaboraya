<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\ConnectionSuccess;
use App\Models\User;
use App\Services\NotificationService;

class TestConnectionNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:connection-notification {user1_id} {user2_id} {pasar_kolaboraya_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test connection notification system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user1Id = $this->argument('user1_id');
        $user2Id = $this->argument('user2_id');
        $pasarKolaborayaId = $this->argument('pasar_kolaboraya_id');

        $user1 = User::find($user1Id);
        $user2 = User::find($user2Id);

        if (!$user1 || !$user2) {
            $this->error('One or both users not found');
            return 1;
        }

        $this->info("Testing connection notification for users: {$user1->name} and {$user2->name}");

        // Test broadcasting
        $this->info('Broadcasting connection success event...');
        broadcast(new ConnectionSuccess($user1, $user2, $pasarKolaborayaId, 999));

        // Test notifications
        $this->info('Creating notifications...');
        $notificationService = app(NotificationService::class);
        
        $notificationService->createNotification(
            $user1,
            'Test Connection Success!',
            'Test notification for ' . $user2->name,
            null,
            ['connection_id' => 999, 'connected_user' => $user2->name]
        );

        $notificationService->createNotification(
            $user2,
            'Test Connection Success!',
            'Test notification for ' . $user1->name,
            null,
            ['connection_id' => 999, 'connected_user' => $user1->name]
        );

        $this->info('Test completed! Check the users\' notification pages and browser console for real-time updates.');
        
        return 0;
    }
}
