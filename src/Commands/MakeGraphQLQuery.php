<?php

namespace KomfySach\LaravelGraphQLGenerator\Commands;

class MakeGraphQLQuery extends MakeGraphQLCommand
{
    protected $signature = 'make:gqlQuery {name}';
    protected $description = 'Create a new GraphQL query';
    protected $type = 'GraphQL query';

    public function getStubPath(): string
    {
        $customStub = base_path('stubs/graphql/graphql.query.stub');
        return file_exists($customStub)
            ? $customStub
            : __DIR__ . '/../stubs/graphql.query.stub';
    }
}