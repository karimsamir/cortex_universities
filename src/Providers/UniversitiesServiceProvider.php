<?php

declare(strict_types=1);

namespace Cortex\Universities\Providers;

use Illuminate\Support\ServiceProvider;
use Cortex\Universities\Models\University;

class UniversitiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPublishables();
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        // Force load your helpers after rinvex/universities
        require_once __DIR__.'/../helpers.php';
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/cortex_universities.php',
            'cortex_universities'
        );
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../../config/cortex_universities.php' => config_path('cortex_universities.php'),
        ], ['cortex-universities', 'cortex-universities-config']);

        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], ['cortex-universities', 'cortex-universities-migrations']);

        $this->publishes([
            __DIR__.'/../../database/seeders' => database_path('seeders'),
        ], ['cortex-universities', 'cortex-universities-seeders']);

        $this->publishes([
            __DIR__.'/../../src/Models' => app_path('Models'),
        ], ['cortex-universities', 'cortex-universities-models']);
    }
}
