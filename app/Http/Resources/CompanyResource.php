<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'about' => $this->about,
            'location' => (isset($this->location )) ? $this->location->name : '',
            'location_id' => (isset($this->location)) ? $this->location->id : '',
            'State' => (isset($this->state )) ? $this->state->name : '',
            'state_id' => (isset($this->state_id)) ? $this->state->id : '',
            'address' => $this->address,
            'logo' => $this->logo,
            'cover_photo' => $this->cover_photo,
            'owner' => $this->owner,
            'package' => (isset($this->package)) ? $this->package->name : '',
            'package_id' => (isset($this->package)) ? $this->package->id : '',
            'company_type' => (isset($this->company_type_id )) ? $this->company_type->name : '',
            'company_type_id' => (isset($this->company_type_id)) ? $this->company_type_id : '',
            'company_size' => $this->company_size,
            'weblink' => $this->weblink,
            'join_on' => Carbon::parse($this->created_at)->format('M d, Y'),
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'pinterest' => $this->pinterest,
            'dribble' => $this->dribble,
            'behance' => $this->behance,
            'jobs_count' => $this->jobs->count(),
            'jobs' => JobResource::collection($this->jobs)
        ];
    }
}
