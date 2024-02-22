<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Subscription extends Model
{
    use HasFactory, Searchable;

    protected  $fillable= [
        'user_id',
        'package_id',
        'company_id',
        'name',
        'stripe_id',
        'stripe_price',
        'quantity',
        'stripe_status',
        'last_4',
        'brand',
        'exp_month',
        'exp_year',
        'ends_at',
        'receipt_url',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo( Company::class);
    }

}
