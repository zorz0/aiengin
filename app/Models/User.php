<?php

namespace App\Models;

use App\Traits\SanitizedRequest;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cache;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, InteractsWithMedia, SanitizedRequest;

    protected $fillable = [
        'name', 'email', 'password', 'email_verified_code'
    ];

    protected $appends = [
        'artwork_url'
    ];

    protected $hidden = [
        'media', 'password', 'email_verified_code', 'remember_token'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            RoleUser::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'role_id' => config('settings.default_usergroup', 5),
            ]);
        });

        self::creating(function ($model) {
            $model->last_seen_notif = Carbon::now();
            if(Cache::has('usergroup')) {
                $roles = Cache::get('usergroup');
            } else {
                $roles = Role::all();
                Cache::forever('usergroup', $roles);
            }

            $role = $roles->firstWhere('id', config('settings.default_usergroup', 5));
            if(isset($role) && isset($role->permissions['free_tokens'])) {
                $model->tokens = $role->permissions['free_tokens'];
            }
        });
    }

    public function getArtworkUrlAttribute($value)
    {
        $media = $this->getFirstMedia('artwork');
        if(! $media) {
            return null;
        } else {
            if($media->disk == 's3') {
                return $media->getTemporaryUrl(Carbon::now()->addMinutes(intval(config('settings.s3_signed_time', 5))));
            } else {
                return $media->getFullUrl();
            }
        }
    }

    public function ban() {
        return $this->hasOne(Banned::class);
    }

    public function group()
    {
        return $this->hasOne(RoleUser::class)->with('role');
    }

    public function subscription(){
        return $this->hasOne(Subscription::class);
    }

    public function connect(){
        return $this->hasMany(Connect::class);
    }

    public function delete()
    {
        return parent::delete();
    }
}
