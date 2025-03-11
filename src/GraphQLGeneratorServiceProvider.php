<?php

namespace YourUsername\LaravelGraphQLGenerator;

use Illuminate\Support\ServiceProvider;
use YourUsername\LaravelGraphQLGenerator\Commands\MakeGraphQLType;
use YourUsername\LaravelGraphQLGenerator\Commands\MakeGraphQLQuery;
use YourUsername\LaravelGraphQLGenerator\Commands\MakeGraphQLMutation;

class GraphQLGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Publish stub files
        $this->publishes([
            __DIR__ . '/stubs' => base_path('stubs/graphql'),
        ], 'graphql-stubs');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeGraphQLType::class,
                MakeGraphQLQuery::class,
                MakeGraphQLMutation::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}