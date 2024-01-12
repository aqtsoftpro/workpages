<?php

namespace App\Policies;

use App\Models\SiteSettings;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SiteSettingsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('List Site Settings') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SiteSettings $siteSettings): bool
    {
        return $user->hasPermissionTo('View Site Settings') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Add Site Settings') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SiteSettings $siteSettings): bool
    {
        return $user->hasPermissionTo('Edit Site Settings') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SiteSettings $siteSettings): bool
    {
        return $user->hasPermissionTo('Delete Site Settings') ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SiteSettings $siteSettings): bool
    {
        return $user->hasPermissionTo('Restore Site Settings') ? true : false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, SiteSettings $siteSettings): bool
    // {
    //     //
    // }
}
