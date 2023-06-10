<?php
/**
 * Created by PhpStorm.
 * User: lechchut
 * Date: 7/29/19
 * Time: 1:18 PM
 */

namespace App\Models;

use App\Traits\SanitizedRequest;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use SanitizedRequest;

    protected $table = 'projects';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
