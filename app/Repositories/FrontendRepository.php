<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function createUser(Request $request)
    {
        if($request->all()){
            $user = new User();
            $user->name = $request->name;
            $user->code_name = 'CODE'.rand(100000,999999);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = hash::make($request->password);
            $user->recovery_password =$request->password;
            $user->user_token = Str::random(20);
            $user->save();
            return true;
        }else{
            return false;
        }
    }

}