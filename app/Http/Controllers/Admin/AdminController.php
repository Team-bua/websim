<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Models\AdminTransaction;
use App\Models\Logo;
use App\Models\ServiceBill;
use App\Models\User;
use App\Models\UserBill;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function viewindex(Request $request)
    {
        $date =  date('Y-m-d');
        if($request->date == null)
        {
            $first_day = date('Y-m-01', strtotime($date));
            $last_day = date('Y-m-t', strtotime($date));            
        }
        else if(isset(explode(' to ', $request->date)[1]) == false)
        {
            $first_day = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
            $last_day = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));  
        }
        else
        {
            $first_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0])));
            $last_day = date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1])));
        }
        
        $period = CarbonPeriod::create($first_day, $last_day);
        foreach($period as $date)
        {
            $dates[] = $date->format('Y-m-d');
        }
        $user = User::where('role',0)->count();
        $card_bills = ServiceBill::where('status',2)->count();
        $user_bills = UserBill::where('status',1)->count();
        $revenueMonthDone = UserBill::whereRaw('month(user_bills.created_at) BETWEEN "'.date('m', strtotime($first_day)).'" AND "'.date('m', strtotime($last_day)).'"')
            ->select(DB::raw('sum(user_bills.amount) as totalMoney'), DB::raw('DATE(user_bills.created_at) day'))
            ->where('user_bills.status', 1)
            ->groupBy('day')
            ->get()
            ->toArray();
        $revenueMonthPending = UserBill::whereRaw('month(user_bills.created_at) BETWEEN "'.date('m', strtotime($first_day)).'" AND "'.date('m', strtotime($last_day)).'"')
            ->select(DB::raw('sum(user_bills.amount) as totalMoney'), DB::raw('DATE(user_bills.created_at) day'))
            ->where('user_bills.status', 1)
            ->groupBy('day')
            ->get()
            ->toArray();

        $arrRevenueMonthDone = [];
        $arrRevenueMonthPending = [];
        foreach ($dates as $day) {
            $total = 0;
            foreach ($revenueMonthDone as $key => $revenue) {
                
                if ($revenue['day'] == $day) {
                    $total = $revenue['totalMoney'];
                    break;
                }
            }
            
            
            $arrRevenueMonthDone[] = (int) $total;
            $total = 0;
            foreach ($revenueMonthPending as $key => $revenue) {
                if ($revenue['day'] == $day) {
                    $total = $revenue['totalMoney'];
                    break;
                }
            }
            $arrRevenueMonthPending[] = (int) $total;
        }
        $totalRevenueFromToDate = array_sum($arrRevenueMonthDone);
        $viewData = [
            'card_bills'                => $card_bills,
            'user'                      => $user,
            'user_bills'                => $user_bills,
            'first_day'                 => $first_day,
            'last_day'                  => $last_day,
            'dates'                     => $dates,
            'arrRevenueMonthDone'       => $arrRevenueMonthDone,
            'arrRevenueMonthPending'    => json_encode($arrRevenueMonthPending),
            'totalRevenueFromToDate'    => $totalRevenueFromToDate
        ];
        return view('layout_admin.index', $viewData);
    }

    public function documentAPI()
    {
        return view('layout_admin.document');
    }

    public function getBankInfo(Request $request)
    {
        $bank = AdminTransaction::find(1);
        return view('layout_admin.bank_info', compact('bank'));     
    }

    public function updateBankInfo(BankRequest $request)
    {
        $bank = AdminTransaction::find(1);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->bank_image;
        if (isset($img)) {
            if($bank->bank_image){
                unlink(public_path($bank->bank_image));
            }           
            $img_name = 'upload/bank/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/bank/img/' . $date);
            $img->move($destinationPath, $img_name);

            $bank->bank_image = $img_name;
        }
        $bank->bank_name = $request->bank_name;
        $bank->bank_number = $request->bank_number;
        $bank->save();
        return redirect()->back()->with('information', 'Cập nhật thông tin thành công');     
    }

    public function getAllUsers()
    {
        $users = User::where('role',0)
                    ->orderBy('created_at','desc')->get();
        return view('layout_admin.all_user.index', compact('users'));
    }

    public function banned($id)
    {
        $users = User::find($id);
        $users->banned_status = 1;
        $users->save();
        return redirect()->back()->with('information', 'Khóa user thành công');
    }

    public function unBanned($id)
    {
        $users = User::find($id);
        $users->banned_status = 0;
        $users->check_order = 20;
        $users->save();
        return redirect()->back()->with('information', 'Mở khóa user thành công');
    }

    public function updateMoney(Request $request, $id)
    {
        $users = User::find($id);
        $users->amount = $request->money;
        $users->save();
        return redirect()->back()->with('information', 'Cập nhật tiền thành công');     
    }

    public function viewLogo()
    {
        $logo = Logo::first();
        return view('layout_admin.setting_logo', compact('logo'));
    }

    public function updateLogo(Request $request)
    {
        $logo = Logo::first();
        $date = Carbon::now()->format('d-m-Y');
        if(isset($logo)){
            $update = Logo::find($logo->id);
            $img = $request->logo;
            if (isset($img)) {
                if ($logo->logo) {
                    unlink(public_path($logo->logo));
                }
    
                $img_name = 'upload/logo/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
                $destinationPath = public_path('upload/logo/' . $date);
                $img->move($destinationPath, $img_name);
    
                $update->logo = $img_name;
            }   
            $icon = $request->icon;
            if (isset($icon)) {
                if ($logo->icon) {
                    unlink(public_path($logo->icon));
                }
    
                $icon_name = 'upload/logo/' . $date . '/' . Str::random(10) . rand() . '.' . $icon->getClientOriginalExtension();
                $destinationPath = public_path('upload/logo/' . $date);
                $icon->move($destinationPath, $icon_name);
    
                $update->icon = $icon_name;
            }   
            $update->save();
        }else{
           $create = new Logo();
           $img = $request->logo;
            if (isset($img)) {
                $img_name = 'upload/logo/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
                $destinationPath = public_path('upload/logo/' . $date);
                $img->move($destinationPath, $img_name);
    
                $create->logo = $img_name;
            }   
            $icon = $request->icon;
            if (isset($icon)) {  
                $icon_name = 'upload/logo/' . $date . '/' . Str::random(10) . rand() . '.' . $icon->getClientOriginalExtension();
                $destinationPath = public_path('upload/logo/' . $date);
                $icon->move($destinationPath, $icon_name);
    
                $create->icon = $icon_name;
            }   
           $create->save();
        }
        return redirect()->back()->with('information', 'Cập nhật thành công');  
    }
}
