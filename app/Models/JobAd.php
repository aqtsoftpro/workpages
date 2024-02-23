<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;


class JobAd extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'job_id', 'subscription_id', 'user_id', 'ends_at', 'status'];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
