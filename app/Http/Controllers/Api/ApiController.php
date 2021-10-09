<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBill;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getOrder()
    {
        $order = ServiceBill::count();
        if($order > 0){
            return response()->json([
                'success' => true,
                'message' => 'Have an order'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No orders'
            ]);
        }
    }
}
