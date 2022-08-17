<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Jobs\SendEmailJob;
use App\Models\Order;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {

        $user = Auth::guard('api')->user();

        if ($user) {

           $tracking = new Tracking;
           $tracking->user_id = $user->id;
           $tracking->tracking_code = $request->tracking_code;
           $tracking->save();

            for($i= 0; $i < count($request->items); $i++){
                $order_details[] = [
                    'tracking_id' => $tracking->id,
                    'shipping_price' => $request->items[$i]['shipping_price'],
                    'price' => $request->items[$i]['price'],
                    'category' => $request->items[$i]['category']
                ];
            }


            \DB::table('orders')->insert($order_details);

            dispatch(new SendEmailJob( $user->email, $tracking->tracking_code));
        }

        return response()->json(['message' => 'Error.....'], 401);
    }
}
