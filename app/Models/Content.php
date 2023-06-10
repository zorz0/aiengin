<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-01
 * Time: 17:04
 */

namespace App\Models;

use App\Traits\SanitizedRequest;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Content extends Model implements HasMedia
{
    use InteractsWithMedia, SanitizedRequest;

    protected $hidden = [
        'media'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
