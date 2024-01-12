<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as Spatierole;

class Role extends Spatierole
{
    use HasFactory;

    protected  $fillable= [
        'name',
        'slug',
        'guard_name'
    ];

    // public function permissions()
    // {
    //     return $this->hasMany(Permission::class, 'id', 'permission_category_id');
    // }
}
