<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Define a Gate for 'view-user'
        Gate::define('view-user', function (User $user) {
            return $user->roles->flatMap->permissions->contains('name', 'view-user');
        });

        // Define a Gate for 'edit-user'
        Gate::define('edit-user', function (User $user) {
            return $user->roles->flatMap->permissions->contains('name', 'edit-user');
        });

        // Define a Gate for 'edit-user'
        Gate::define('assign-role', function (User $user) {
            return $user->roles->flatMap->permissions->contains('name', 'assign-role');
        });

        // Define a Gate to check if a user can create a user
        Gate::define('user-creation', function (User $user) {
            return $user->roles->flatMap->permissions->contains('name', 'user-creation');
        });

        // Define a Gate to check if a user can create a user
        Gate::define('user-deletion', function (User $user) {
            return $user->roles->flatMap->permissions->contains('name', 'user-deletion');
        });
    }
}
