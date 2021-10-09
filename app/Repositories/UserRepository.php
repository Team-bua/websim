<?php

namespace App\Repositories;

use App\Models\ServiceBill;
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
            
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            
            'd'=>'đ|Đ',
            
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            
            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            
        );
        
        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
        
        return $str;
        
    }

}