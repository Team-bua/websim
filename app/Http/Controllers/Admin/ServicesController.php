<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Repositories\ServicesRepository;
use App\Http\Requests\order\OrderRequest;

class ServicesController extends Controller
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
    public function __construct(ServicesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $services = Services::all();
        return view('layout_admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $this->repository->store($request);
        return redirect()->back()->with('information', 'Thêm dịch vụ thành công');
        // $orders = Services::all();
        // return view('layout_admin.orders.index', compact(['orders' => $orders]));
    }

    public function edit(Request $request)
    {
        return $this->repository->getServiceForView($request);
    }

    public function update(Request $request)
    {
        return $this->repository->update($request);
    }
}
