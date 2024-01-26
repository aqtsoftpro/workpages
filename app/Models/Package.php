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
        'description',
        'count',
        'design',
        'main_icon'
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
