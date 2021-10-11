@extends('layout_admin.master')
@section('title')
<title>Tài liệu API</title>
@endsection
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Page</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tài liệu</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Tài liệu API</h6>
            </nav>
            @include('layout_admin.info')
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Kiểm tra đơn hàng</h6>
                    </div>
                    <div class="card-body p-3">
                        <p>URL : GET=>https://webgamedemo.xyz/api/check-order</p>
                        <p>Kết quả : {"success":true,"message":"Have an order","order_code":"9W58VMGLrIgNAPr","service":"Tiki"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Thêm số điện thoại</h6>
                    </div>
                    <div class="card-body p-3">
                        <p>URL : GET=>https://webgamedemo.xyz/api/add-phone?order_code={order_code}&phone_number={phone_number}</p>
                        <p>order_code => Mã đặt hàng ở phần kiểm tra đơn hàng</p>
                        <p>phone_number => Số điện thoại tùy chọn để thêm vào</p>
                        <p>Kết quả : {"status":"success","message":"Added phone number successfully"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Kiểm tra yêu cầu mã otp</h6>
                    </div>
                    <div class="card-body p-3">
                        <p>URL : GET=>https://webgamedemo.xyz/api/check-code</p>
                        <p>Kết quả : {"success":true,"message":"Have a code order request","order_code":"9W58VMGLrIgNAPr", "phone":"0231234564","service":"Tiki"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Thêm mã otp</h6>
                    </div>
                    <div class="card-body p-3">
                        <p>URL : GET=>https://webgamedemo.xyz/api/add-code?phone_number={phone_number}&code_otp={code_otp}</p>
                        <p>phone_number => Số điện thoại ở phần kiểm tra mã otp</p>
                        <p>code_otp => Mã otp tùy chọn để thêm vào</p>
                        <p>Kết quả : {"status":"success","message":"Added code otp successfully"}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection