<?php

namespace App\Providers;

use App\Models\ApiKey;
use App\Models\Playlist;
use App\Policies\ApiKeyPolicy;
use App\Policies\PlaylistPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(ApiKey::class, ApiKeyPolicy::class);
        Gate::policy(Playlist::class, PlaylistPolicy::class);
    }
}