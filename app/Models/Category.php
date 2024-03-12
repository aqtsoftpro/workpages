<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Job;

class Category extends Model
{
    use HasFactory, Searchable;
    protected $table = 'job_categories';

    protected $fillable = [
        'name', 'icon', 'image', 'slug', 'status'
    ];

    public function toSearchableArray()
    {
        return array_merge($this->toArray(),[
            'id' => (string) $this->id,
            'created_at' => $this->created_at->timestamp,
        ]);
    }
    public function stats(): HasMany
    {
        return $this->hasMany(Stat::class, 'ref_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class,);
    }

}
