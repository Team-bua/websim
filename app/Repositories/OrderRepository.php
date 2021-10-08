<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function store($request)
    {
        if(isset($request)){
            $service = new Services();
            $date = Carbon::now()->format('d-m-Y');
            $img = $request->service_avatar;
            if (isset($img)) {
                $img_name = 'upload/services/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
                $destinationPath = public_path('upload/services/img/' . $date);
                $img->move($destinationPath, $img_name);

                $service->avatar = $img_name;
            }
            $service->name = $request->service_name;
            $service->price = $request->service_price;
            $service->save();
        }
    }

}
