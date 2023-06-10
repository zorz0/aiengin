<?php

namespace App\LaravelWizardInstaller\Providers;

use App\LaravelWizardInstaller\Middleware\InstallerMiddleware;
use App\LaravelWizardInstaller\Middleware\ToInstallMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelWizardInstallerProvider extends ServiceProvider
{
    public function register(): void
    {
        $configPath = __DIR__ . '/../config.php';
        $this->mergeConfigFrom($configPath, 'installer');
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }

    public function boot(Router $router, Kernel $kernel): void
    {
        $kernel->prependMiddlewareToGroup('web', ToInstallMiddleware::class);
        $router->pushMiddlewareToGroup('installer', InstallerMiddleware::class);
        $viewPath = __DIR__ . '/../Resources/views';
        $this->loadViewsFrom($viewPath, 'installer');
    }
}
