<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\KeyPoint;



class Package extends Model
{
    use HasFactory, Searchable;

    protected  $fillable= [
        'name',
        'price',
        'stripe_price_id',
        'stripe_product_id',
        'interval',
        'interval_count',
        'description',
        'count',
        'design',
        'main_icon',
        'post_for',
        'allow_ads',
        'allow_edits',
        'allow_ref',
        'allow_right',
        'allow_others',
        'h_s_screen',
        'allow_interview',
        'recruiter_dash',
        'casual_portal',
        'rec_support',
        'cv_credit',
        'msg_credit',
        'cv_access',
        'pause_ad',
        'delete_ad',
        'close_ad',
        'edit_title',
        'edit_categ',
        'edit_body',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function keypoints(): HasMany
    {
        return $this->hasMany(KeyPoint::class);
    }
}
