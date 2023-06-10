<?php
/**
 * Created by NiNaCoder.
 * Date: 2023-02-20
 * Time: 21:20
 */

namespace App\Http\Controllers\Frontend;

use App\Modules\MobileHelper\APISession;
use Cookie;

class PaymentController extends APISession
{
    public function availablePayments()
    {
        $gateways = config('payment.gateways');
        $buffer = array();

        foreach ($gateways as $key => $gateway) {
            unset($gateways[$key]['enable']);
            unset($gateways[$key]['public_key']);
            unset($gateways[$key]['secret_key']);
            unset($gateways[$key]['environment']);
            unset($gateways[$key]['encryption']);
            $gateways[$key]['subscriptionLink'] = route($gateways[$key]['subscriptionLink'], ['id' => ':id']);


            if($gateway['enable']) {
                $buffer = $gateways[$key];
            }
        }

        return response()->json($gateways);
    }
}
