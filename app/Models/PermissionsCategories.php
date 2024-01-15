<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionsCategories extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name', 'slug'
    ];

    public function permissions()
    {
        return $this->hasMany( Permission::class, 'id', 'permission_category_id');
    }

}
