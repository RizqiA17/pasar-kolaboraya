<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the notification system by creating a sample notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return 1;
            }
        } else {
            $user = User::first();
            if (!$user) {
                $this->error("No users found in the database.");
                return 1;
            }
        }

        $notificationService = new NotificationService();

        // Create a test notification
        $notification = $notificationService->createNotification(
            $user,
            'Test Notification',
            'This is a test notification to verify the notification system is working properly.',
            route('notifications.index'),
            [
                'type' => 'test',
                'test_data' => 'This is test data'
            ]
        );

        $this->info("Test notification created successfully!");
        $this->info("Notification ID: {$notification->id}");
        $this->info("User: {$user->name} ({$user->email})");
        $this->info("Title: {$notification->title}");
        $this->info("Message: {$notification->message}");

        return 0;
    }
}
