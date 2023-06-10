<?php

namespace App\LaravelWizardInstaller\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PDO;

class InstallAdminAccountController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        return view('installer::steps.admin');
    }
}
