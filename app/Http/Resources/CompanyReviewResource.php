<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'review' => $this->review,
            'author_name' => $this->user->name,
            'author_image' => $this->user->photo,
            'reviewed_on' => Carbon::parse($this->created_at)->format('M d, Y'),
        ];
    }
}
