<?php

namespace App\Http\Resources\User;

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
            'user' => [
                'id' => $this->resource->getKey(),
                'name' => $this->resource->name,
                'email' => $this->resource->email,
            ],
            'profile' => [
                'id' => $this->resource->profile?->getKey(),
                'company' => $this->resource->profile?->company,
                'ntionality' => $this->resource->profile?->ntionality,
            ]
        ];
    }
}
