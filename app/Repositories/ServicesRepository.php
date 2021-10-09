<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ServicesRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function store($request)
    {
        if (isset($request)) {
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
            if ($service->save()) {
                return response()->json([
                    'success' => true,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        }
    }

    public function getServiceForView($request)
    {
        $service = Services::where('id', $request->id)->first();
        return response()->json([
            'success' => true,
            'data' => $service,

        ]);
    }

    public function update($request)
    {
        $service = Services::find($request->service_update_id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->service_update_avatar;
        if (isset($img)) {
            if (isset($service->avatar)) {
                unlink(public_path($service->avatar));
            }
            $img_name = 'upload/services/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/services/img/' . $date);
            $img->move($destinationPath, $img_name);

            $service->avatar = $img_name;
        }

        $service->name = $request->service_update_name;
        $service->price = $request->service_update_price;
        if ($service->save()) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
