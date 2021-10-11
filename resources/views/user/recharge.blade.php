@extends('layout_admin.master')
@section('title')
<title>Nạp tiền</title>
@endsection
@section('content')
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        @include('user.avatar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card h-80">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Nạp tiền qua ngân hàng</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="form-group text-center">
                                <img id="img" class="border-radius-lg shadow-sm" style="width: 200px; height: 80px;" src="{{ asset($admin->bank_image ? $admin->bank_image : 'dashboard/assets/img/no_img.jpg') }}">
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                    <tbody class="text-center">
                                        <tr style="text-align: left">
                                        <td>Số tài khoản :</td>
                                        <td>{{ $admin->bank_number }}</td>
                                        </tr>
                                        <tr style="text-align: left">
                                        <td>Chủ tài khoản :</td>
                                        <td>{{ strtoupper($admin_str) }}</td>
                                        </tr>
                                        <tr style="text-align: left">
                                        <td>Nội dung chuyển khoản :</td>
                                        <td>{{ Auth::user()->code_name }}</td>
                                        </tr>
                                        <tr>
                                        <td colspan="2"><p style="color: red"> Vui lòng nhập đúng nội dung chuyển khoản</p></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <div>
                                        <p style="color: red; text-align: center"> Lưu ý: Sau khi chuyển khoản thành công vui lòng chờ 5 -10 phút, sau đó bấm f5 số tiền sẽ cộng vào tài khoản</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
