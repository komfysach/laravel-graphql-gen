<?php

namespace KomfySach\LaravelGraphQLGenerator;

use Illuminate\Support\ServiceProvider;

use KomfySach\LaravelGraphQLGenerator\Commands\MakeGraphQLMutation as CommandsMakeGraphQLMutation;
use KomfySach\LaravelGraphQLGenerator\Commands\MakeGraphQLQuery as CommandsMakeGraphQLQuery;
use KomfySach\LaravelGraphQLGenerator\Commands\MakeGraphQLType as CommandsMakeGraphQLType;

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
                CommandsMakeGraphQLType::class,
                CommandsMakeGraphQLQuery::class,
                CommandsMakeGraphQLMutation::class,
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