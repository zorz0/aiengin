<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-09
 * Time: 17:49
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Connect;
use App\Models\Content;
use App\Models\Project;
use App\Models\Session;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Response;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use Hash;
use Socialite;
use Illuminate\Support\Str;
use View;
use App\Models\Banned;
use App\Models\Email;
use Image;
use App\Models\RoleUser;
use App\Models\Role;
use Laravel\Socialite\Two\InvalidStateException;
use OpenAI\Laravel\Facades\OpenAI;

class AuthController
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function emailValidate()
    {
        $this->request->validate([
            'email' => 'required|email|unique:users',
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup()
    {
        $this->request->validate([
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $verifyCoder = Str::random(32);

        $user = new User();

        $user->email = $this->request->email;
        $user->name = $this->request->name;
        $user->password = bcrypt($this->request->password);
        $user->email_verified_code = $verifyCoder;

        $user->save();

        /** Send activation email if registration method is advanced */
        if(config('settings.registration_method') == 1) {
            try {
                (new Email)->verifyAccount($user, route('frontend.account.verify', ['code' => $verifyCoder]));
            } catch (\Exception $exception) {

            }

            return response()->json([
                'activation' => true,
                'email' => 'sent'
            ]);
        }

        /** If registration method is simplified then login the user right away  */
        $login = [
            'email' => $this->request->email,
            'password' => $this->request->password,
        ];

        if(auth()->attempt($login, true))
        {
            /** send welcome email */
            try {
                (new Email)->newUser(auth()->user());
            } catch (\Exception $exception) {

            }

            if( $this->request->is('api*') )
            {
                $user = $this->request->user();
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($this->request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                return response()->json([
                    'user' => $user,
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ]);
            } else {
                return $this->request->user();
            }
        }
    }

    /**
     * Check if banned and get user IP
     */

    private function userBannedCheck(){
        if(auth()->user()->banned) {
            $banned = Banned::find(auth()->user()->id);
            if(isset($banned->end_at)) {
                if(Carbon::now()->timestamp >= Carbon::parse($banned->end_at)->timestamp){
                    User::where('id', auth()->user()->id)
                        ->update(['banned' => 0]);
                    Banned::destroy($banned->user_id);
                } else {
                    return response()->json([
                        'message' => 'Unauthorized',
                        'errors' => array('message' => array(__('auth.banned', ['banned_reason' => $banned->reason, 'banned_time' =>  Carbon::parse($banned->end_at)->format('H:i F j Y')])))
                    ], 403);
                }
            }
        }

        $user = auth()->user();
        $user->logged_ip = request()->ip();
        $user->save();
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login()
    {

        $this->request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $this->request->email,
            'password' => $this->request->password,
        ];

        if(!auth()->attempt($credentials, true))
        {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => array('message' => array(__('auth.failed')))
            ], 401);
        }

        if(config('settings.registration_method') == 1) {
            if(!auth()->user()->email_verified){
                auth()->logout();
                return response()->json([
                    'message' => 'Unauthorized',
                    'errors' => array('message' => array(__('auth.email_verification_required')))
                ], 401);
            }
        }

        $this->userBannedCheck();

        if(env('SESSION_DRIVER') == 'database') {
            $conCurrentCount = Session::where('user_id')->count();
            if(intval(Role::getValue('option_concurent')) != 0 && $conCurrentCount >= intval(Role::getValue('option_concurent'))) {
                $lastSession = Session::where('user_id')->first();
                $lastSession->delete();
            }
        }

        if( $this->request->is('api*') )
        {
            $user = $this->request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addYear();
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'user' => $user,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }

        return $this->request->user();
    }

    private function createdToken($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(30);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function socialiteLogin($provider)
    {
        if(request()->route()->getName() == 'frontend.auth.login.socialite.redirect' && ! request()->isMethod('post')) {
            if(($provider) == 'google') {
                return Socialite::driver('google')->setScopes(['openid', 'email'])->redirect();
            } else {
                return Socialite::driver($provider)->redirect();
            }
        } else {
            if(($provider) == 'twitter') {
                $service = Socialite::driver('twitter')->userFromTokenAndSecret($this->request->input('oauth_token'), config('services.twitter.client_secret'));
            } else {
                $service = Socialite::driver($provider)->user();
            }



            $connect = Connect::where('provider_id', $service->id)->where('service', $provider)->first();
            if(isset($connect->user_id)) {
                $authUser = User::find($connect->user_id);

                if(isset($authUser->id)) {
                    $authUser->logged_ip = request()->ip();
                    $authUser->save();

                    if ($this->request->is('api*')) {
                        return $this->createdToken($authUser);
                    } else {
                        Auth::loginUsingId($authUser->id, true);

                        /**
                         * Create token for mobile app sign
                         */

                        if(file_exists(storage_path('oauth-private.key'))) {
                            $user = auth()->user();
                            $tokenResult = $user->createToken('Personal Access Token');
                            $token = $tokenResult->token;
                            $token->expires_at = Carbon::now()->addWeeks(30);
                            $token->save();
                            return view('frontend.commons.service')->with(['service' => $service, 'provider' => $provider, 'token' => $tokenResult->accessToken]);
                        } else {
                            return view('frontend.commons.service')->with(['service' => $service, 'provider' => $provider, 'token' => '']);
                        }
                    }
                } else {
                    $connect->delete();
                }
            }

            if(isset($service->email))
            {
                $authUser = User::where('email', $service->email)->first();

                if($authUser)
                {
                    $authUser->logged_ip = request()->ip();
                    $authUser->save();

                    if( $this->request->is('api*') )
                    {
                        return $this->createdToken($authUser);
                    }

                    auth()->loginUsingId($authUser->id);

                    Connect::create(
                        [
                            'user_id' => auth()->user()->id,
                            'provider_id' => $service->id,
                            'provider_name' => $service->name,
                            'provider_email' => $service->email ? $service->email : null,
                            'provider_artwork' => $service->avatar ? $service->avatar : null,
                            'service' => $provider
                        ]
                    );

                    $this->userBannedCheck();

                    /**
                     * Create token for mobile app sign
                     */

                    if(file_exists(storage_path('oauth-private.key'))) {
                        $user = auth()->user();
                        $user->logged_ip = request()->ip();
                        $user->save();

                        $tokenResult = $user->createToken('Personal Access Token');
                        $token = $tokenResult->token;
                        $token->expires_at = Carbon::now()->addWeeks(30);
                        $token->save();
                        return view('frontend.commons.service')->with(['service' => $service, 'provider' => $provider, 'token' => $tokenResult->accessToken]);
                    } else {
                        return view('frontend.commons.service')->with(['service' => $service, 'provider' => $provider, 'token' => '']);
                    }
                }
            }

            $user = User::create([
                'name' => $service->name ? $service->name : ('Unknown_' . Str::random(4)),
                'password' => bcrypt(Str::random(16)),
                'logged_ip' => request()->ip(),
                'email' => isset($service->email) ? $service->email : NULL
            ]);

            if($service->avatar) {
                if ($provider == 'google') {
                    $service->avatar = str_replace('?sz=50', '', $service->avatar);
                } elseif ($provider == 'twitter') {
                    $service->avatar = str_replace('_normal', '', $service->avatar);
                } elseif ($provider == 'facebook') {
                    $service->avatar = str_replace('type=normal', 'type=large', $service->avatar);
                }
            }

            if($service->avatar) {
                try {
                    $user->addMediaFromUrl($service->avatar)
                        ->usingFileName(time(). '.jpg')
                        ->toMediaCollection('artwork', config('settings.storage_artwork_location', 'public'));
                } catch (\Exception $e) {

                }
            }

            Connect::create(
                [
                    'user_id' => $user->id,
                    'provider_id' => $service->id,
                    'provider_name' => $service->name ? $service->name : Str::random(8),
                    'provider_email' => $service->email ? $service->email : null,
                    'provider_artwork' => $service->avatar ? $service->avatar : null,
                    'service' => $provider
                ]
            );

            if( $this->request->is('api*') )
            {
                return $this->createdToken($user);
            }

            auth()->loginUsingId($user->id, true);

            /**
             * Create token for mobile app sign
             */

            if(file_exists(storage_path('oauth-private.key'))) {
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(30);
                $token->save();
                return view('frontend.commons.service')->with(['service' => $service, 'provider' => $provider, 'token' => $tokenResult->accessToken]);
            } else {
                return view('frontend.commons.service')->with(['service' => $service, 'provider' => $provider, 'token' => '']);
            }

        }
    }

    public function socialiteRemove($provider)
    {
        $connect = Connect::where('user_id', auth()->user()->id)->where('service', $provider)->first();
        $connect->delete();

        return Response::json(array(
            'success' => true,
            'message' => 'Successfully removed service.'
        ), 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout()
    {
        auth()->logout();
        return Response::json(array(
            'success' => true,
            'message' => 'Successfully logged out.'
        ), 200);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user()
    {
        $user = $this->request->user();
        $user->last_activity = Carbon::now();
        $user->logged_ip = request()->ip();
        $user->save();
        $user->subscription = Subscription::with('service')->where('user_id', $user->id)->first();

        /**
         * Check and send user back to default group if there is time limit
         */

        $role = RoleUser::where('user_id', $user->id)->first();

        if(isset($role->end_at) && Carbon::now()->gt(Carbon::parse($role->end_at))) {
            $role->role_id = config('settings.default_usergroup', 5);
            $role->end_at = null;
            $role->save();
        }

        $user = $user->makeVisible(['banned', 'email', 'email_verified_at', 'last_seen_notif', 'logged_ip'])->makeHidden(['roles']);
        $user->admin_panel = !! Role::getValue('admin_access');
        $user->items_generated = Content::where('user_id', auth()->user()->id)->count();
        $user->tools_used = count(DB::table('contents')
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->where('user_id', auth()->user()->id)
            ->get());

        //Content::where('user_id', auth()->user()->id)->groupBy('type')->count();

        if ($this->request->is('api*')) {
            return response()->json($user);
        }

        if(Role::getValue('admin_access')) {
            $user->admin_panel_url = route('backend.dashboard');
        }

        return response()->json($user);
    }

    public function settingsProfile()
    {
        $this->request->validate([
            'name' => 'required|string|max:50',
        ]);

        $user = auth()->user();

        if($this->request->input('email') != $user->email)
        {
            $this->request->validate([
                'email' => 'required|string|email|unique:users',
            ]);

            $user->email = $this->request->input('email');
        }

        if ($this->request->hasFile('artwork'))
        {
            $this->request->validate([
                'artwork' => 'required|image|mimes:jpeg,png,jpg,gif,webp|dimensions:min_width=' . config('settings.image_avatar_size', 300) . ',min_height=' . config('settings.image_avatar_size', 300) . '|max:' . config('settings.max_image_file_size', 8096)
            ]);

            $user->clearMediaCollection('artwork');
            $user->addMediaFromBase64(base64_encode(Image::make($this->request->file('artwork'))->orientate()->fit(intval(config('settings.image_artwork_max', 300)),  intval(config('settings.image_artwork_max', 300)))->encode('jpg', config('settings.image_jpeg_quality', 90))->encoded))
                ->usingFileName(time(). '.jpg')
                ->toMediaCollection('artwork', config('settings.storage_artwork_location', 'public'));
        }

        $user->name = strip_tags($this->request->input('name'));
        $user->save();
        $user->makeHidden(['password', 'remember_token']);
        return response()->json($user);
    }

    public function settingsPassword()
    {
        $this->request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if(Hash::check($this->request->input('current_password'),  auth()->user()->password)) {

            $user = auth()->user();
            $user->password = Hash::make($this->request->input('password'));
            $user->save();
            auth()->setUser($user);
            return response()->json(auth()->user());

        } else {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' =>  array('current_password' => array('Your current password is incorrect.'))
            ], 401);
        }
    }

    public function notifications (){
        $user = auth()->user();
        $user->last_seen_notif =  Carbon::now();
        $user->save();

        if( $this->request->is('api*') )
        {
            $notifications = [];
            foreach ($user->notifications()->toArray() as $index => $item) {
                $notifications[] = $item;
            }
            return response()->json($notifications);
        }

        $view = View::make('commons.notification')
            ->with('notifications', $user->notifications());
        return $view;
    }

    public function notificationCount (){
        $user = auth()->user();

        return response()->json(array(
            'success' => true,
            'notification_count' => $user->notification_count,
            'last_seen_notif' => $user->last_seen_notif
        ));
    }

    public function getProjects() {
        return response()->json(Project::where('user_id', auth()->user()->id)->get());
    }

    public function createProject() {
        $this->request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        $project = new Project();
        $project->name = $this->request->input('name');
        $project->description = $this->request->input('description');
        $project->user_id = auth()->user()->id;
        $project->save();

        return response()->json($project);
    }

    public function deleteProject() {
        $this->request->validate([
            'id' => 'required|integer',
        ]);

        $project = Project::findOrFail($this->request->input('id'));
        $project->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function saveContent () {
        $this->request->validate([
            'id' => 'nullable|integer',
            'type' => 'required|string',
            'content' => 'nullable|string',
        ]);

        if($this->request->input('id')) {
            $content = Content::findOrFail($this->request->input('id'));
        } else {
            $content = new Content();
        }

        $content->type = $this->request->input('type');
        $content->content = $this->request->input('content');
        $content->user_id = auth()->user()->id;
        if($this->request->header('Current-Project')) {
            $content->project_id = intval($this->request->header('Current-Project'));
        }

        $content->save();

        return response()->json($content);
    }

    public function saveImageContent() {
        $this->request->validate([
            'type' => 'required|string',
            'content' => 'nullable|string',
        ]);
        $content = new Content();
        $content->addMediaFromUrl($this->request->input('content'))
            ->usingFileName(time(). '.png')
            ->toMediaCollection('artwork', config('settings.storage_artwork_location', 'public')
        );
        $content->content = 'imageURL';
        $content->type = $this->request->input('type');
        $content->user_id = auth()->user()->id;
        if($this->request->header('Current-Project')) {
            $content->project_id = intval($this->request->header('Current-Project'));
        }
        $content->save();
        $content->content = str_replace(url(''), '', $content->getFirstMediaUrl('artwork'));
        $content->save();

        return response()->json($content);
    }

    public function getContentById () {
        $this->request->validate([
            'id' => 'required|integer',
        ]);

        $content = Content::findOrFail($this->request->input('id'));

        return response()->json($content);
    }

    public function deleteContentById () {
        $this->request->validate([
            'id' => 'required|integer',
        ]);

        $content = Content::where('user_id', auth()->user()->id)->where('id', $this->request->input('id'))->firstOrFail();
        $content->delete();

        return response()->json(['success' => true]);
    }

    public function getContents () {
        $this->request->validate([
            'type' => 'nullable|string',
        ]);

        $contents = Content::query();

        if($this->request->input('type')) {
            $contents = $contents->where('type', $this->request->input('type'));
        }

        if($this->request->header('Current-Project')) {
            $contents = $contents->where('project_id', intval($this->request->header('Current-Project')));
        } else {
            $contents = $contents->whereNull('project_id');
        }

        if(!$this->request->input('type')) {
            $contents = $contents->where('type', '!=', 'image-generator');
        }
        $contents = $contents->where('user_id', auth()->user()->id);

        $contents = $contents->latest()->paginate(20);

        return response()->json($contents);
    }

    public function cancelSubscription () {
        $subscription = Subscription::where('user_id', auth()->user()->id)->firstOrFail();
        $subscription->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function textGenerator() {
        $this->request->validate([
            'action' => 'required|string',
        ]);

        if(auth()->user()->tokens <= 0) {
            return response()->json([
                'text' => 'Insufficient! You do not have enough tokens.',
                'usage' => 0,
            ]);
        }

        $prompt = base64_decode($this->request->input('action'));

        if($this->request->header('Content-Language')) {
            $prompt = $prompt . ' -> write in ' . $this->request->header('Content-Language');
        }

        $max_retries = 3;
        $num_retries = 0;
        $result = null;

        while ($num_retries < $max_retries && $result === null) {
            try {
                $result = OpenAI::completions()->create([
                    'model' => 'text-davinci-003',
                    'prompt' => $prompt,
                    'max_tokens' => intval(config('settings.max_tokens', 500)),
                ]);
            } catch (\Exception $e) {
                // Handle the API request error here, if desired
                $num_retries++;
            }
        }

        if ($result === null) {
            return response()->json([
                'text' => 'Can not get result from openAI.',
                'usage' => 0,
            ]);
        }

        if(auth()->user()->tokens < $result['usage']['completion_tokens']) {
            auth()->user()->tokens = 0;
            auth()->user()->save();
        } else {
            auth()->user()->decrement('tokens', $result['usage']['completion_tokens']);
        }

        auth()->user()->increment('words_generated', $result['usage']['completion_tokens']);

        return response()->json([
            'text' => $result['choices'][0]['text'],
            'usage' => $result['usage']['total_tokens'],
        ]);

    }

    public function imageGenerator() {
        $this->request->validate([
            'action' => 'required|string',
        ]);

        if(auth()->user()->tokens <= 0) {
            return response()->json([
                'message' => 'Insufficient',
                'errors' => array('message' => 'You do not have enough tokens.')
            ], 503);
        }

        $prompt = base64_decode($this->request->input('action'));

        $max_retries = 3;
        $num_retries = 0;
        $result = null;

        while ($num_retries < $max_retries && $result === null) {
            try {
                $result = OpenAI::images()->create([
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => config('settings.image_size', '256x256'),
                    'response_format' => 'url',
                ]);
            } catch (\Exception $e) {
                $num_retries++;
            }
        }

        if ($result === null) {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => array('message' => 'Can not get result from openAI.')
            ], 500);
        }


        if(auth()->user()->tokens < 50) {
            auth()->user()->tokens = 0;
            auth()->user()->save();
        } else {
            auth()->user()->decrement('tokens', 50);
        }

        auth()->user()->increment('words_generated', 50);

        return response()->json($result);

    }
}
