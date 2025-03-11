<?php

namespace KomfySach\LaravelGraphQLGenerator\Commands;

class MakeGraphQLMutation extends MakeGraphQLCommand
{
    protected $signature = 'make:gqlMutation {name}';
    protected $description = 'Create a new GraphQL mutation';
    protected $type = 'GraphQL mutation';

    public function getStubPath(): string
    {
        $customStub = base_path('stubs/graphql/graphql.mutation.stub');
        return file_exists($customStub)
            ? $customStub
            : __DIR__ . '/../stubs/graphql.mutation.stub';
    }
}