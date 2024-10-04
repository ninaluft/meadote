<?php

namespace App\Providers;

use App\Models\SupportMessage;
use App\Policies\SupportMessagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        SupportMessage::class => SupportMessagePolicy::class,
    ];

    public function boot()
    {

        Gate::define('admin-only', function ($user) {
            return $user->user_type === 'admin';
        });
        //
    }
}
