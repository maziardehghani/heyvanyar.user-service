<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PermissionResource;
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
            'name' => $this->full_name,
            'mobile' => $this->mobile,
            'bank_accounts_info' => (array)json_decode($this->bank_accounts_info),
            'melli_code' => $this->melli_code,
            'credit' => $this->credit,
            // 'type' => $this->getRoleNames()->first() ?? "User",
            // 'tickets' => TicketResource::collection($this->whenLoaded('tickets')),
            // 'city' => new CityResource($this->whenLoaded('city')),
            'status' => $this->status,
            'roles' => $this->getRoleNames(),
            'permissions' => PermissionResource::collection($this->getPermissionsViaRoles()),
            'birth_date' => $this->birth_date,
            'created_at' => $this->created_at
        ];
    }
}
