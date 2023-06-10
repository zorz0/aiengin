<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Models\Channel;
use App\Models\Slide;
use View;
use MetaTag;
use Auth;
use Cache;

/**
 *
 * Class Homepage
 * @package App\Http\Controllers\Frontend
 */
class HomeController
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function index() {
        \Artisan::call('migrate', ['--force' => true, '--database' => 'mysql']);

        $view = View::make('frontend.index');

        getMetatags();

        return $view;
    }
}
