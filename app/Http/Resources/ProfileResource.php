<?php

namespace App\Http\Resources;

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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'location' => $this->location,
            'about' => $this->about,
            'email' => $this->email,
            'theme' => ThemeResource::make($this->theme),
            'cover' => url($this->cover ?? null),
            'photo' => url($this->photo ?? null),
            'bgColor' => $this->bgColor,
            'phoneNum' => $this->phoneNum,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
            'links' => ProfilePrimaryLinkResource::collection($this->user->primary),
//                        'views' => $this->views()->count(),
//                        'views_by_address' => $this->countViewByAddress($this->user_id),
//                        'views_details' => ViewResource::collection($this->views()->get()),
        ];
    }
}
