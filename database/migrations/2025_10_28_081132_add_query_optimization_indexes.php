<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Check if index exists
     */
    private function indexExists($table, $indexName): bool
    {
        $indexes = \DB::select("SHOW INDEX FROM {$table}");
        foreach ($indexes as $index) {
            if ($index->Key_name === $indexName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for ecosystem queries
        Schema::table('ecosystems', function (Blueprint $table) {
            // Check if indexes don't exist before adding them
            if (!$this->indexExists('ecosystems', 'ecosystems_is_active_pasar_kolaboraya_id_index')) {
                $table->index(['is_active', 'pasar_kolaboraya_id']);
            }
            if (!$this->indexExists('ecosystems', 'ecosystems_creator_id_is_active_index')) {
                $table->index(['creator_id', 'is_active']);
            }
            if (!$this->indexExists('ecosystems', 'ecosystems_work_region_index')) {
                $table->index(['work_region']);
            }
            if (!$this->indexExists('ecosystems', 'ecosystems_created_at_index')) {
                $table->index(['created_at']);
            }
        });

        // Add indexes for user queries
        Schema::table('users', function (Blueprint $table) {
            if (!$this->indexExists('users', 'users_active_pasar_kolaboraya_id_index')) {
                $table->index(['active_pasar_kolaboraya_id']);
            }
            if (!$this->indexExists('users', 'users_is_ecosystem_builder_ecosystem_builder_status_index')) {
                $table->index(['is_ecosystem_builder', 'ecosystem_builder_status']);
            }
            if (!$this->indexExists('users', 'users_assigned_role_index')) {
                $table->index(['assigned_role']);
            }
            if (!$this->indexExists('users', 'users_created_at_index')) {
                $table->index(['created_at']);
            }
        });

        // Add indexes for ecosystem_users pivot table
        Schema::table('ecosystem_users', function (Blueprint $table) {
            if (!$this->indexExists('ecosystem_users', 'ecosystem_users_ecosystem_id_status_index')) {
                $table->index(['ecosystem_id', 'status']);
            }
            if (!$this->indexExists('ecosystem_users', 'ecosystem_users_user_id_status_index')) {
                $table->index(['user_id', 'status']);
            }
        });

        // Add indexes for profiles table
        Schema::table('profiles', function (Blueprint $table) {
            if (!$this->indexExists('profiles', 'profiles_user_id_index')) {
                $table->index(['user_id']);
            }
            if (!$this->indexExists('profiles', 'profiles_peran_id_index')) {
                $table->index(['peran_id']);
            }
        });

        // Add indexes for connections table
        Schema::table('connections', function (Blueprint $table) {
            if (!$this->indexExists('connections', 'connections_requester_id_status_index')) {
                $table->index(['requester_id', 'status']);
            }
            if (!$this->indexExists('connections', 'connections_receiver_id_status_index')) {
                $table->index(['receiver_id', 'status']);
            }
            if (!$this->indexExists('connections', 'connections_pasar_kolaboraya_id_status_index')) {
                $table->index(['pasar_kolaboraya_id', 'status']);
            }
        });

        // Add indexes for collective_actions table
        Schema::table('collective_actions', function (Blueprint $table) {
            if (!$this->indexExists('collective_actions', 'collective_actions_created_by_status_index')) {
                $table->index(['created_by', 'status']);
            }
            if (!$this->indexExists('collective_actions', 'collective_actions_pasar_kolaboraya_id_status_index')) {
                $table->index(['pasar_kolaboraya_id', 'status']);
            }
            if (!$this->indexExists('collective_actions', 'collective_actions_created_at_index')) {
                $table->index(['created_at']);
            }
        });

        // Add indexes for ecosystem_contributions table
        Schema::table('ecosystem_contributions', function (Blueprint $table) {
            if (!$this->indexExists('ecosystem_contributions', 'ecosystem_contributions_ecosystem_id_status_index')) {
                $table->index(['ecosystem_id', 'status']);
            }
            if (!$this->indexExists('ecosystem_contributions', 'ecosystem_contributions_user_id_status_index')) {
                $table->index(['user_id', 'status']);
            }
        });

        // Add indexes for ecosystem_likes table
        Schema::table('ecosystem_likes', function (Blueprint $table) {
            if (!$this->indexExists('ecosystem_likes', 'ecosystem_likes_ecosystem_id_index')) {
                $table->index(['ecosystem_id']);
            }
            if (!$this->indexExists('ecosystem_likes', 'ecosystem_likes_user_id_index')) {
                $table->index(['user_id']);
            }
        });

        // Add composite indexes for complex queries
        Schema::table('ecosystems', function (Blueprint $table) {
            if (!$this->indexExists('ecosystems', 'ecosystems_is_active_pasar_kolaboraya_id_created_at_index')) {
                $table->index(['is_active', 'pasar_kolaboraya_id', 'created_at']);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!$this->indexExists('users', 'users_active_pasar_kolaboraya_id_created_at_index')) {
                $table->index(['active_pasar_kolaboraya_id', 'created_at']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove ecosystem indexes
        Schema::table('ecosystems', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'pasar_kolaboraya_id']);
            $table->dropIndex(['creator_id', 'is_active']);
            $table->dropIndex(['work_region']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['is_active', 'pasar_kolaboraya_id', 'created_at']);
        });

        // Remove user indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['active_pasar_kolaboraya_id']);
            $table->dropIndex(['is_ecosystem_builder', 'ecosystem_builder_status']);
            $table->dropIndex(['assigned_role']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['active_pasar_kolaboraya_id', 'created_at']);
        });

        // Remove pivot table indexes
        Schema::table('ecosystem_users', function (Blueprint $table) {
            $table->dropIndex(['ecosystem_id', 'status']);
            $table->dropIndex(['user_id', 'status']);
        });

        // Remove profile indexes
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['peran_id']);
        });

        // Remove connection indexes
        Schema::table('connections', function (Blueprint $table) {
            $table->dropIndex(['requester_id', 'status']);
            $table->dropIndex(['receiver_id', 'status']);
            $table->dropIndex(['pasar_kolaboraya_id', 'status']);
        });

        // Remove collective action indexes
        Schema::table('collective_actions', function (Blueprint $table) {
            $table->dropIndex(['creator_id', 'status']);
            $table->dropIndex(['pasar_kolaboraya_id', 'status']);
            $table->dropIndex(['created_at']);
        });

        // Remove contribution indexes
        Schema::table('ecosystem_contributions', function (Blueprint $table) {
            $table->dropIndex(['ecosystem_id', 'status']);
            $table->dropIndex(['user_id', 'status']);
        });

        // Remove like indexes
        Schema::table('ecosystem_likes', function (Blueprint $table) {
            $table->dropIndex(['ecosystem_id']);
            $table->dropIndex(['user_id']);
        });
    }
};
