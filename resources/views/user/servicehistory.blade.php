@extends('layout_admin.master')
@section('title')
<title>Hóa đơn dịch vụ</title>
@endsection
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        @include('user.avatar')
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h4>Lịch sử mua hàng</h4>
                        </div>
                        <form action="">
                            <div class="card-header pb-0">
                                <button type="submit" name="search" class="btn bg-gradient-primary mt-2 " style="float: right;margin-left:5px">
                                    <i class="fa fa-search"></i></button>
                                <input class="form-control datepicker" name="date" style="width: 25%; float: right; margin-top: 10px" placeholder="Please select date" type="text"
                                value="{{ date('d/m/Y', strtotime($first_day)) . ' to ' . date('d/m/Y', strtotime($last_day)) }}" >
                                <input type="text" name="name" class="form-control" placeholder="Mã đơn hàng" style="width: 20%; float: right; margin-top: 10px; margin-right: 5px" aria-describedby="basic-addon1">
                                <select class="form-control" name="status" style="width: 20%; float: right; margin-top: 10px; margin-right: 5px">
                                    @if($status == 0)
                                        <option value="0" selected>Tất cả trạng thái </option>
                                        <option value="1">Đang xử lý</option>
                                        <option value="2">Thành công</option>
                                        <option value="3">Thất bại</option>
                                    @elseif($status == 1)
                                        <option value="0">Tất cả trạng thái </option>
                                        <option value="1" selected>Đang xử lý</option>
                                        <option value="2">Thành công</option>
                                        <option value="3">Thất bại</option>
                                    @elseif($status == 2)
                                        <option value="0">Tất cả trạng thái </option>
                                        <option value="1">Đang xử lý</option>
                                        <option value="2" selected>Thành công</option>
                                        <option value="3">Thất bại</option>
                                    @elseif($status == 3)
                                        <option value="0">Tất cả trạng thái </option>
                                        <option value="1">Đang xử lý</option>
                                        <option value="2">Thành công</option>
                                        <option value="3" selected>Thất bại</option>
                                    @endif
                                </select>
                            </div>
                        </form>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table table-flush" id="datatable-basic">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Dịch vụ</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Mã đơn hàng</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số điện thoại</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Nội dung</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Mã otp</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số tiền</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Trạng thái</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ngày</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bills as $bill)
                                        <tr>
                                            {{-- <td class="align-middle">
                                                <a href="{{ route('show.card_bill', $bill->id) }}" target="_blank" class="text-secondary font-weight-bold text-xs">
                                                    <span class="badge bg-gradient-info">Hóa đơn</span>
                                                </a>
                                            </td> --}}
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset( isset($bill) ? $bill->service->avatar : 'dashboard/assets/img/no_img.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$bill->service->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $bill->order_code }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $bill->phone_number }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{!! $bill->content !!}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($bill->code_otp)
                                                    <p class="text-xs font-weight-bold mb-0">{{ $bill->code_otp }}</p>
                                                @elseif($bill->phone_number)
                                                    <a href="javascript:;" onclick="getCodeOtp('{{ $bill->phone_number }}')" class="text-secondary font-weight-bold text-xs" >
                                                        <span class="badge bg-gradient-primary">Lấy mã</span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($bill->price) }} VNĐ</p>
                                            </td>
                                            <td class="align-middle text-center text-sm" id="load{{ $bill->id }}">
                                                @if($bill->status == 1)
                                                    <span class="badge badge-sm bg-gradient-info">Đã nhận sim</span>
                                                @elseif($bill->status == 2)
                                                    <span class="badge badge-sm bg-gradient-success">Thành công</span>
                                                @elseif($bill->status == 3)
                                                    <span class="badge badge-sm bg-gradient-danger">Thất bại</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-warning">Đang xử lý</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ date('H:i d/m/Y', strtotime(str_replace('/', '-', $bill->created_at))) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script src="{{ asset('dashboard/assets/js/plugins/datatables.js') }}" type="text/javascript"></script>
<script>
 const dataTableBasic = new simpleDatatables.DataTable("#datatable-basic", {
      searchable: false,
      fixedHeight: true
    });
    
    function getCodeOtp(phone) {

        var baseUrl = document.location.origin;
        var url = baseUrl+"/api/get-otp/"+phone;
        $.ajax({
            method: 'get',
            url: url,
            success: function(data) {
                console.log(data)
                if(data.status == 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Lấy mã thành công, quý khách vui lòng chờ một chút để nhận hàng!',
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Quý khách đã lấy mã, vui lòng chờ!!',
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }        
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(textStatus);
            }
        })
    }
</script>
<script type="text/javascript">
    if (document.querySelector('.datepicker')) {
      flatpickr('.datepicker', {
        mode: "range",
        dateFormat: 'd/m/Y'
      });
    }
  </script>
@endsection
