<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Subscription, User};

class SubAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
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
        'expired_at',
        'edit_title',
        'edit_categ',
        'edit_body',
        'delete_ad',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
