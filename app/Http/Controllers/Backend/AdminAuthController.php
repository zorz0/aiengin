<?php
/**
 * Created by NiNaCoder.
 * Date: 2023-02-20
 * Time: 13:09
 */

namespace App\Http\Controllers\Backend;

use App\Models\Artist;
use App\Models\Episode;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Response;
use DB;
use App\Models\Song;
use Config;
use Image;
use Storage;
use App\Models\Upload;
use View;
use Route;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Email;
use App\Models\Role;

class AdminAuthController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getLogin()
    {
        if (auth()->check()) {
            //if is already logged in
            return redirect(route('backend.dashboard'));
        } else {
            return view('backend.login');
        }

    }

    public function postLogin()
    {

        $this->request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $login = [
            'email' => $this->request->input('email'),
            'password' => $this->request->input('password'),
        ];
        if (auth()->attempt($login, $this->request->input('remember'))) {
            if(Role::getValue('admin_access')) {
                return redirect(route('backend.dashboard'));
            } else {
                return redirect()->back()->with('status', 'failed')->with('message', trans('auth.failed'));
            }
        } else {
            return redirect()->back()->with('status', 'failed')->with('message', trans('auth.failed'));
        }
    }

    /**
     * action admin/logout
     * @return RedirectResponse
     */
    public function getLogout()
    {
        auth()->logout();
        return redirect()->route('backend.login');
    }

    public function forgotPassword()
    {
        return view('backend.forgot-password');
    }

    public function forgotPasswordPost(){

        $this->request->validate([
            'email' => 'string|email|exists:users',
        ]);

        $user = User::where('email',  $this->request->input('email'))->firstOrFail();

        $row = DB::table("password_resets")->select('email')->where('email', $user->email)->first();
        $token = Str::random(60);

        if(isset($row->email))
        {
            DB::table("password_resets")->where('email', $user->email)->update([
                'token' => $token,
                'created_at' => Carbon::now()

            ]);

        } else {
            DB::table("password_resets")->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()

            ]);
        }

        (new Email)->resetPassword($user, route('backend.reset-password', ['token' => $token]));

        return redirect()->back()->with('status', 'success')->with('message', trans('passwords.sent'));
    }

    public function resetPassword()
    {
        $row = DB::table("password_resets")->select('email')->where('token', $this->request->route('token'))->first();

        if(isset($row->email))
        {
            $user = User::where('email',  $row->email)->firstOrFail();
            /**
             * Log user in then show the change password form
             */
            auth()->login($user);
            return view('backend.reset-password');
        } else {
            return redirect()->route('backend.forgot-password')->with('status', 'failed')->with('message', trans('Your reset code is invalid or has expired.'));
        }
    }

    public function resetPasswordPost()
    {
        if(! auth()->check())
        {
            abort('403');
        }

        $this->request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        /**
         * Change user password
         */
        $user = auth()->user();
        $user->password = bcrypt($this->request->input('password'));
        $user->save();

        /**
         * Delete password reset token
         */
        DB::table("password_resets")->where('email', $user->email)->delete();

        return redirect()->route('backend.dashboard')->with('status', 'success')->with('message', __('passwords.reset'));
    }
}
