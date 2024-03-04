<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'user_name' => (isset($this->user->name)) ? $this->user->name : '',
            'company_id' => $this->company_id,
            'company_name' => (isset($this->company->name)) ? $this->company->name : '',
            'status_id' => $this->status_id,
            'status_name' => (isset($this->status->name)) ? $this->status->name : '',
            'job_id' => $this->job_id,
            'job' => new JobResource($this->job),
            'cv' => $this->cv,
            'user' => $this->user ?? [],
            'applied_on' => Carbon::parse($this->created_at)->format('M d, Y'),
            'experience' => $this->experience,
            'salary' => $this->salary,
            'status' => $this->status_id
        ];
    }
}
