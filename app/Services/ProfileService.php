<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    /**
     * Get or create user profile
     */
    public function getOrCreateProfile(User $user): Profile
    {
        return $user->profile ?? $user->profile()->create();
    }

    /**
     * Update user interests
     */
    public function updateInterests(User $user, array $interests): bool
    {
        try {
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            // Clear existing interests first
            $profile->interests()->detach();
            
            // Prepare interests data with level
            $interestsData = collect($interests)->mapWithKeys(function ($interestId) {
                return [$interestId => ['level' => 1]]; // Default level 1
            })->toArray();
            
            // Attach new interests
            if (!empty($interestsData)) {
                $profile->interests()->attach($interestsData);
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user interests: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'interests' => $interests,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Update user skills
     */
    public function updateSkills(User $user, array $skills): bool
    {
        try {
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            // Clear existing skills first
            $profile->skills()->detach();
            
            // Prepare skills data with level and primary flag
            $skillsData = collect($skills)->mapWithKeys(function ($skillId) {
                return [$skillId => [
                    'level' => 1, // Default level 1
                    'is_primary' => false // Default not primary
                ]];
            })->toArray();
            
            // Attach new skills
            if (!empty($skillsData)) {
                $profile->skills()->attach($skillsData);
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user skills: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'skills' => $skills,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Add new contribution
     */
    public function addContribution(User $user, array $contributionData): bool
    {
        try {
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            $profile->contributions()->attach($contributionData['contribution_id'], [
                'description' => $contributionData['description'],
                'date' => $contributionData['date'],
            ]);
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add user contribution: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'contribution_data' => $contributionData
            ]);
            return false;
        }
    }

    /**
     * Remove contribution
     */
    public function removeContribution(User $user, int $contributionId): bool
    {
        try {
            $profile = $this->getOrCreateProfile($user);
            $profile->contributions()->detach($contributionId);
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to remove user contribution: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'contribution_id' => $contributionId
            ]);
            return false;
        }
    }

    /**
     * Get user profile data
     */
    public function getProfileData(User $user): array
    {
        $profile = $this->getOrCreateProfile($user);
        
        return [
            'interests' => $profile->interests()->pluck('interests.id')->toArray(),
            'skills' => $profile->skills()->pluck('skills.id')->toArray(),
            'contributions' => $profile->contributions()
                ->withPivot('description', 'date')
                ->orderByDesc('user_contributions.date')
                ->get()
                ->toArray(),
        ];
    }

    /**
     * Update skill level
     */
    public function updateSkillLevel(User $user, int $skillId, int $level, bool $isPrimary = false): bool
    {
        try {
            $profile = $this->getOrCreateProfile($user);
            
            $profile->skills()->updateExistingPivot($skillId, [
                'level' => $level,
                'is_primary' => $isPrimary
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update skill level: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'skill_id' => $skillId,
                'level' => $level
            ]);
            return false;
        }
    }

    /**
     * Update interest level
     */
    public function updateInterestLevel(User $user, int $interestId, int $level): bool
    {
        try {
            $profile = $this->getOrCreateProfile($user);
            
            $profile->interests()->updateExistingPivot($interestId, [
                'level' => $level
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update interest level: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'interest_id' => $interestId,
                'level' => $level
            ]);
            return false;
        }
    }

    /**
     * Update profile photo
     */
    public function updateProfilePhoto(User $user, $photo): bool
    {
        try {
            $profile = $this->getOrCreateProfile($user);
            
            // Delete old photo if exists
            if ($profile->profile_photo && file_exists(public_path('storage/' . $profile->profile_photo))) {
                unlink(public_path('storage/' . $profile->profile_photo));
            }
            
            // Store new photo
            $path = $photo->store('profile-photos', 'public');
            $profile->update(['profile_photo' => $path]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update profile photo: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Update banner
     */
    public function updateBanner(User $user, $banner): bool
    {
        try {
            $profile = $this->getOrCreateProfile($user);
            
            // Delete old banner if exists
            if ($profile->banner && file_exists(public_path('storage/' . $profile->banner))) {
                unlink(public_path('storage/' . $profile->banner));
            }
            
            // Store new banner
            $path = $banner->store('banners', 'public');
            $profile->update(['banner' => $path]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update banner: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrl(User $user): ?string
    {
        $profile = $this->getOrCreateProfile($user);
        
        if ($profile->profile_photo) {
            return asset('storage/' . $profile->profile_photo);
        }
        
        return null;
    }

    /**
     * Get banner URL
     */
    public function getBannerUrl(User $user): ?string
    {
        $profile = $this->getOrCreateProfile($user);
        
        if ($profile->banner) {
            return asset('storage/' . $profile->banner);
        }
        
        return null;
    }
}
