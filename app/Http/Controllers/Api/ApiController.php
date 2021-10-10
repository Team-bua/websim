<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBill;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getOrder()
    {
        $order = ServiceBill::where('status', 0)->first();
        if($order){
            $lock = Cache::lock($order->id, 10);
            if ($lock->get()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Have an order'
                ]);
                $lock->release();
            }else{
                return Http::get(url("/api/order"));
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No orders'
            ]);
        }
    }
}
