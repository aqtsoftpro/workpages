<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


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
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
