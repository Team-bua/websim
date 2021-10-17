@extends('layout_admin.master')
@section('title')
    <title>Thiết lập logo</title>
@endsection
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Logo</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">Thiết lập logo</h6>
                </nav>
                @include('layout_admin.info')
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-6 col-xl-6">
                <div class="card h-80">
                    @if (session('information'))
                        <div class="alert alert-success">{{ session('information') }}</div>
                    @endif
                    <form action="{{ route('update.logo', isset($logo) ? $logo->id : '') }}" method="post" enctype="multipart/form-data">
                    @csrf    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Logo</h6>
                                </div>
                                <div class="form-group">
                                    <input id="fImages" type="file" name="logo" class="form-control" style="display: none"
                                        onchange="changeImg(this)">
                                    <img id="img" class="border-radius-lg shadow-sm" style="width: 120px; height: 120px;"
                                        src="{{ asset(isset($logo->logo) ? $logo->logo : 'dashboard/assets/img/no_img.jpg') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Icon</h6>
                                </div>
                                <div class="form-group">
                                    <input id="thumbnail" type="file" name="icon" class="form-control"
                                        style="display: none" onchange="changeThumbnail(this)">
                                    <img id="thum" class="border-radius-lg shadow-sm" style="width: 120px; height: 120px;"
                                        src="{{ asset(isset($logo->icon) ? $logo->icon :'dashboard/assets/img/no_img.jpg') }}">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary w-12">Cập nhật </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
