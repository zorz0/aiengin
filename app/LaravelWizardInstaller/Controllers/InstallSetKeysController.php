<?php

namespace App\LaravelWizardInstaller\Controllers;

use App\LaravelWizardInstaller\Exceptions\CantGenerateKeyException;
use dacoto\SetEnv\Facades\SetEnv;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class InstallSetKeysController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        try {
            Artisan::call('key:generate', ['--force' => true, '--show' => true]);
            if (empty(env('APP_KEY'))) {
                $content = file_get_contents(base_path('/.env.example'));
                $key = 'base64:'.base64_encode($this->randomString(32));
                $content = preg_replace("/(.*?APP_KEY=).*?(.+?)\\n/msi", '${1}' . $key . "\n", $content);
                $url = url('');
                file_put_contents(base_path('.env'), $content);
            }
            if (empty(env('APP_KEY'))) {
                throw new CantGenerateKeyException();
            }
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        Artisan::call('storage:link', ['--force' => true]);

        try {
            foreach (config('installer.commands', []) as $command) {
                Artisan::call($command);
            }
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('LaravelWizardInstaller::install.admin');
    }
}
