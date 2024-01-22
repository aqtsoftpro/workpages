<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'job_key' => $this->job_key,
            'job_slug' => $this->job_slug,
            'company' => $this->company->name ?? null,
            'company_id' => $this->company_id,
            'company_logo' => $this->company->logo,
            'company_cover_photo' => $this->company->cover_photo,
            'location' => $this->location->name,
            'job_title' => $this->job_title,
            'category' => $this->category->name,
            'category_id' => $this->category->id,
            'job_responsibilities' => $this->job_responsibilities,
            'working_mode' => $this->working_mode,
            'payment_mode' => $this->payment_mode,
            'job_description' => $this->job_description,
            'job_type' => $this->job_type->name,
            'job_type_id' => $this->job_type->id ?? null,
            'vacancy' => $this->vacancy,
            'qualification' => $this->qualification->name,
            'qualification_id' => $this->qualification->id,
            'experience' => $this->experience,
            'gender' => $this->gender,
            'salary_from' => $this->salary_from,
            'salary_to' => $this->salary_to,
            'salary_range' => $this->currency->symbol .' '. $this->salary_from . ' - ' . $this->currency->symbol . ' ' . $this->salary_to . ' / ' . $this->payment_mode,
            'currency' => $this->currency->symbol,
            'posted_on' => Carbon::parse($this->created_at)->format('M d, Y'),
            'expiration' => Carbon::parse($this->expiration)->format('M d, Y'),
            'applications' => $this->applications,
            'applications_count' => $this->applications->count(),
            'status' => $this->status,
            'jobStatus' => ($this->status == 'active')?true:false,
        ];
    }
}
