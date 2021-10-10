<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBill;
use Illuminate\Support\Facades\Cache;
use App\Models\Services;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function getOrder($id, $user_id)
    {
        $user = User::find($user_id);
        if($id){
            $price_service = Services::find($id);
            $bill = new ServiceBill();
            $bill->service_id = $id;
            $bill->user_id = $user_id;
            $bill->order_code = Str::random(15);
            $bill->price = $price_service->price;
            if(($user->amount - $price_service->price) > 0){
                $bill->save();
                return response()->json([
                    'status' => 'success',
                ]);
            }else
            {
                return response()->json([
                    'status' => 'fail',
                ]);
            }
        }
        // $diff_in_minutes = $to->diffInMinutes($from);
        // dd($diff_in_minutes);
    }

    public function checkOrder()
    {
        $order = ServiceBill::where('status', 0)->first();
        if($order){
            $lock = Cache::lock($order->order_code, 10);
            if ($lock->get()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Have an order',
                    'order_code' => $order->order_code,
                    'service' => $order->service->name
                ]);
            }
        }
    }

    public function updatePhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $add_phone = ServiceBill::where('order_code', $request->order_code)->first();
        if(!isset($add_phone)){
            return response()->json([
                'status' => 'error',
                'message' => 'Add phone number failed. Incorrect order code',
            ],500);
        }else{
            $add_phone->phone_number = $request->phone_number;
            $add_phone->save();
            return response()->json([
                'status' => 'success',

                'message' => 'Added phone number successfully'
            ],200);
        }
    }
}
