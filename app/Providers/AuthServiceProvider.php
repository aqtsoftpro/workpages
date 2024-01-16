<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
// use App\Policies\ApplicationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        App\Models\Company::class => App\Policies\CompanyPolicy::class,
        App\Models\Application::class => App\Policies\ApplicationPolicy::class,
        App\Models\Blog::class => App\Policies\BlogPolicy::class,
        App\Models\Cms::class => App\Policies\CmsPolicy::class,
        App\Models\Currency::class => App\Policies\CurrencyPolicy::class,
        App\Models\Designation::class => App\Policies\DesignationPolicy::class,
        App\Models\Job::class => App\Policies\JobPolicy::class,
        App\Models\Notification::class => App\Policies\NotificationPolicy::class,
        App\Models\Package::class => App\Policies\PackagePolicy::class,
        App\Models\Permission::class => App\Policies\PermissionPolicy::class,
        App\Models\Role::class => App\Policies\RolePolicy::class,
        App\Models\SiteSeetings::class => App\Policies\SiteSeetingsPolicy::class,
        App\Models\Subscription::class => App\Policies\SubscriptionPolicy::class,
        App\Models\User::class => App\Policies\UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return env('FRONT_APP_URL').'reset-password/'.$token.'?email='.$user->email;
        });    
    }
}
