<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryTransaction;
use App\Models\ServiceBill;
use Illuminate\Support\Facades\Cache;
use App\Models\Services;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function getOrder($id, $token)
    {
        $prices = 0;
        $user = User::where('user_token', $token)->where('banned_status', 0)->first();
        $service = Services::find($id);
        $user_bill_price = ServiceBill::select('price')->where('status', 0)->where('user_id', $user->id)->get();
        foreach ($user_bill_price as $price){
            $prices += $price->price;
        }
        if($user){
            if($user->check_order == 0){
                $user->banned_status = 1;
                $user->user_token = '';
                $user->save();
                return response()->json([
                    'status' => 'banned',
                    'message' => 'Your account has been banned',
                ]);
            }else{
                if($service){
                    $price_service = Services::find($id);
                    $check_amount = $prices + $price_service->price;
                    if($user->amount - $check_amount >= 0){
                        $bill = new ServiceBill();
                        $bill->service_id = $id;
                        $bill->user_id = $user->id;
                        $bill->order_code = Str::random(15);
                        $bill->price = $price_service->price;
                        $user->check_order -= 1;
                        if(($user->amount - $price_service->price) >= 0){
                            $bill->save();
                            $user->save();
                            return response()->json([
                                'status' => 'success',
                                'orderCode' => $bill->order_code,
                                'message' => 'Order successfully'
                            ]);
                        } else {
                            return response()->json([
                                'status' => 'fail',
                                'message' => 'Order failed! Please try again'
                            ]);
                        }
                    }
                    else
                    {
                        return response()->json([
                            'status' => 'warning',
                            'message' => 'Order failed! Your amount is too low! Please try again'
                        ]);
                    }
                }else{
                    return response()->json([
                        'status' => 'fail',
                        'message' => 'Order id does not exist'
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => 'fail',
                'message' => 'Unknown user token'
            ]);
        }

        // $diff_in_minutes = $to->diffInMinutes($from);
        // dd($diff_in_minutes);
    }

    public function getPhone($order_code)
    {
        $bill = ServiceBill::where('order_code', $order_code)->where('status', 1 )->first();
        if($bill){
            $lock = Cache::lock('get_phone_'.$bill->phone_number, 10);
            if($lock->get()){
                if($bill->phone_number){
                    return response()->json([
                        'status' => 'success',
                        'phoneNumber' => $bill->phone_number,
                        'message' => 'Get phone number successfully!',
                    ]);
                    $lock->release();
                }else{
                    return response()->json([
                        'status' => 'fail',
                        'phoneNumber' => '',
                        'message' => 'No phone number yet!',
                    ]);
                }
            }
            else{
                return response()->json([
                    'status' => 'fail',
                    'phoneNumber' => '',
                    'message' => 'No order yet!',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => 'fail',
                'phoneNumber' => '',
                'message' => 'This order is already paid!',
            ]);
        }
    }


    public function getOtp($phone_number)
    {
        $service_bill = ServiceBill::where('phone_number', $phone_number)->where('status', 2)->first();
        if(isset($service_bill->code_otp) && $service_bill->code_otp != ''){
            return response()->json([
                'status' => 'success',
                'CodeOTP' => $service_bill->code_otp,
                'message' => 'Your Code OTP is: '.$service_bill->code_otp.' . This code will be expired after 5 minutes'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'No code available yet!'
            ]);
        }
    }

    public function checkOrder()
    {
        $order = ServiceBill::where('checked_status', 0)->where('expired_time',0)->first();
        if (isset($order)) {
            $lock = Cache::lock('check_order_'.$order->order_code, 10);
            if ($lock->get()) {
                $order->update(['checked_status' => 1]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Have an order',
                    'order_code' => $order->order_code,
                    'service' => $order->service->name
                ]);
                $lock->release();
                Artisan::call('cache:clear');
            } else {
                Artisan::call('cache:clear');
                return Http::get(url("/api/check-order"));
            }

        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'No orders'
            ]);
        }
    }

    public function checkExpired()
    {
        // $diff_in_minutes = $to->diffInMinutes($from);
        // dd($diff_in_minutes);
        $id_arr = [];
        $phone_exprired_arr = [];
        $bills_exprired = ServiceBill::where('code_otp', '=', null)->get();
        foreach ($bills_exprired as $bill_exprired){
            if(Carbon::now()->diffInMinutes($bill_exprired->updated_at) >= 5 && $bill_exprired->status == 1 && $bill_exprired->expired_time == 0){
                $id_arr[] = $bill_exprired->id;
                $bill_price = $bill_exprired->price;
                $service = $bill_exprired->service->name;
                $phone = $bill_exprired->phone_number;
                $user_check_order = User::find($bill_exprired->user_id);
                $user_check_order->amount = $user_check_order->amount + $bill_exprired->price;
                $user_check_order->save();
                $prices = $user_check_order->amount - $bill_price;
                $transaction = new HistoryTransaction();
                $transaction->user_id = $user_check_order->id;
                $transaction->price = $bill_price;
                $transaction->volatility = number_format($prices).' -> '.number_format($user_check_order->amount);
                $transaction->content = 'Hoàn tiền '.$service.'/'.$phone;
                $transaction->status = 1;
                $transaction->save();
            }else if(Carbon::now()->diffInMinutes($bill_exprired->updated_at) >= 10 && !isset($bill_exprired->phone_number) && $bill_exprired->status != 3){
                $phone_exprired_arr[] = $bill_exprired->id;
                // $user_check = User::find($bill_exprired->user_id);
                // $user_check->amount = $user_check->amount + $bill_exprired->price;
                // $user_check->save();
            }
        }
        $update =  DB::table('service_bills')->whereIn('id', $id_arr)->update(['expired_time' => 1, 'status' => 3, 'code_status' => 2]);
        $phone_exprired = DB::table('service_bills')->whereIn('id', $phone_exprired_arr)->update(['expired_time' => 1, 'status' => 3, 'code_status' => 2]);
        if($update || $phone_exprired){
            return response()->json([
                'status' => 'success',
                'message' => 'Bills expired!',
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
            'phone_number' => 'required|numeric|unique:service_bills,phone_number',
            'order_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $add_phone = ServiceBill::where('order_code', $request->order_code)->where('status', 0)->first();
        if (!isset($add_phone)) {
            $lock = Cache::lock('phone_'.$request->phone_number, 10);
            if ($lock->get()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Add phone number failed',
                ], 500);
                $lock->release();
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Add phone number failed',
                ], 500);
            }
        } else {
            $add_phone->phone_number = $request->phone_number;
            $add_phone->status = 1;
            $add_phone->code_status = 1;
            $add_phone->save();
            
            $user = User::find($add_phone->user_id);
            $user->amount = $user->amount - $add_phone->price;
            $user->save();
            $price = $user->amount + $add_phone->price;
            $transaction = new HistoryTransaction();
            $transaction->user_id = $user->id;
            $transaction->price = $add_phone->price;
            $transaction->volatility = number_format($price).' -> '.number_format($user->amount);
            $transaction->content = 'Mua sim '.$add_phone->service->name.'/'.$add_phone->phone_number;
            $transaction->save();
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
                    'status' => 'success',
                    'message' => 'Have a request code order',
                    'order_code' => $order_code->order_code,
                    'phone' => $order_code->phone_number,
                    'service' => $order_code->service->name
                ]);
                $lock->release();
                Artisan::call('cache:clear');
            } else {
                return Http::get(url("/api/check-code"));
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'No request code order'
            ]);
        }
    }

    public function updateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'code_otp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $add_code = ServiceBill::where('phone_number', $request->phone_number)
                                ->where('code_status', 1)
                                ->first();
        if (!isset($add_code)) {
            $lock = Cache::lock('code_'.$request->phone_number, 10);
            if ($lock->get()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'This order already has a code otp!',
                ], 500);
                $lock->release();
                Artisan::call('cache:clear');
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => 'This order already has a code otp!',
                ], 500);
            }
        } else {
            $add_code->code_otp = $request->code_otp;
            $add_code->content = 'Mã OTP là: '.$request->code_otp.'.<br> Mã hết hạn sau 5 phút';
            $add_code->code_status = 2;
            $add_code->status = 2;
            $add_code->save();
            $user = User::find($add_code->user_id);
            $user->check_order = 20;
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Added code otp successfully'
            ], 200);
        }
    }
}
