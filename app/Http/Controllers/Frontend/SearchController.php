<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-02
 * Time: 16:38
 */

namespace App\Http\Controllers\Frontend;

use App\Jobs\GetAlbumDetails;
use App\Models\Lyricist;
use App\Models\Playlist;
use App\Models\Podcast;
use App\Models\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use View;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Album;
use App\Models\User;
use App\Models\City;
use App\Models\Event;
use DB;
use App\Modules\Spotify\Spotify;

class SearchController
{
    private $request;
    private $term;
    private $limit;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->term = $this->request->is('api*') ? $this->request->input('q') : $this->request->route('slug');
        (isset($_GET['limit']) ? $this->limit = intval($_GET['limit']) :  $this->limit = 20);
    }

    public function user()
    {
        $result = (Object) array();
        $result->users = User::where('name', 'like', '%' . $this->term . '%')->paginate($this->limit);

        if( $this->request->is('api*') || $this->request->wantsJson() )
        {
            return response()->json($result->users);
        }

        $view = View::make('search.user')
            ->with('result', $result)
            ->with('term', $this->term);

        if($this->request->ajax()) {
            $sections = $view->renderSections();

            if($this->request->input('page') && intval($this->request->input('page')) > 1)
            {
                return $sections['pagination'];
            } else {
                return $sections['content'];
            }
        }

        $item = new \stdClass();
        $item->term = $this->term;
        getMetatags($item);

        return $view;
    }
}
