<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BillRepository;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * The ProductRepository instance.
     *
     * @var \App\Repositories\front\BillRepository
     * 
     */
    protected $repository;

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\BillRepository $repository
     *
     */
    public function __construct(BillRepository $repository)
    {
        $this->repository = $repository;
    }

    public function serviceBill(Request $request)
    {          
        $date =  date('Y-m-d');
        if($request->date == null)
        {
            $first_day = date('Y-m-d', strtotime($date));
            $last_day = date('Y-m-d', strtotime($date));            
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
        
        $service_bills = $this->repository->serviceBill($request);
        return view('layout_admin.bills.servicebill', compact('service_bills','first_day','last_day'));
    }
    
    public function rechargeBill(Request $request)
    {          
        $date =  date('Y-m-d');
        if($request->date == null)
        {
            $first_day = date('Y-m-d', strtotime($date));
            $last_day = date('Y-m-d', strtotime($date));            
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
        
        $recharge_bills = $this->repository->getRechargeBill($request);
        return view('layout_admin.bills.rechargebill', compact('recharge_bills','first_day','last_day'));
    }

    public function deleteServiceBill(Request $request)
    {
        return $this->repository->deleteServiceBill($request);
    }

    public function deleteRechargeBill(Request $request)
    {
        return $this->repository->deleteRechargeBill($request);
    }
}
