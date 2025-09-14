<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profile;
use App\Models\PasarKolaboraya;
use App\Models\Ecosystem;
use App\Models\CollectiveAction;
use App\Models\Connection;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Seeder Data Integrity...\n\n";

// Test 1: Check if users have proper roles and ecosystem builder status
echo "1. Testing User data integrity...\n";
$users = User::all();
$superAdmins = User::where('role', 'super_admin')->count();
$admins = User::where('role', 'admin')->count();
$regularUsers = User::where('role', 'user')->count();
$ecosystemBuilders = User::where('is_ecosystem_builder', true)->count();

echo "   - Total users: {$users->count()}\n";
echo "   - Super admins: {$superAdmins}\n";
echo "   - Admins: {$admins}\n";
echo "   - Regular users: {$regularUsers}\n";
echo "   - Ecosystem builders: {$ecosystemBuilders}\n";

// Test 2: Check if profiles exist for all users
echo "\n2. Testing Profile data integrity...\n";
$profilesWithoutUsers = Profile::whereDoesntHave('user')->count();
$usersWithoutProfiles = User::whereDoesntHave('profile')->count();

echo "   - Profiles without users: {$profilesWithoutUsers}\n";
echo "   - Users without profiles: {$usersWithoutProfiles}\n";

// Test 3: Check Pasar Kolaboraya data
echo "\n3. Testing Pasar Kolaboraya data integrity...\n";
$pasarKolaborayas = PasarKolaboraya::all();
$activePasarKolaborayas = PasarKolaboraya::where('status', 'active')->count();
$usersWithActivePasarKolaboraya = User::whereNotNull('active_pasar_kolaboraya_id')->count();

echo "   - Total Pasar Kolaboraya: {$pasarKolaborayas->count()}\n";
echo "   - Active Pasar Kolaboraya: {$activePasarKolaborayas}\n";
echo "   - Users with active Pasar Kolaboraya: {$usersWithActivePasarKolaboraya}\n";

// Test 4: Check Ecosystem data
echo "\n4. Testing Ecosystem data integrity...\n";
$ecosystems = Ecosystem::all();
$activeEcosystems = Ecosystem::where('is_active', true)->count();
$ecosystemsWithPasarKolaboraya = Ecosystem::whereNotNull('pasar_kolaboraya_id')->count();

echo "   - Total ecosystems: {$ecosystems->count()}\n";
echo "   - Active ecosystems: {$activeEcosystems}\n";
echo "   - Ecosystems with Pasar Kolaboraya: {$ecosystemsWithPasarKolaboraya}\n";

// Test 5: Check Collective Action data
echo "\n5. Testing Collective Action data integrity...\n";
$collectiveActions = CollectiveAction::all();
$collectiveActionsWithPasarKolaboraya = CollectiveAction::whereNotNull('pasar_kolaboraya_id')->count();

echo "   - Total collective actions: {$collectiveActions->count()}\n";
echo "   - Collective actions with Pasar Kolaboraya: {$collectiveActionsWithPasarKolaboraya}\n";

// Test 6: Check Connection data
echo "\n6. Testing Connection data integrity...\n";
$connections = Connection::all();
$connectionsWithPasarKolaboraya = Connection::whereNotNull('pasar_kolaboraya_id')->count();

echo "   - Total connections: {$connections->count()}\n";
echo "   - Connections with Pasar Kolaboraya: {$connectionsWithPasarKolaboraya}\n";

// Test 7: Check foreign key relationships
echo "\n7. Testing foreign key relationships...\n";

// Check if all profiles have valid user_id
$invalidProfileUserIds = Profile::whereDoesntHave('user')->count();
echo "   - Profiles with invalid user_id: {$invalidProfileUserIds}\n";

// Check if all ecosystems have valid creator_id
$invalidEcosystemCreators = Ecosystem::whereDoesntHave('creator')->count();
echo "   - Ecosystems with invalid creator_id: {$invalidEcosystemCreators}\n";

// Check if all collective actions have valid created_by
$invalidCollectiveActionCreators = CollectiveAction::whereDoesntHave('creator')->count();
echo "   - Collective actions with invalid created_by: {$invalidCollectiveActionCreators}\n";

// Check if all connections have valid requester_id and receiver_id
$invalidConnectionRequesters = Connection::whereDoesntHave('requester')->count();
$invalidConnectionReceivers = Connection::whereDoesntHave('receiver')->count();
echo "   - Connections with invalid requester_id: {$invalidConnectionRequesters}\n";
echo "   - Connections with invalid receiver_id: {$invalidConnectionReceivers}\n";

echo "\nSeeder data integrity test completed!\n";
