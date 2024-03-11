<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\{SubAccess, Package, User, Company};


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
        'delete_ad',
        'status'
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
        return $this->belongsTo(Company::class);
    }

    public function subAccess(): HasOne
    {
        return $this->hasOne(SubAccess::class);
    }

    

}
