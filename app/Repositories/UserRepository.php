<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
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
        // $date = Carbon::now()->format('d-m-Y');
        // $img = $request->avatar;
        // if (isset($img)) {
        //     if ($user->avatar) {
        //         unlink(public_path($user->avatar));
        //     }

        //     $img_name = 'upload/user/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
        //     $destinationPath = public_path('upload/user/img/' . $date);
        //     $img->move($destinationPath, $img_name);

        //     $user->avatar = $img_name;
        // }

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

}