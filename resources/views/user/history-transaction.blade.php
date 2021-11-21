@extends('layout_admin.master')
@section('title')
<title>Lịch sử giao dịch</title>
@endsection
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    @include('user.avatar')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h4>Lịch sử giao dịch</h4>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <form action="">
                                <div class="card-header pb-0">
                                    <button type="submit" name="search" class="btn bg-gradient-primary mt-2 " style="float: right;margin-left:5px">
                                        <i class="fa fa-search"></i></button>
                                    <input class="form-control datepicker" name="date" style="width: 25%; float: right; margin-top: 10px" placeholder="Please select date" type="text"
                                    value="{{ date('d/m/Y', strtotime($first_day)) . ' to ' . date('d/m/Y', strtotime($last_day)) }}" >
                                    <select class="form-control" name="status" style="width: 20%; float: right; margin-top: 10px; margin-right: 5px">
                                        @if($status == 0)
                                            <option value="0" selected>Tất cả trạng thái </option>
                                            <option value="1">Mua sim</option>
                                            <option value="2">Hoàn tiền</option>
                                        @elseif($status == 1)
                                            <option value="0">Tất cả trạng thái </option>
                                            <option value="1" selected>Mua sim</option>
                                            <option value="2">Hoàn tiền</option>
                                        @elseif($status == 2)
                                            <option value="0">Tất cả trạng thái </option>
                                            <option value="1">Mua sim</option>
                                            <option value="2" selected>Hoàn tiền</option>
                                        @endif
                                    </select>
                                </div>
                            </form>
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Trạng thái</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số tiền</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số dư</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Nội dung</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ngày</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($transactions)
                                    @foreach($transactions as $trans)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            @if($trans->status == 0)
                                                <span class="badge badge-sm bg-gradient-success">Mua sim</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">Hoàn tiền</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if($trans->status == 0)
                                                <p class=" text-xs font-weight-bold mb-0">- {{ number_format($trans->price) }} VNĐ</p>
                                            @else
                                                <p class=" text-xs font-weight-bold mb-0">+ {{ number_format($trans->price) }} VNĐ</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">{{ $trans->volatility }} VNĐ</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0 ">{{ $trans->content }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ date('H:i d/m/Y', strtotime(str_replace('/', '-', $trans->created_at))) }}</span>
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