<?php
/**
 * Created by NiNaCoder.
 * Date: 2023-02-20
 * Time: 21:20
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Email;
use App\Models\Service;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use View;
use App\Models\User;
use Auth;
use Hash;

class PlansController
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function getPlans(){
        $services = Service::all();

        return response()->json($services);
    }

    public function getPlanById() {
        return response()->json(Service::findOrFail($this->request->route('id')));
    }
}
