<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'organization' => $this->organization,
            'phone' => $this->phone,
            'social_media' => $this->social_media,
            'formatted_social_media' => $this->formatted_social_media,
            'vision' => $this->vision,
            'profile_photo' => $this->profile_photo,
            'banner' => $this->banner,
            'peran_id' => $this->peran_id,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            
            // Include related data if loaded
            'peran' => $this->whenLoaded('peran', function () {
                return [
                    'id' => $this->peran->id,
                    'nama' => $this->peran->nama,
                    'deskripsi' => $this->peran->deskripsi,
                ];
            }),
            
            'interests' => $this->whenLoaded('interests', function () {
                return $this->interests->map(function ($interest) {
                    return [
                        'id' => $interest->id,
                        'name' => $interest->name,
                        'level' => $interest->pivot->level ?? null,
                        'custom_name' => $interest->pivot->custom_name ?? null,
                    ];
                });
            }),
            
            'skills' => $this->whenLoaded('skills', function () {
                return $this->skills->map(function ($skill) {
                    return [
                        'id' => $skill->id,
                        'name' => $skill->name,
                        'level' => $skill->pivot->level ?? null,
                        'is_primary' => $skill->pivot->is_primary ?? false,
                        'custom_name' => $skill->pivot->custom_name ?? null,
                    ];
                });
            }),
            
            'contributions' => $this->whenLoaded('contributions', function () {
                return $this->contributions->map(function ($contribution) {
                    return [
                        'id' => $contribution->id,
                        'name' => $contribution->name,
                        'description' => $contribution->pivot->description ?? null,
                        'date' => $contribution->pivot->date ?? null,
                    ];
                });
            }),
        ];
    }
}

