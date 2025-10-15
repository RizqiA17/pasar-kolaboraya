<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if profiles table has organization and phone columns
        if (!Schema::hasColumn('profiles', 'organization') || !Schema::hasColumn('profiles', 'phone')) {
            Log::info('Profiles table does not have organization or phone columns. Skipping migration.');
            return;
        }

        // Check if users table has the new columns
        if (!Schema::hasColumn('users', 'organization_name') || !Schema::hasColumn('users', 'phone_number') || !Schema::hasColumn('users', 'organization_type')) {
            Log::error('Users table does not have the required columns. Please run the add_organization_and_phone_to_users_table migration first.');
            return;
        }

        // Count existing data before migration
        $profilesWithOrg = DB::table('profiles')
            ->whereNotNull('organization')
            ->where('organization', '!=', '')
            ->count();
            
        $profilesWithPhone = DB::table('profiles')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->count();

        Log::info("Found {$profilesWithOrg} profiles with organization data and {$profilesWithPhone} profiles with phone data");

        // Migrate organization data
        DB::statement("
            UPDATE users 
            INNER JOIN profiles ON users.id = profiles.user_id 
            SET 
                users.organization_name = profiles.organization,
                users.organization_type = CASE 
                    WHEN profiles.organization IS NOT NULL AND profiles.organization != '' THEN 'organisasi'
                    ELSE 'individu'
                END
            WHERE profiles.organization IS NOT NULL 
               AND profiles.organization != ''
               AND (users.organization_name IS NULL OR users.organization_name = '')
        ");

        // Migrate phone data
        DB::statement("
            UPDATE users 
            INNER JOIN profiles ON users.id = profiles.user_id 
            SET 
                users.phone_number = profiles.phone
            WHERE profiles.phone IS NOT NULL 
               AND profiles.phone != ''
               AND (users.phone_number IS NULL OR users.phone_number = '')
        ");

        // Set organization_type to 'individu' for users without organization data
        DB::statement("
            UPDATE users 
            SET organization_type = 'individu'
            WHERE organization_type IS NULL 
               OR organization_type = ''
        ");

        // Log the migration results
        $migratedUsers = DB::table('users')
            ->whereNotNull('organization_name')
            ->orWhereNotNull('phone_number')
            ->count();

        $usersWithOrg = DB::table('users')
            ->whereNotNull('organization_name')
            ->where('organization_name', '!=', '')
            ->count();
            
        $usersWithPhone = DB::table('users')
            ->whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->count();

        Log::info("Migration completed: {$migratedUsers} users updated. {$usersWithOrg} users have organization data, {$usersWithPhone} users have phone data");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if profiles table has organization and phone columns
        if (!Schema::hasColumn('profiles', 'organization') || !Schema::hasColumn('profiles', 'phone')) {
            Log::info('Profiles table does not have organization or phone columns. Cannot rollback migration.');
            return;
        }

        // Count data before rollback
        $usersWithOrg = DB::table('users')
            ->whereNotNull('organization_name')
            ->where('organization_name', '!=', '')
            ->count();
            
        $usersWithPhone = DB::table('users')
            ->whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->count();

        Log::info("Rolling back migration: Found {$usersWithOrg} users with organization data and {$usersWithPhone} users with phone data");

        // Move organization data back to profiles table
        DB::statement("
            UPDATE profiles 
            INNER JOIN users ON profiles.user_id = users.id 
            SET 
                profiles.organization = users.organization_name
            WHERE users.organization_name IS NOT NULL 
               AND users.organization_name != ''
               AND (profiles.organization IS NULL OR profiles.organization = '')
        ");

        // Move phone data back to profiles table
        DB::statement("
            UPDATE profiles 
            INNER JOIN users ON profiles.user_id = users.id 
            SET 
                profiles.phone = users.phone_number
            WHERE users.phone_number IS NOT NULL 
               AND users.phone_number != ''
               AND (profiles.phone IS NULL OR profiles.phone = '')
        ");

        // Clear the migrated data from users table
        DB::table('users')->update([
            'organization_name' => null,
            'phone_number' => null,
            'organization_type' => null
        ]);

        Log::info("Migration rolled back: Organization and phone data moved back to profiles table");
    }
};