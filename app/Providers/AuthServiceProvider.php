<?php

namespace App\Providers;

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
        Gate::define('delete-comment', function ($user, $comment) {
            return $user->id === $comment->user_id
            or $user->id === $comment->article->user_id;
        });

        Gate::define('delete-article', function($user, $article)
        {
            return $user->id === $article->user_id;
        });

        Gate::define('edit-article', function($user, $article)
        {
            return $user->id === $article->user_id;
        });
        //
    }
}
