<?php

namespace Tnchalise\Tiks;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Tnchalise\Tiks\Console\Commands\ArchiveLedgers;
use Tnchalise\Tiks\Console\Commands\MakeModel;

class ServiceProvider extends BaseProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ArchiveLedgers::class,
                MakeModel::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ledger-archive.php' => config_path('ledger-archive.php'),
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
                __DIR__ . '/../sh/make-model-auditable.sh' => base_path('sh/make-model-auditable.sh'),
                __DIR__ . '/../src/Models/RecordableModel.php' => app_path('Models/RecordableModel.php'),
                __DIR__ . '/../src/Models/TiksLedger.php' => app_path('Models/TiksLedger.php'),
                __DIR__ . '/../resources/stubs' => resource_path('stubs'),
            ], 'tiks-audit');
        }
    }
}
