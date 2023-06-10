<?php


namespace App\Modules\MobileHelper;

use Illuminate\Http\Request;

class APISession
{
    public function apiSession() {
        $token = request()->input('token');
        if($token && strlen($token) > 30) {
            $http = new \GuzzleHttp\Client;

            $response = $http->post(route('api.auth.user'), [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '. $token,
                ],
            ]);

            $user = json_decode((string) $response->getBody());

            if(isset($user->id)) {
                auth()->loginUsingId($user->id);
            } else {
                abort('403', 'Unauthenticated');
                exit;
            }
        }
    }
}
