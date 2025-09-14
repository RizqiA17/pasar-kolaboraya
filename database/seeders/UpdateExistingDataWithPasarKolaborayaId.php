<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ecosystem;
use App\Models\Connection;
use App\Models\CollectiveAction;
use App\Models\PasarKolaboraya;
use Illuminate\Support\Facades\DB;

class UpdateExistingDataWithPasarKolaborayaId extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Updating existing data with pasar_kolaboraya_id...');

        // Get all active Pasar Kolaboraya sessions
        $sessions = PasarKolaboraya::active()->get();
        
        if ($sessions->isEmpty()) {
            $this->command->warn('No active Pasar Kolaboraya sessions found. Creating a default session...');
            
            // Create a default session
            $defaultSession = PasarKolaboraya::create([
                'name' => 'Default Session',
                'description' => 'Default session for existing data',
                'created_by' => User::first()->id ?? 1,
                'status' => 'active',
            ]);
            
            // Add all users to this default session
            $users = User::all();
            foreach ($users as $user) {
                $defaultSession->addUser($user, 'member');
                // Set as active session if user doesn't have one
                if (!$user->hasActivePasarKolaboraya()) {
                    $user->setActivePasarKolaboraya($defaultSession);
                }
            }
            
            $sessions = collect([$defaultSession]);
        }

        $defaultSessionId = $sessions->first()->id;

        // Update ecosystems without pasar_kolaboraya_id
        $ecosystemsUpdated = Ecosystem::whereNull('pasar_kolaboraya_id')
            ->update(['pasar_kolaboraya_id' => $defaultSessionId]);
        $this->command->info("Updated {$ecosystemsUpdated} ecosystems with pasar_kolaboraya_id");

        // Update connections without pasar_kolaboraya_id
        $connectionsUpdated = Connection::whereNull('pasar_kolaboraya_id')
            ->update(['pasar_kolaboraya_id' => $defaultSessionId]);
        $this->command->info("Updated {$connectionsUpdated} connections with pasar_kolaboraya_id");

        // Update collective actions without pasar_kolaboraya_id
        $collectiveActionsUpdated = CollectiveAction::whereNull('pasar_kolaboraya_id')
            ->update(['pasar_kolaboraya_id' => $defaultSessionId]);
        $this->command->info("Updated {$collectiveActionsUpdated} collective actions with pasar_kolaboraya_id");

        // Update users without active_pasar_kolaboraya_id
        $usersUpdated = User::whereNull('active_pasar_kolaboraya_id')
            ->update(['active_pasar_kolaboraya_id' => $defaultSessionId]);
        $this->command->info("Updated {$usersUpdated} users with active_pasar_kolaboraya_id");

        $this->command->info('Data update completed successfully!');
    }
}