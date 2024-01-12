<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'photo' => $this->photo,
            'name' => $this->name,
            'email' => $this->email,
            'dob' => $this->dob,
            'age' => Carbon::parse($this->dob)->age,
            'location_id' => $this->location->id,
            'phone' => $this->phone,
            'current_job_location_id' => $this->current_job_location,
            'designation_id' => $this->designation,
            'qualification_id' => $this->qualification,
            'language' => $this->language->id,
            'description' => $this->description
        ];
    }
}
