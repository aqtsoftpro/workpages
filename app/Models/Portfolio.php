<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\{User, PortfolioImage};

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'url',
        'start_date',
        'end_date',
        'skill_used',
        'images',
        'video_links',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
