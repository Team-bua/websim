<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Repositories\OrderRepository;
use App\Http\Requests\order\OrderRequest;

class OrderController extends Controller
{
    /**
     * The ProductRepository instance.
     *
     * @var \App\Repositories\front\PartnersRepository
     *
     */
    protected $repository;

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Repositories\UserRepository $repository
     *
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $orders = Services::all();
        return view('layout_admin.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $this->repository->store($request);
        return redirect()->back()->with('information', 'Thêm dịch vụ thành công');
        // $orders = Services::all();
        // return view('layout_admin.orders.index', compact(['orders' => $orders]));
    }
}
