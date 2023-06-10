<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-06-19
 * Time: 23:42
 */

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Page;
use View;
use MetaTag;
use DB;

class PageController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getPages()
    {
        return response(DB::table('pages')->select(['id', 'title', 'alt_name'])->get());
    }

    public function getPageByAltName()
    {
        $page = Page::where('alt_name', $this->request->route('slug'))->firstOrFail();
        return response()->json($page);
    }
}
