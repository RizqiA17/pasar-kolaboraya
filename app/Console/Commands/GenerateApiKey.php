<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use Illuminate\Console\Command;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate-key 
                            {--name=Local App : The name of the API key}
                            {--show-secret : Show the API secret}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API key for application-to-application access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $showSecret = $this->option('show-secret');

        // Generate API key
        $apiKey = ApiKey::generate($name);

        $this->info('API Key generated successfully!');
        $this->line('');
        $this->line('Name: ' . $apiKey->name);
        $this->line('Key: ' . $apiKey->key);
        $this->line('Expires: ' . $apiKey->expires_at->format('Y-m-d H:i:s'));
        $this->line('');

        if ($showSecret) {
            $this->warn('⚠️  IMPORTANT: Save this secret securely. It will not be shown again!');
            $this->line('');
            $this->line('Secret:');
            $this->line($apiKey->secret);
            $this->line('');
        }

        $this->info('Use these headers in your API requests:');
        $this->line('X-API-Key: ' . $apiKey->key);
        if ($showSecret) {
            $this->line('X-API-Secret: ' . $apiKey->secret);
        }
        $this->line('');

        $this->info('Example cURL request:');
        $this->line('curl -X GET \\');
        $this->line('  http://yourdomain.com/api/v1/app/users \\');
        $this->line('  -H "X-API-Key: ' . $apiKey->key . '" \\');
        if ($showSecret) {
            $this->line('  -H "X-API-Secret: ' . $apiKey->secret . '" \\');
        }
        $this->line('  -H "Accept: application/json"');

        return Command::SUCCESS;
    }
}

