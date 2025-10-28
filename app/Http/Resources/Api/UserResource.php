<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'organization_type' => $this->organization_type,
            'organization_name' => $this->organization_name,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'user_type' => $this->user_type,
            'user_type_label' => $this->user_type_label,
            'approval_status' => $this->approval_status,
            'approval_status_label' => $this->approval_status_label,
            'assigned_role' => $this->assigned_role,
            'assigned_role_label' => $this->assigned_role_label,
            'is_ecosystem_builder' => $this->is_ecosystem_builder,
            'ecosystem_builder_status' => $this->ecosystem_builder_status,
            'approved_at' => $this->approved_at?->toIso8601String(),
            'ecosystem_builder_approved_at' => $this->ecosystem_builder_approved_at?->toIso8601String(),
            'qr_code' => $this->qr_code,
            'qr_code_generated_at' => $this->qr_code_generated_at?->toIso8601String(),
            'active_pasar_kolaboraya_id' => $this->active_pasar_kolaboraya_id,
            'active_container_id' => $this->active_container_id,
            'email_verified_at' => $this->email_verified_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            
            // Include profile if loaded
            'profile' => $this->whenLoaded('profile', function () {
                return new ProfileResource($this->profile);
            }),
            
            // Include role display info
            'role_display_info' => $this->getRoleDisplayInfo(),
        ];
    }
}

