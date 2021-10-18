<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\RechargeRequest;
use App\Http\Requests\UserRequest;
use App\Models\AdminTransaction;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getProfile($id)
    {
        $user = $this->repository->getProfile($id);
        return view('user.profile', compact('user'));
    }

    public function viewService()
    {
        $services = $this->repository->viewService();
        return view('user.service', compact('services'));
    }

    public function updateInfo(UserRequest $request, $id)
    {
        $this->repository->updateInfo($request, $id);
        return redirect()->back()->with('information', 'Cập nhật thông tin thành công');
    }

    public function changePass(ChangePassRequest $request, $id)
    {
        $this->repository->changePass($request, $id);
        return redirect()->back()->with('changepass', 'Cập nhật mật khẩu thành công');
    }

    public function recharge()
    {   
        $admin = AdminTransaction::find(1);
        $admin_str = $this->repository->utf8convert($admin->bank_name);
        return view('user.recharge', compact('admin','admin_str'));
    }

    public function getTransactionHistory(Request $request)
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
        
        $transactions = $this->repository->getTransactionHistory($request);
        $status = $request->status;
        return view('user.history-transaction', compact('transactions', 'first_day', 'last_day', 'status'));
    }

    public function getServiceHistory(Request $request)
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
        
        $bills = $this->repository->getServiceBill($request);
        $status = $request->status;
        return view('user.servicehistory', compact('bills', 'first_day', 'last_day', 'status'));
    }


    public function getRechargeHistory(Request $request)
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
        return view('user.rechargehistory', compact('recharge_bills', 'first_day', 'last_day'));
    }
}
