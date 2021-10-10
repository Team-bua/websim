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
        request()->validate(
            [
                'service_avatar' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
                'service_name' => 'required|max:190',
                'service_price' => 'required|numeric|min:0'
            ],
            [
                'service_avatar.required' => 'Vui lòng chọn logo',
                'service_avatar.mimes' => 'Chỉ gắn thẻ hình ảnh có đuôi .jpg .jpeg .png .gif',
                'service_avatar.max' => 'Giới hạn ảnh 2Mb',
                'service_name.required' => 'Vui lòng nhập tên dịch vụ',
                'service_name.max' => 'Tên dịch vụ không vượt quá 190 ký tự',
                'service_price.required' => 'Vui lòng nhập giá',
                'service_price.numeric' => 'Giá phải là định dạng số',
                'service_price.min' => 'Giá phải lớn hơn hoặc bằng 0',
            ]
        );
        return  $this->repository->store($request);
    }

    public function edit(Request $request)
    {
        return $this->repository->getServiceForView($request);
    }

    public function update(Request $request)
    {
        request()->validate(
            [
                'service_update_avatar' => 'mimes:jpg,jpeg,png,gif|max:2048',
                'service_update_name' => 'required|max:190',
                'service_update_price' => 'required|numeric|min:0'
            ],
            [
                'service_update_avatar.mimes' => 'Chỉ gắn thẻ hình ảnh có đuôi .jpg .jpeg .png .gif',
                'service_update_avatar.max' => 'Giới hạn ảnh 2Mb',
                'service_update_name.required' => 'Vui lòng nhập tên dịch vụ',
                'service_update_name.max' => 'Tên dịch vụ không vượt quá 190 ký tự',
                'service_update_price.required' => 'Vui lòng nhập giá',
                'service_update_price.numeric' => 'Giá phải là định dạng số',
                'service_update_price.min' => 'Giá phải lớn hơn hoặc bằng 0',
            ]
        );
        return $this->repository->update($request);
    }

    public function destroy(Request $request)
    {
        $service = Services::find($request->id);
        if(file_exists($service->avatar)){
            unlink(public_path($service->avatar));
        }
        $service->delete();
            return response()->json([
              'success' => true
          ]);
    }
}
