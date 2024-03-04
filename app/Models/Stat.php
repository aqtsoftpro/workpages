<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Stat extends Model
{
    use HasFactory;

    protected $table = 'stats';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'ref_id');
    }
}
