<?php

namespace App\Repositories;

use App\Models\HistoryTransaction;
use App\Models\ServiceBill;
use App\Models\Services;
use App\Models\User;
use App\Models\UserBill;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    public function getProfile($id)
    {
        return User::find($id);
    }

    public function viewService()
    {
        return Services::orderBy('created_at', 'desc')->get();
    }

    public function updateInfo($request, $id)
    {
        $user = User::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->avatar;
        if (isset($img)) {
            if ($user->avatar) {
                unlink(public_path($user->avatar));
            }

            $img_name = 'upload/user/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/user/img/' . $date);
            $img->move($destinationPath, $img_name);

            $user->avatar = $img_name;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();
    }

    public function changePass($request, $id)
    {
        $user = User::find($id);
        $user->password = Hash::make($request->new_password);
        $user->save();
    }

    public function getTransactionHistory($request)
    {
        $date = date('Y-m-d');
        $all_bill = HistoryTransaction::where('user_id', Auth::user()->id)
                    ->when(($request->date == null), function ($query) use ($date){
                        $query->where(function ($q) use ($date){
                            $q->whereDate('created_at', '=', $date);
                        });
                    })
                    ->when(($request->date != null && isset(explode(' to ',$request->date)[1]) == true), function ($query) use ($request){
                        $query->where(function ($q) use ($request) {
                            $q->whereRaw('DATE(history_transactions.created_at) BETWEEN "'.date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))).'" 
                            AND "'.date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))).'"');
                        });
                    })
                    ->when(($request->date != null && isset(explode(' to ',$request->date)[1]) == false), function ($query) use ($request){
                        $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-',$request->date))));
                    })
                    ->when(($request->status == 0 && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                        $query->where(function ($q) use ($request) {
                            $q->whereRaw('DATE(history_transactions.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                                    AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                        });
                    })
                    ->when(($request->status == 1), function ($query) {
                        $query->where(function ($q) {
                            $q->where('status', 0);
                        });
                    })
                    ->when(($request->status == 2), function ($query) {
                        $query->where(function ($q) {
                            $q->where('status', 1);
                        });
                    })
                    ->orderBy('id', 'desc')     
                    ->get();
        return $all_bill;
    }

    public function getServiceBill($request)
    {          
        $date = date('Y-m-d');
        $all_bill = ServiceBill::where('user_id', Auth::user()->id)
                    ->when(($request->date == null), function ($query) use ($date){
                        $query->where(function ($q) use ($date){
                            $q->whereDate('created_at', '=', $date);
                        });
                    })
                    ->when(($request->date != null && isset(explode(' to ',$request->date)[1]) == true), function ($query) use ($request){
                        $query->where(function ($q) use ($request) {
                            $q->whereRaw('DATE(service_bills.created_at) BETWEEN "'.date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))).'" 
                            AND "'.date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))).'"');
                        });
                    })
                    ->when(($request->date != null && isset(explode(' to ',$request->date)[1]) == false), function ($query) use ($request){
                        $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-',$request->date))));
                    })
                    ->when(($request->name != null), function ($query) use ($request){
                        $query->where(function ($q) use ($request){
                            $q->where('order_id', 'LIKE', '%' . $request->name . '%');
                        });
                    })
                    ->when(($request->status == 0 && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                        $query->where(function ($q) use ($request) {
                            $q->whereRaw('DATE(service_bills.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                                    AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                        });
                    })
                    ->when(($request->status == 1), function ($query) {
                        $query->where(function ($q) {
                            $q->where('status', 0);
                        });
                    })
                    ->when(($request->status == 2), function ($query) {
                        $query->where(function ($q) {
                            $q->where('status', 2);
                        });
                    })
                    ->when(($request->status == 3), function ($query) {
                        $query->where(function ($q) {
                            $q->where('status', 3);
                        });
                    })
                    ->orderBy('created_at', 'desc')     
                    ->get();
        return $all_bill;
    }

    public function getRechargeBill($request)
    {          
        $date = date('Y-m-d');
        $all_bill = UserBill::where('user_id', Auth::user()->id)
                    ->when(($request->date == null), function ($query) use ($date){
                        $query->where(function ($q) use ($date){
                            $q->whereDate('created_at', '=', $date);
                        });
                    })
                    ->when(($request->date != null && isset(explode(' to ',$request->date)[1]) == true), function ($query) use ($request){
                        $query->where(function ($q) use ($request) {
                            $q->whereRaw('DATE(user_bills.created_at) BETWEEN "'.date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))).'" 
                            AND "'.date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))).'"');
                        });
                    })
                    ->when(($request->date != null && isset(explode(' to ',$request->date)[1]) == false), function ($query) use ($request){
                        $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-',$request->date))));
                    })
                    ->when(($request->name != null), function ($query) use ($request){
                        $query->where(function ($q) use ($request){
                            $q->where('order_id', 'LIKE', '%' . $request->name . '%');
                        });
                    })     
                    ->orderBy('created_at', 'desc')  
                    ->get();
        return $all_bill;
    }

    public static function utf8convert($str) {
        
        if(!$str) return false;
        
        $utf8 = array(
            
            'a'=>'??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???|??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???',
            
            'd'=>'??|??',
            
            'e'=>'??|??|???|???|???|??|???|???|???|???|???|??|??|???|???|???|??|???|???|???|???|???',
            
            'i'=>'??|??|???|??|???|??|??|???|??|???',
            
            'o'=>'??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???|??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???',
            
            'u'=>'??|??|???|??|???|??|???|???|???|???|???|??|??|???|??|???|??|???|???|???|???|???',
            
            'y'=>'??|???|???|???|???|??|???|???|???|???',
            
        );
        
        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
        
        return $str;
        
    }

}