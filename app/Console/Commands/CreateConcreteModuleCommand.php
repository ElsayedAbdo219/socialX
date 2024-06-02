<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateConcreteModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-module {modelName} {namespace?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Full Module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $namespace = $this->argument('namespace') ?? 'Api/V1';
        $modelName = ucfirst(Str::camel($this->argument('modelName')));

        $this->generateModel($modelName);

        if (!in_array($modelName, $this->getModels())) {
            $this->error('The Model (' . ($modelName) . ') Is Not Exist');
            return;
        }

        $this->generateResource($modelName, $namespace);
        $this->generateRequest($modelName, $namespace);
        $this->generateContract($modelName);
        $this->generateConcrete($modelName);
        $this->generateController($modelName, $namespace);
    }

    public function generateRequest($modelName, $namespace): void
    {
        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'ConcreteModulesStubs' . DIRECTORY_SEPARATOR . 'RequestStub.stub');

        $templateReplaced = $this->replaceTemplate($stub, $modelName, $namespace);

        $path = $this->checkDir('Http/Requests/' . $namespace);

        file_put_contents($path . DIRECTORY_SEPARATOR . $modelName . 'Request.php', $templateReplaced);

        $this->info('Request ' . $modelName . 'Request.php' . ' Generated Successfully');
    }
    public function generateResource($modelName, $namespace): void
    {
        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'ConcreteModulesStubs' . DIRECTORY_SEPARATOR . 'ResourceStub.stub');

        $templateReplaced = $this->replaceTemplate($stub, $modelName, $namespace);

        $path = $this->checkDir('Http/Resources/' . $namespace);

        file_put_contents($path . DIRECTORY_SEPARATOR . $modelName . 'Resource.php', $templateReplaced);

        $this->info('Resource ' . $modelName . 'Resource.php' . ' Generated Successfully');
    }

    public function generateModel($modelName): void
    {
        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'ConcreteModulesStubs' . DIRECTORY_SEPARATOR . 'ModelStub.stub');

        $templateReplaced = $this->replaceTemplate($stub, $modelName);

        $path = $this->checkDir('Models');

        Artisan::call('make:migration create_'.lcfirst(Str::plural($modelName)).'_table');

        file_put_contents($path . DIRECTORY_SEPARATOR . $modelName . '.php', $templateReplaced);

        $this->info('Model ' . $modelName . '.php' . ' Generated Successfully');
    }

    public function generateConcrete($modelName): void
    {
        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'ConcreteModulesStubs' . DIRECTORY_SEPARATOR . 'ConcreteStub.stub');

        $templateReplaced = $this->replaceTemplate($stub, $modelName);

        $path = $this->checkDir('Repositories/Concretes');

        file_put_contents($path . DIRECTORY_SEPARATOR . $modelName . 'Concrete.php', $templateReplaced);

        $this->info('Concrete ' . $modelName . 'Concrete.php' . ' Generated Successfully');
    }

    public function generateContract($modelName): void
    {
        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'ConcreteModulesStubs' . DIRECTORY_SEPARATOR . 'ContractStub.stub');

        $templateReplaced = $this->replaceTemplate($stub, $modelName);

        $path = $this->checkDir('Repositories/Contracts');

        file_put_contents($path . DIRECTORY_SEPARATOR . $modelName . 'Contract.php', $templateReplaced);

        $this->info('Contract ' . $modelName . 'Contract.php' . ' Generated Successfully');

    }

    public function generateController($modelName, $namespace): void
    {
        $stub = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'ConcreteModulesStubs' . DIRECTORY_SEPARATOR . 'ControllerStub.stub');

        $templateReplaced = $this->replaceTemplate($stub, $modelName, $namespace);

        $path = $this->checkDir('Http/Controllers/' . $namespace);

        file_put_contents($path . DIRECTORY_SEPARATOR . $modelName . 'Controller.php', $templateReplaced);

        $this->info('Controller ' . $modelName . 'Controller.php' . ' Generated Successfully');
    }


    public function checkDir($folder): string
    {
        if (!file_exists(app_path() . DIRECTORY_SEPARATOR . $folder)) {
            mkdir(app_path() . DIRECTORY_SEPARATOR . $folder, 0777, true);
        }
        return app_path() . DIRECTORY_SEPARATOR . $folder;
    }


    protected function getModels(): array
    {
        $files = Storage::disk('app')->files('Models');
        return collect($files)->map(function ($file) {
            return basename($file, '.php');
        })->toArray();
    }

    public function replaceTemplate($template, $modelName, $namespace = null): string
    {
        $replace = [
            '[modelName]',
            '[namespace]'
        ];

        if ($namespace) {
            $template = $this->replaceNamespace($template, $namespace);
        }

        return str_replace($replace, $modelName, $template);
    }

    public function replaceNamespace($template, $namespace): string
    {
        $replace = [
            '[namespace]'
        ];
        $namespace = str_replace('/', '\\', $namespace);

        return str_replace($replace, $namespace, $template);
    }
}
