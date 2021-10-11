<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBill;
use Illuminate\Support\Facades\Cache;
use App\Models\Services;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            } else {
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
        if ($order) {
            $lock = Cache::lock($order->order_code, 10);
            if ($lock->get()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Have an order',
                    'order_code' => $order->order_code,
                    'service' => $order->service->name
                ]);
                $lock->release();
            } else {
                return Http::get(url("/api/check-order"));
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No orders'
            ]);
        }
    }

    public function checkExpired()
    {
        // $diff_in_minutes = $to->diffInMinutes($from);
        // dd($diff_in_minutes);
        $id_arr = [];
        $bills_exprired = ServiceBill::where('code_status', 0)->get();
        foreach ($bills_exprired as $bill_exprired){
            if(Carbon::now()->diffInMinutes($bill_exprired->updated_at) >= 5){
                $id_arr[] = $bill_exprired->id;
            }
        }
        $update =  DB::table('service_bills')->whereIn('id', $id_arr)->update(['expired_time' => 1]);
        if($update){
            return response()->json([
                'status' => 'success',
                'message' => count($id_arr).' bills expired!',
            ], 200);
        }else{
            return response()->json([
                'status' => 'fail',
                'message' => 'No bills expired!',
            ], 500);
        }

    }
    public function updatePhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|unique:service_bills,phone_number',
            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $add_phone = ServiceBill::where('order_code', $request->order_code)->where('status', 0)->first();
        if (!isset($add_phone)) {
            $lock = Cache::lock($request->phone_number, 10);
            if ($lock->get()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Add phone number failed',
                ], 500);
                $lock->release();
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Add phone number failed',
                ], 500);
            }
        } else {
            $add_phone->phone_number = $request->phone_number;
            $add_phone->status = 1;
            $add_phone->save();
            $user = User::find($add_phone->user_id);
            $user->amount = $user->amount - $add_phone->price;
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Added phone number successfully'
            ], 200);
        }
    }

    public function checkCode()
    {
        $order_code = ServiceBill::where('status', 1)->where('code_status', 1)->first();
        if ($order_code) {
            $lock = Cache::lock('check_code_'.$order_code->order_code, 10);
            if ($lock->get()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Have a code order request',
                    'order_code' => $order_code->order_code,
                    'phone' => $order_code->phone_number,
                    'service' => $order_code->service->name
                ]);
                $lock->release();
            } else {
                return Http::get(url("/api/check-code"));
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No code order request'
            ]);
        }
    }
}
