<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing_roles and needed_roles to use peran IDs instead of skill names
        // This migration will convert the existing data structure
        
        // First, let's get all ecosystems and update their roles
        $ecosystems = \App\Models\Ecosystem::all();
        
        foreach ($ecosystems as $ecosystem) {
            $existingRoles = $ecosystem->existing_roles ?? [];
            $neededRoles = $ecosystem->needed_roles ?? [];
            
            // Convert role names to peran IDs
            $existingRoleIds = [];
            $neededRoleIds = [];
            
            // Get all available peran
            $peranList = \App\Models\Peran::all()->pluck('nama', 'id');
            
            // Convert existing roles
            foreach ($existingRoles as $roleName) {
                $peranId = $peranList->search($roleName);
                if ($peranId !== false) {
                    $existingRoleIds[] = $peranId;
                }
            }
            
            // Convert needed roles
            foreach ($neededRoles as $roleName) {
                $peranId = $peranList->search($roleName);
                if ($peranId !== false) {
                    $neededRoleIds[] = $peranId;
                }
            }
            
            // Update the ecosystem
            $ecosystem->update([
                'existing_roles' => $existingRoleIds,
                'needed_roles' => $neededRoleIds
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes by converting peran IDs back to role names
        $ecosystems = \App\Models\Ecosystem::all();
        
        foreach ($ecosystems as $ecosystem) {
            $existingRoles = $ecosystem->existing_roles ?? [];
            $neededRoles = $ecosystem->needed_roles ?? [];
            
            // Convert peran IDs back to role names
            $existingRoleNames = [];
            $neededRoleNames = [];
            
            // Get all available peran
            $peranList = \App\Models\Peran::all()->pluck('nama', 'id');
            
            // Convert existing roles
            foreach ($existingRoles as $peranId) {
                if (isset($peranList[$peranId])) {
                    $existingRoleNames[] = $peranList[$peranId];
                }
            }
            
            // Convert needed roles
            foreach ($neededRoles as $peranId) {
                if (isset($peranList[$peranId])) {
                    $neededRoleNames[] = $peranList[$peranId];
                }
            }
            
            // Update the ecosystem
            $ecosystem->update([
                'existing_roles' => $existingRoleNames,
                'needed_roles' => $neededRoleNames
            ]);
        }
    }
};
