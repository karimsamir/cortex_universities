<?php

declare(strict_types=1);

namespace Cortex\UniversitiesModule\Providers;

use Cortex\UniversitiesModule\Models\BaseUniversity as University;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Rinvex\Support\Traits\ConsoleTools;

class UniversitiesServiceProvider extends ServiceProvider
{
    use ConsoleTools;
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPublishables();
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadRoutesFrom(realpath(__DIR__ . '/../../routes/web/adminarea.php'));
        // $this->loadViewsFrom(__DIR__.'/../../../resources/views', 'cortex_universities');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/university');
        // Force load your helpers after rinvex/universities
        require_once __DIR__.'/../helpers.php';

        // Map relations
        Relation::morphMap([
            'university' => config('cortex.universities.models.university'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'cortex.universities'
        );

        // // Bind eloquent models to IoC container
        // $this->registerModels([
        //     'rinvex.universities.university' => University::class,
        // ]);
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../../config/cortex_universities.php' => config_path('config.php'),
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
