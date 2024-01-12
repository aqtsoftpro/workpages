<?php

namespace App\Policies;

use App\Models\Cms;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CmsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('List Cms') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Cms $cms): bool
    {
        return $user->hasPermissionTo('View Cms') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Add Cms') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cms $cms): bool
    {
        return $user->hasPermissionTo('Edit Cms') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cms $cms): bool
    {
        return $user->hasPermissionTo('Delete Cms') ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cms $cms): bool
    {
        return $user->hasPermissionTo('Restore Cms') ? true : false;
    }

    /**
     * Determine whether the user can permanently delete the model.
      */
    // public function forceDelete(User $user, Cms $cms): bool
    // {
    //     //
    // }
}
