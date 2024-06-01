<?php

namespace App\Providers;

use App\Repositories\Concretes\ProfileConcrete;
use App\Repositories\Contracts\ProfileContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach ($this->getModels() as $model) {
            $this->app->bind(
                "App\Repositories\Contracts\\{$model}Contract",
                "App\Repositories\Concretes\\{$model}Concrete"
            );
        }

        $this->registerContracts();
    }

    public function boot(): void
    {
        //
    }

    public function registerContracts(): void
    {
        $this->app->bind(ProfileContract::class, ProfileConcrete::class);
    }


    protected function getModels(): Collection
    {
        $files = Storage::disk('app')->files('Models');
        return collect($files)->map(function ($file) {
            return basename($file, '.php');
        });
    }
}
