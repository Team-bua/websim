@extends('layout_admin.master')
@section('title')
<title>Thống kê</title>
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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Dashboard</h6>
            </nav>
        @include('layout_admin.info')        
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <center>
                            <h4><b>Thống kê tổng doanh thu theo tháng đã chọn</b></h4>
                        </center>
                    </div>
                    <div class="card-header pb-0">
                        <center>
                            <h4>Tổng doanh thu: <b> {{ number_format($totalRevenueFromToDate) }} VNĐ </b></h4>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <center>
                            <h4><b>Thống kê doanh thu theo ngày trong tháng</b></h4>
                        </center>
                    </div>
                    <form action="{{ route('admin.search') }}" id="" enctype="multipart/form-data" method="post">
                        @csrf
                    <div class="card-body px-0 pt-0 pb-2">                           
                        <div class="table-responsive p-0">                          
                                <div class="card-header pb-0">
                                    <button type="submit" name="search" class="btn bg-gradient-primary mt-2 " style="float: right;margin-left:5px">
                                        <i class="fa fa-search"></i></button>
                                    <input class="form-control datepicker" name="date" style="width: 25%; float: right; margin-top: 10px" placeholder="Please select date" type="text"
                                    value="{{ date('d/m/Y', strtotime($first_day)) . ' to ' . date('d/m/Y', strtotime($last_day)) }}" >                       
                                </div>
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ngày </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($arrRevenueMonthDone); $i++)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ date('d/m/Y', strtotime($dates[$i])) }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ number_format($arrRevenueMonthDone[$i]) }} VNĐ </span>
                                        </td>
                                    </tr>
                                @endfor                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </form>
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