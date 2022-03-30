<?php

namespace App\Providers;

use App\Models\Bus;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('bus_create', function (User $user, $busOwnerId) {
            if ($user->role_id == User::USER_TYPE_COMPANY) { //company user
                return ($user->id == $busOwnerId);
            }
            return $user->role_id != User::USER_TYPE_NORMAL_USER; //3 normal user

        });

        Gate::define('bus_access', function (User $user, Bus $bus) {
            if ($user->role_id == User::USER_TYPE_COMPANY) { //company user
                return ($user->id == $bus->user_id);
            }
            return $user->role_id != User::USER_TYPE_NORMAL_USER; //3 normal user
        });

        Gate::define('comment', function (User $user) {
            return ($user->role_id == User::USER_TYPE_COMPANY);
        });
        Gate::define('reserve', function (User $user) {
            return ($user->role_id == User::USER_TYPE_NORMAL_USER );
        });
    }
}
