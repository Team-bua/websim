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
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">Dashboard</h6>
            </nav>
            @include('layout_admin.info')
        </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    @if (session('information'))
                    <div class="alert alert-success"><b>{{ session('information') }}</b></div>
                    @endif
                    <div class="card-header pb-0">
                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                            <button class="btn bg-gradient-primary mt-4 w-12" style="float: right;;margin-bottom:5px;margin-left:5px;">
                                <i class="fa fa-plus">&nbsp; Get Proxy </i></button>
                        </a>
                    </div><br>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <!-- <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">STT</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Order ID</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">User</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Service</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Phone Number</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Code</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Created at</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Thao tác</th>
                                    </tr> -->
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">STT</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Logo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Tên</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Giá</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ngày thêm</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php $i = 1 @endphp
                                    @if($orders)
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            {{$i++}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                           <img src="{{ isset($order->avatar) ? asset($order->avatar) : '' }}" alt="" width="150px" height="80" >
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ $order->name }}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ number_format($order->price)}} VNĐ &nbsp;
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ date('d/m/Y', strtotime(str_replace('/', '-', $order->created_at))) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination justify-content-end">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-md-4">
        <!-- Modal -->
        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm dịch vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="#" method="post" enctype="multipart/form-data" id="import-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Tên</label>
                                <input type="text" class="form-control" id="service_name" name="service_name">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Giá</label>
                                <input type="text" class="form-control" id="service_price" name="service_price">
                            </div>
                            <p id="error-data-text" style="color:red;font-size: 13px;margin-left: 10px"></p>
                            <div class="form-group">
                                <label class="form-control-label" for="basic-url">Logo</label> <br>
                                <div class="input-group">
                                    <input id="fImages" type="file" name="service_avatar" class="form-control" style="display: none" onchange="changeImg(this)">
                                    <img id="img" class="img" style="width: 200px; height: 120px;" src="{{ asset(isset($partner->image) ? $partner->image : 'dashboard/assets/img/no_img.jpg') }}">
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success submit">Thêm</button>
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

    $document.on('click', '')

</script>
@endsection
