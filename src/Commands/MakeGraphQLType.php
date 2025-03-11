<?php

namespace KomfySach\LaravelGraphQLGenerator\Commands;

class MakeGraphQLType extends MakeGraphQLCommand
{
    protected $signature = 'make:gqlType {name}';
    protected $description = 'Create a new GraphQL type';
    protected $type = 'GraphQL type';

    public function getStubPath(): string
    {
        $customStub = base_path('stubs/graphql/graphql.type.stub');
        return file_exists($customStub)
            ? $customStub
            : __DIR__ . '/../stubs/graphql.type.stub';
    }
}