<?php

namespace KomfySach\LaravelGraphQLGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class MakeGraphQLCommand extends Command
{
    protected $signature;
    protected $description;
    protected $type;

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    abstract public function getStubPath(): string;

    protected function getGraphQLPath($name)
    {
        if (strpos($name, 'Type') !== false) {
            $directory = app_path('GraphQL/Types');
        } else if (strpos($name, 'Query') !== false) {
            $directory = app_path('GraphQL/Queries');
        } else if (strpos($name, 'Mutation') !== false) {
            $directory = app_path('GraphQL/Mutations');
        } else {
            $directory = app_path('GraphQL');
        }
        
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        return $directory . '/' . $name . '.php';
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
        
        return $path;
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStubPath());
        
        // Get model name without "Type", "Query", or "Mutation" suffix
        $modelName = str_replace(['Type', 'Query', 'Mutation', 'Create', 'Update', 'Delete'], '', $name);
        
        return $this->replaceNamespace($stub, $name)
                    ->replaceClassName($stub, $name)
                    ->replaceModelName($stub, $modelName);
    }

    protected function replaceNamespace(&$stub, $name)
    {
        return $this;
    }

    protected function replaceClassName(&$stub, $name)
    {
        $stub = str_replace('{{ class }}', $name, $stub);
        return $this;
    }

    protected function replaceModelName(&$stub, $modelName)
    {
        $modelVariableName = Str::camel($modelName);
        $modelClassName = Str::studly($modelName);
        
        $stub = str_replace('{{ model }}', $modelClassName, $stub);
        $stub = str_replace('{{ modelVariable }}', $modelVariableName, $stub);
        $stub = str_replace('{{ modelType }}', Str::camel($modelName), $stub);
        
        return $stub;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getGraphQLPath($name);

        if ($this->files->exists($path)) {
            $this->error("{$name} already exists!");
            return 1;
        }

        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));
        $this->info("{$this->type} [{$name}] created successfully.");
        
        return 0;
    }
}