<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class JobAd extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'subscription_id', 'user_id', 'ends_at', 'status'];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
