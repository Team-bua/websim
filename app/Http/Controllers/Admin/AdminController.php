<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewindex()
    {
        return view('layout_admin.index');
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
