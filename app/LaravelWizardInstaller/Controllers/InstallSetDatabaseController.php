<?php

namespace App\LaravelWizardInstaller\Controllers;

use dacoto\SetEnv\Facades\SetEnv;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PDO;

class InstallSetDatabaseController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        if (
            !(new InstallServerController())->check() ||
            !(new InstallFolderController())->check()
        ) {
            return redirect()->route('LaravelWizardInstaller::install.folders');
        }

        try {
            $credentials = [
                'host' => $request->input('database_hostname'),
                'database' => $request->input('database_name'),
                'username' => $request->input('database_username'),
                'password' => $request->input('database_password', ''),
            ];

            $db = 'mysql:host=' . $credentials['host'] . ';dbname=' . $credentials['database'];

            $connection = $db = new \PDO($db, $credentials['username'], $credentials['password'], array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        try {
            $content = file_get_contents(base_path('.env.example'));
            foreach ($credentials as $key => $value) {
                if ( ! $value) $value = '';
                preg_match("/(DB_$key=)(.*?)\\n/msi", $content, $matches);
                $content = str_replace($matches[1].$matches[2], $matches[1].$value, $content);
            }
            $url = url('');
            $content = preg_replace("/(.*APP_URL=).*?(.+?)\\n/msi", '${1}' . rtrim($url, '/') . "\n", $content);
            file_put_contents(base_path('.env.example'), $content);
            copy(base_path('.env.example'), base_path('.env'));
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('LaravelWizardInstaller::install.migrations');
    }
}
