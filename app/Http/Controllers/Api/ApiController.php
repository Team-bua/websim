<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBill;
use Illuminate\Support\Facades\Cache;
use App\Models\Services;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getOrder($id, $user_id)
    {
        if($id){
            $price_service = Services::find($id);
            $bill = new ServiceBill();
            $bill->service_id = $id;
            $bill->user_id = $user_id;
            $bill->order_code = Str::random(15);
            $bill->price = $price_service->price;
            if($bill->save()){
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
}
