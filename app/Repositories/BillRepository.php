<?php

namespace App\Repositories;

use App\Models\CardBill;
use App\Models\CardStore;
use App\Models\ServiceBill;
use App\Models\UserBill;

class BillRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function countServiceBillSuccess($request)
    {
        $date = date('Y-m-d');
        $all_bill = ServiceBill::where('status', 2)
            ->when(($request->date == null), function ($query) use ($date) {
                $query->where(function ($q) use ($date) {
                    $q->whereDate('created_at', '=', $date);
                });
            })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('DATE(service_bills.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                            AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                });
            })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == false), function ($query) use ($request) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date))));
            })
            ->when(($request->name != null), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_id', 'LIKE', '%' . $request->name . '%');
                });
            })
            ->count();
        return $all_bill;
    }

    public function countServiceBillFail($request)
    {
        $date = date('Y-m-d');
        $all_bill = ServiceBill::where('status', 3)
            ->when(($request->date == null), function ($query) use ($date) {
                $query->where(function ($q) use ($date) {
                    $q->whereDate('created_at', '=', $date);
                });
            })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('DATE(service_bills.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                            AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                });
            })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == false), function ($query) use ($request) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date))));
            })
            ->when(($request->name != null), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_id', 'LIKE', '%' . $request->name . '%');
                });
            })
            ->count();
        return $all_bill;
    }


    public function serviceBill($request)
    {
        $date = date('Y-m-d');
        $all_bill = ServiceBill::when(($request->date == null), function ($query) use ($date) {
            $query->where(function ($q) use ($date) {
                $q->whereDate('created_at', '=', $date);
            });
        })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('DATE(service_bills.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                            AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                });
            })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == false), function ($query) use ($request) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date))));
            })
            ->when(($request->name != null), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_id', 'LIKE', '%' . $request->name . '%');
                });
            })
            ->when(($request->status == 0 && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('DATE(service_bills.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                            AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                });
            })
            ->when(($request->status == 1), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('status', 0);
                });
            })
            ->when(($request->status == 2), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('status', 2);
                });
            })
            ->when(($request->status == 3), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
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
        $all_bill = UserBill::when(($request->date == null), function ($query) use ($date) {
            $query->where(function ($q) use ($date) {
                $q->whereDate('created_at', '=', $date);
            });
        })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == true), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereRaw('DATE(user_bills.created_at) BETWEEN "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[0]))) . '" 
                            AND "' . date('Y-m-d', strtotime(str_replace('/', '-', explode(' to ', $request->date)[1]))) . '"');
                });
            })
            ->when(($request->date != null && isset(explode(' to ', $request->date)[1]) == false), function ($query) use ($request) {
                $query->whereDate('created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date))));
            })
            ->when(($request->name != null), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('order_id', 'LIKE', '%' . $request->name . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return $all_bill;
    }

    public function deleteServiceBill($request)
    {
        $service_bill = ServiceBill::find($request->id);
        $service_bill->delete();      
        return response()->json([
          'success' => true
      ]);
    }

    public function deleteRechargeBill($request)
    {
        $recharge_bill = UserBill::find($request->id);
        $recharge_bill->delete();      
        return response()->json([
          'success' => true
      ]);
    }
}
