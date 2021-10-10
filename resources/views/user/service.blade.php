@extends('layout_admin.master')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    @include('user.avatar')
    <div class="container-fluid py-4">
        <div class="row">
            @foreach ($services as $service)
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="margin-top: 20px">
                <a href="#" onclick="getOrderApi('{{ $service->id }}')">
                    <div class="card e">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ $service->name }}</p>
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ number_format($service->price) }} VNĐ/Sim</p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <img src="{{ asset($service->avatar ? $service->avatar : 'dashboard/assets/img/no_img.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
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

    function getOrderApi(id) {

        var baseUrl = document.location.origin;
        var userId = "{{ Auth::user()->id }}";
        var url = baseUrl+"/api/order/"+id+"/user/"+userId;
        console.log(url);
        $.ajax({
                method: 'get',
                url: url,
                success: function(data) {
                    if(data.status == 'banned'){
                        Swal.fire({
                                icon: 'error',
                                title: 'Tài khoản đã bị khóa!',
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href= '/logout';
                                }
                            })
                    }else{
                        if(data.status == 'success'){
                        Swal.fire({
                                icon: 'success',
                                title: 'Order thành công, quý khách vui lòng chờ một chút để nhận hàng!',
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href= baseUrl+'/services-history';
                                }
                            })
                        }else{
                            Swal.fire({
                                    icon: 'error',
                                    title: 'Order thất bại, quý khách vui lòng thử lại!',
                                    showConfirmButton: true,
                                })
                        }
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
