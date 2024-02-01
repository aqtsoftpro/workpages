<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Portfolio;


class PortfolioImage extends Model
{
    use HasFactory;

    protected $fillable = ['portfolio_id', 'image', 'status'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->status = 1; // Generate slug from the name
        });
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
