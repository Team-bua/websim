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
                    <div class="card-header pb-0">
                        @if (session('information'))
                        <div class="alert alert-success"><b>{{ session('information') }}</b></div>
                        @endif
                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                            <button class="btn bg-gradient-primary mt-4 w-12" style="float: right;;margin-bottom:5px;margin-left:5px;">
                                <i class="fa fa-plus">&nbsp; Thêm dịch vụ </i></button>
                        </a>
                    </div><br>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">STT</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Logo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Tên</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Giá</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ngày thêm</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Thao tác</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php $i = 1 @endphp
                                    @if($services)
                                    @foreach($services as $service)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            {{$i++}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <img src="{{ isset($service->avatar) ? asset($service->avatar) : '' }}" alt="" width="150px" height="80">
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ $service->name }}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ number_format($service->price)}} VNĐ &nbsp;
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{ date('d/m/Y', strtotime(str_replace('/', '-', $service->created_at))) }}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <a href="" onclick="editService('{{ $service->id }}');return false;" class="text-secondary font-weight-bold text-xs">
                                                <span class="badge bg-gradient-info">Sửa</span>
                                            </a> ||
                                            <a href="javascript:;" delete_id="#" class="text-secondary font-weight-bold text-xs simpleConfirm">
                                                <span class="badge bg-gradient-danger">Xóa</span>
                                            </a>
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
                    <form method="post" enctype="multipart/form-data" id="import-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Tên</label>
                                <input type="text" class="form-control" id="service_name" name="service_name" required maxlength="190" placeholder="Tên dịch vụ...">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Giá</label>
                                <input type="number" class="form-control" id="service_price" name="service_price" required min="0" maxlength="190" placeholder="Giá...">
                            </div>
                            <p id="error-data-text" style="color:red;font-size: 13px;margin-left: 10px"></p>
                            <div class="form-group">
                                <label class="form-control-label" for="basic-url">Logo</label> <br>
                                <div class="input-group">
                                    <input id="fImages" type="file" name="service_avatar" class="form-control service_add_avatar" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                    <img id="img" class="img" style="width: 200px; height: 120px;" src="{{ asset(isset($partner->image) ? $partner->image : 'dashboard/assets/img/no_img.jpg') }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success submit btn-add">Thêm</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Modal -->
        <div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa dịch vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('service.update') }}" method="post" enctype="multipart/form-data" id="update-service">
                        @csrf
                        <input type="hidden" class="form-control" id="service_update_id" name="service_update_id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Tên</label>
                                <input type="text" class="form-control" id="service_update_name" name="service_update_name" required maxlength="190">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Giá</label>
                                <input type="number" class="form-control" id="service_update_price" name="service_update_price" min="0" maxlength="190" required>
                            </div>
                            <p id="error-data-text" style="color:red;font-size: 13px;margin-left: 10px"></p>
                            <div class="form-group">
                                <label class="form-control-label" for="basic-url">Logo</label> <br>
                                <div class="input-group">
                                    <input id="fImages_2" type="file" name="service_update_avatar" class="form-control service_avatar" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg2(this)">
                                    <img id="img_2" class="img img_avatar" style="width: 200px; height: 120px;" src="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-gradient-success submit btn-update-service">Sửa</button>
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
    $('.import-data').on('click', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('service.store')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
            }
        })
    })

    function changeImg2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    $('#img_2').click(function() {
        $('#fImages_2').click();
    });
    if (document.querySelector('.datepicker')) {
        flatpickr('.datepicker', {
            mode: "range",
            dateFormat: 'd/m/Y'
        });
    }


    function editService(id) {

        $.ajax({
            method: 'get',
            url: "{{ route('service.edit') }}",
            data: {
                id: id
            },
            success: function(data) {
                $('#service_update_id').attr('value', data.data.id);
                $('#service_update_name').attr('value', data.data.name);
                $('#service_update_price').attr('value', data.data.price);
                $('.img_avatar').attr('src', data.data.avatar);
                $('#editServiceModal').modal('show');
                // if (data.success == true) {
                //     that.parent().parent().remove();
                //     Swal.fire(
                //         'Xóa!',
                //         'Xóa thành công.',
                //         'success'
                //     )
                // } else {
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Thẻ vẫn còn tồn tại!',
                //     })
                // }

            },
            error: function(data) {
                console.log(data);
            }
        })
    }



    $(document).on('click', '.update-service', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('service.update')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
            }
        })
    })
</script>
@endsection
