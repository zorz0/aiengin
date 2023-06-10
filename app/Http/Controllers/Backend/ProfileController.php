<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-05-25
 * Time: 09:02
 */

namespace App\Http\Controllers\Backend;

use App\Models\Activity;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Banned;
use App\Models\Comment;
use App\Models\Playlist;
use App\Models\Post;
use App\Models\RoleUser;
use Carbon\Carbon;
use Auth;
use Image;

class ProfileController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('backend.profile.edit')
            ->with('user', auth()->user());
    }

    public function editPost()
    {
        $user = auth()->user();

        $this->request->validate([
            'name' => 'required|string',
        ]);

        if($this->request->input('email') != $user->email)
        {
            $this->request->validate([
                'email' => 'string|email|unique:users',
            ]);
        }

        if ($this->request->input('removeArtwork')) {
            $user->clearMediaCollection('artwork');
        } else {
            if ($this->request->hasFile('artwork'))
            {
                $this->request->validate([
                    'artwork' => 'required|image|mimes:jpeg,png,jpg,gif|max:' . config('settings.max_image_file_size', 8096)
                ]);

                $user->clearMediaCollection('artwork');
                $user->addMediaFromBase64(base64_encode(Image::make($this->request->file('artwork'))->orientate()->fit(intval(config('settings.image_artwork_max', 500)),  intval(config('settings.image_artwork_max', 500)))->encode('jpg', config('settings.image_jpeg_quality', 90))->encoded))
                    ->usingFileName(time(). '.jpg')
                    ->toMediaCollection('artwork', config('settings.storage_artwork_location', 'public'));
            }
        }

        if ($this->request->input('deleteComments')) {
            //Comment::where('user_id', $user->id)->delete();
        }

        $user->name = $this->request->input('name');
        $user->email = $this->request->input('email');
        $user->banned = $this->request->input('banned') ?? 0;

        if($this->request->input('password'))
        {
            $user->password = bcrypt($this->request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('status', 'success')->with('message', 'Your profile has been successfully updated!');

    }

}
