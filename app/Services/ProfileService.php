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
            // Validate input data
            if (!is_array($interests)) {
                $interests = [];
            }
            if (!is_array($customInterests)) {
                $customInterests = [];
            }
            
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            // Clear existing interests first (both regular and custom)
            DB::table('user_interests')->where('profile_id', $profile->id)->delete();
            
            // Add selected interests
            if (!empty($interests)) {
                $selectedInterestData = [];
                foreach ($interests as $interestId) {
                    // Validate interest exists
                    if (!DB::table('interests')->where('id', $interestId)->exists()) {
                        Log::warning('Invalid interest ID provided', ['interest_id' => $interestId, 'user_id' => $user->id]);
                        continue;
                    }
                    
                    $selectedInterestData[$interestId] = [
                        'level' => 1,
                        'custom_name' => null
                    ];
                }
                
                if (!empty($selectedInterestData)) {
                    $profile->interests()->attach($selectedInterestData);
                }
            }
            
            // Add custom interests directly to database
            if (!empty($customInterests)) {
                foreach ($customInterests as $customInterest) {
                    if (!empty($customInterest['name'])) {
                        // Validate custom interest name length
                        if (strlen($customInterest['name']) > 255) {
                            Log::warning('Custom interest name too long', [
                                'name' => $customInterest['name'],
                                'user_id' => $user->id
                            ]);
                            continue;
                        }
                        
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
            
            Log::info('User interests updated successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'interests_count' => count($interests),
                'custom_interests_count' => count($customInterests)
            ]);
            
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
            // Validate input data
            if (!is_array($skills)) {
                $skills = [];
            }
            if (!is_array($customSkills)) {
                $customSkills = [];
            }
            
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            // Clear existing skills first (both regular and custom)
            DB::table('user_skills')->where('profile_id', $profile->id)->delete();
            
            // Add selected skills
            if (!empty($skills)) {
                $selectedSkillData = [];
                foreach ($skills as $skillId) {
                    // Validate skill exists
                    if (!DB::table('skills')->where('id', $skillId)->exists()) {
                        Log::warning('Invalid skill ID provided', ['skill_id' => $skillId, 'user_id' => $user->id]);
                        continue;
                    }
                    
                    $selectedSkillData[$skillId] = [
                        'level' => 1,
                        'is_primary' => false,
                        'custom_name' => null
                    ];
                }
                
                if (!empty($selectedSkillData)) {
                    $profile->skills()->attach($selectedSkillData);
                }
            }
            
            // Add custom skills directly to database
            if (!empty($customSkills)) {
                foreach ($customSkills as $customSkill) {
                    if (!empty($customSkill['name'])) {
                        // Validate custom skill name length
                        if (strlen($customSkill['name']) > 255) {
                            Log::warning('Custom skill name too long', [
                                'name' => $customSkill['name'],
                                'user_id' => $user->id
                            ]);
                            continue;
                        }
                        
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
            
            Log::info('User skills updated successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'skills_count' => count($skills),
                'custom_skills_count' => count($customSkills)
            ]);
            
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
            // Validate input data
            if (!isset($contributionData['contribution_id']) || !isset($contributionData['description']) || !isset($contributionData['date'])) {
                Log::warning('Invalid contribution data provided', [
                    'user_id' => $user->id,
                    'contribution_data' => $contributionData
                ]);
                return false;
            }
            
            // Validate contribution exists
            if (!DB::table('contributions')->where('id', $contributionData['contribution_id'])->exists()) {
                Log::warning('Invalid contribution ID provided', [
                    'contribution_id' => $contributionData['contribution_id'],
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            DB::beginTransaction();
            
            $profile = $this->getOrCreateProfile($user);
            
            $profile->contributions()->attach($contributionData['contribution_id'], [
                'description' => $contributionData['description'],
                'date' => $contributionData['date'],
            ]);
            
            DB::commit();
            
            Log::info('User contribution added successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'contribution_id' => $contributionData['contribution_id']
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add user contribution: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'contribution_data' => $contributionData,
                'trace' => $e->getTraceAsString()
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
            // Validate input data
            if (!is_numeric($contributionId) || $contributionId <= 0) {
                Log::warning('Invalid contribution ID provided for removal', [
                    'contribution_id' => $contributionId,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            $profile = $this->getOrCreateProfile($user);
            $profile->contributions()->detach($contributionId);
            
            Log::info('User contribution removed successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'contribution_id' => $contributionId
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to remove user contribution: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'contribution_id' => $contributionId,
                'trace' => $e->getTraceAsString()
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
            // Validate input data
            if (!is_numeric($skillId) || $skillId <= 0) {
                Log::warning('Invalid skill ID provided for level update', [
                    'skill_id' => $skillId,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            if (!is_numeric($level) || $level < 1 || $level > 5) {
                Log::warning('Invalid skill level provided', [
                    'level' => $level,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            // Validate skill exists
            if (!DB::table('skills')->where('id', $skillId)->exists()) {
                Log::warning('Skill does not exist', [
                    'skill_id' => $skillId,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            $profile = $this->getOrCreateProfile($user);
            
            $profile->skills()->updateExistingPivot($skillId, [
                'level' => $level,
                'is_primary' => $isPrimary
            ]);
            
            Log::info('Skill level updated successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'skill_id' => $skillId,
                'level' => $level,
                'is_primary' => $isPrimary
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update skill level: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'skill_id' => $skillId,
                'level' => $level,
                'trace' => $e->getTraceAsString()
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
            // Validate input data
            if (!is_numeric($interestId) || $interestId <= 0) {
                Log::warning('Invalid interest ID provided for level update', [
                    'interest_id' => $interestId,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            if (!is_numeric($level) || $level < 1 || $level > 5) {
                Log::warning('Invalid interest level provided', [
                    'level' => $level,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            // Validate interest exists
            if (!DB::table('interests')->where('id', $interestId)->exists()) {
                Log::warning('Interest does not exist', [
                    'interest_id' => $interestId,
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            $profile = $this->getOrCreateProfile($user);
            
            $profile->interests()->updateExistingPivot($interestId, [
                'level' => $level
            ]);
            
            Log::info('Interest level updated successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'interest_id' => $interestId,
                'level' => $level
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update interest level: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'interest_id' => $interestId,
                'level' => $level,
                'trace' => $e->getTraceAsString()
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
            // Validate photo file
            if (!$photo || !$photo->isValid()) {
                Log::warning('Invalid photo file provided', [
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            $profile = $this->getOrCreateProfile($user);
            
            // Delete old photo if exists
            if ($profile->profile_photo && file_exists(public_path('storage/' . $profile->profile_photo))) {
                unlink(public_path('storage/' . $profile->profile_photo));
            }
            
            // Store new photo
            $path = $photo->store('profile-photos', 'public');
            $profile->update(['profile_photo' => $path]);
            
            Log::info('Profile photo updated successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'photo_path' => $path
            ]);
            
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
            // Validate banner file
            if (!$banner || !$banner->isValid()) {
                Log::warning('Invalid banner file provided', [
                    'user_id' => $user->id
                ]);
                return false;
            }
            
            $profile = $this->getOrCreateProfile($user);
            
            // Delete old banner if exists
            if ($profile->banner && file_exists(public_path('storage/' . $profile->banner))) {
                unlink(public_path('storage/' . $profile->banner));
            }
            
            // Store new banner
            $path = $banner->store('banners', 'public');
            $profile->update(['banner' => $path]);
            
            Log::info('Banner updated successfully', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'banner_path' => $path
            ]);
            
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
