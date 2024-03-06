<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobSeekerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'email_verified_at'=> $this->email_verified_at,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'dob'=> $this->dob,
            'photo'=> $this->photo,
            'location_id'=> $this->location_id,
            'phone'=> $this->phone,
            'current_job_location_id'=> $this->current_job_location_id,
            'designation_id'=> $this->designation_id,
            'qualification_id'=> $this->qualification_id,
            'language_id'=> $this->language_id,
            'description'=> $this->description,
            'weblink'=> $this->weblink,
            'stripe_id'=> $this->stripe_id,
            'pm_type'=> $this->pm_type,
            'pm_last_four'=> $this->pm_last_four,
            'trial_ends_at'=> $this->trial_ends_at,
            'status'=> $this->status,
            'address'=> $this->address,
            'gender'=> $this->gender,
            'suburb_id'=> $this->suburb_id,
            'deleted_at'=> $this->deleted_at,
            'location'=> $this->location,
            'designtion'=> $this->designtion,
            'qualification'=> $this->qualification,
            'job_location'=> $this->job_location,
            'reviews'=> $this->reviews
        ];
    }
}
