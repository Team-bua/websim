@extends('layout_admin.master')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    @include('user.avatar')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h4>Lịch sử nạp tiền</h4>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <form action="">
                                <div class="card-header pb-0">
                                    <button type="submit" name="search" class="btn bg-gradient-primary mt-2 " style="float: right;margin-left:5px">
                                        <i class="fa fa-search"></i></button>
                                    <input class="form-control datepicker" name="date" style="width: 25%; float: right; margin-top: 10px" placeholder="Please select date" type="text"
                                    value="{{ date('d/m/Y', strtotime($first_day)) . ' to ' . date('d/m/Y', strtotime($last_day)) }}" >
                                    <input type="text" name="name" class="form-control" placeholder="Mã đơn hàng" style="width: 20%; float: right; margin-top: 10px; margin-right: 5px" aria-describedby="basic-addon1">
                                </div>
                            </form>
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Xem</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Mã đơn hàng</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Khách hàng</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số tiền</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Nội dung</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ngày</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($recharge_bills)
                                    @foreach($recharge_bills as $bill)
                                    <tr>
                                        <td class="align-middle">
                                            <a href="{{ route('show.recharge_bill', $bill->id) }}" target="_blank" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge bg-gradient-info">Hóa đơn</span>
                                            </a>
                                        </td>
                                        <td class="align-middle text-center text-sm"><p class=" text-xs font-weight-bold mb-0">{{ $bill->order_id }}</p></td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    @if($bill->user_bill->avatar_original)
                                                        <img src="{{ asset($bill->user_bill->avatar_original) }}" class="avatar avatar-sm me-3" alt="user1">
                                                    @else
                                                        <img src="{{ asset($bill->user_bill->avatar ? $bill->user_bill->avatar : 'dashboard/assets/img/no_img.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$bill->user_bill->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $bill->user_bill->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">+ {{ number_format($bill->amount) }} VNĐ</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0 ">{{ $bill->description }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ date('d/m/Y', strtotime(str_replace('/', '-', $bill->created_at))) }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if($bill->status == 1)
                                            <span class="badge badge-sm bg-gradient-success">Đã thanh toán</span>
                                            @else
                                            <span class="badge badge-sm bg-gradient-danger">Chưa thanh toán</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
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
<script type="text/javascript">
 const dataTableBasic = new simpleDatatables.DataTable("#datatable-basic", {
      searchable: false,
      fixedHeight: true
    });
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