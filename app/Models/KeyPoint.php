<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Package;

class KeyPoint extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'icon', 'title', 'detail'];
    
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
