<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceBill;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getOrder()
    {
        $i = 1;
        $order = ServiceBill::count();
        if($order > 0){
            $i++;
            return response()->json([
                'success' => true,
                'message' => 'There are '.$i. 'order'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No orders'
            ]);
        }
    }
}
