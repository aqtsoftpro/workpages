<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'price' => $this->price,
            'stripe_price_id' => $this->stripe_price_id,
            'stripe_product_id' => $this->stripe_product_id,
            'interval' => $this->interval,
            'description' => $this->description,
            'count' => $this->count,
            'design' => $this->design,
            'main_icon' => $this->main_icon,
            'post_for' => $this->post_for,
            'allow_ads' => $this->allow_ads,
            'allow_edits' => $this->allow_edits,
            'allow_ref' => $this->allow_ref,
            'allow_right' => $this->allow_right,
            'allow_others' => $this->allow_others,
            'h_s_screen' => $this->h_s_screen,
            'allow_interview' => $this->allow_interview,
            'recruiter_dash' => $this->recruiter_dash,
            'casual_portal' => $this->casual_portal,
            'rec_support' => $this->rec_support,
            'cv_credit' => $this->cv_credit,
            'msg_credit' => $this->msg_credit,
            'cv_access' => $this->cv_access,
            'isLoading' => false,
        ];
    }
}
