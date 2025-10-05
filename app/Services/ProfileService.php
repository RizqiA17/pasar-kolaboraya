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
    public function updateInterests(User $user, array $interests = [], array $customInterests = []): bool
    {
        try {
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            // Clear existing interests first (both regular and custom)
            DB::table('user_interests')->where('profile_id', $profile->id)->delete();
            
            // Add selected interests
            if (!empty($interests)) {
                $selectedInterestData = [];
                foreach ($interests as $interestId) {
                    $selectedInterestData[$interestId] = [
                        'level' => 1,
                        'custom_name' => null
                    ];
                }
                $profile->interests()->attach($selectedInterestData);
            }
            
            // Add custom interests directly to database
            if (!empty($customInterests)) {
                foreach ($customInterests as $customInterest) {
                    if (!empty($customInterest['name'])) {
                        DB::table('user_interests')->insert([
                            'profile_id' => $profile->id,
                            'interest_id' => null,
                            'custom_name' => $customInterest['name'],
                            'level' => 1, // Default level
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user interests: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'interests' => $interests,
                'custom_interests' => $customInterests,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Update user skills
     */
    public function updateSkills(User $user, array $skills = [], array $customSkills = []): bool
    {
        try {
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            // Clear existing skills first (both regular and custom)
            DB::table('user_skills')->where('profile_id', $profile->id)->delete();
            
            // Add selected skills
            if (!empty($skills)) {
                $selectedSkillData = [];
                foreach ($skills as $skillId) {
                    $selectedSkillData[$skillId] = [
                        'level' => 1,
                        'is_primary' => false,
                        'custom_name' => null
                    ];
                }
                $profile->skills()->attach($selectedSkillData);
            }
            
            // Add custom skills directly to database
            if (!empty($customSkills)) {
                foreach ($customSkills as $customSkill) {
                    if (!empty($customSkill['name'])) {
                        DB::table('user_skills')->insert([
                            'profile_id' => $profile->id,
                            'skill_id' => null,
                            'custom_name' => $customSkill['name'],
                            'level' => 1, // Default level
                            'is_primary' => false, // Default not primary
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user skills: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'skills' => $skills,
                'custom_skills' => $customSkills,
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
