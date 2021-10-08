@extends('layout_admin.master')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Ngân hàng</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Cập nhật thông tin</h6>
            </nav>
            @include('layout_admin.info')
        </div>
        </div>
    </nav>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    @if (session('information'))
                        <div class="alert alert-success">{{ session('information') }}</div>
                    @endif
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Thông tin ngân hàng</h6>
                    </div>
                    <form action="{{ route('update.bankinfo', $bank->id) }}" method="post" enctype="multipart/form-data">  
                    @csrf
                        <div class="card-body p-3">
                            <div class="form-group">
                                <label class="form-control-label" for="basic-url">Tên tài khoản</label>
                                <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-paint-brush"></i></span>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $bank->bank_name }}" placeholder="Tên tài khoản">                                   
                                </div>
                                @error('bank_name')
                                    <p style="color:red; font-size: 13px; margin-left: 5px">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="basic-url">Số tài khoản</label>
                                <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                <input type="text" class="form-control" id="bank_number" name="bank_number" value="{{ $bank->bank_number }}" placeholder="Số tài khoản">                       
                                </div>
                                @error('bank_number')
                                    <p style="color:red; font-size: 13px; margin-left: 5px">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="basic-url">Logo ngân hàng</label> <br>
                                <div class="input-group">
                                    <input id="fImages" type="file" name="bank_image" class="form-control" style="display: none"  onchange="changeImg(this)">
                                    <img id="img" class="img" style="width: 200px; height: 120px;" src="{{ asset($bank->bank_image ? $bank->bank_image : 'dashboard/assets/img/no_img.jpg') }}">
                                </div>
                            </div>
                            @error('bank_image')
                                <p style="color:red; font-size: 13px; margin-left: 5px">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary w-12">Cập nhật </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection