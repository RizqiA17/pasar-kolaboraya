<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate-token 
                            {user_id : The ID of the user}
                            {--name=api-token : The name of the token}
                            {--show-secret : Show the API shared secret}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API token for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $tokenName = $this->option('name');
        $showSecret = $this->option('show-secret');

        // Find user
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found!");
            return Command::FAILURE;
        }

        // Generate token
        $token = $user->createToken($tokenName)->plainTextToken;

        $this->info('API Token generated successfully!');
        $this->line('');
        $this->line('User: ' . $user->name . ' (' . $user->email . ')');
        $this->line('Token Name: ' . $tokenName);
        $this->line('');
        $this->warn('⚠️  IMPORTANT: Save this token securely. It will not be shown again!');
        $this->line('');
        $this->line('Token:');
        $this->line($token);
        $this->line('');

        if ($showSecret) {
            $secret = config('services.api.shared_secret');
            if ($secret) {
                $this->line('API Shared Secret:');
                $this->line($secret);
                $this->line('');
            } else {
                $this->warn('⚠️  API_SHARED_SECRET is not set in .env file!');
            }
        }

        $this->info('Use this token in your API requests:');
        $this->line('Authorization: Bearer ' . $token);
        $this->line('');

        return Command::SUCCESS;
    }
}

