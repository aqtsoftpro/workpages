<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JobResource;

class JobAdResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'job' => new JobResource($this->whenLoaded('job')), // Ensure 'job' is loaded before transforming
            'ends_at' => Carbon::parse($this->ends_at)->format('M d, Y'),
        ];
    }
}
