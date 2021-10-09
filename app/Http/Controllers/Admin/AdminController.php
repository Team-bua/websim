<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Models\AdminTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function viewindex()
    {
        return view('layout_admin.index');
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
}
