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

class InstallSetAdminAccountController extends Controller
{
    public function __invoke(Request $request): Factory|View|Application|Request|RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = new \App\Models\User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = \Hash::make($request->input('password'));
            $user->save();

            \App\Models\RoleUser::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'role_id' => 1,
            ]);

            \Auth::login($user);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('LaravelWizardInstaller::install.finish');
    }
}
