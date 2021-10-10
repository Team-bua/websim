@extends('layout_admin.master')
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
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Người dùng</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">Tất cả người dùng</h6>
                </nav>
                @include('layout_admin.info')
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        
                        <div class="card-body px-0 pt-0 pb-2">                           
                            <div class="table-responsive p-0">
                                @if (session('information'))
                                    <div class="alert alert-success">{{ session('information') }}</div>
                                @endif
                                <table class="table table-flush" id="datatable-basic">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Ảnh & Tên & email</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Mật khẩu</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số điện thoại</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Số dư</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Khóa user</th>
                                            <th class="text-secondary"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($users))
                                        @foreach ($users as $user)                                                                              
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @if($user->avatar_original)
                                                        <img src="{{ $user->avatar_original }}" class="avatar avatar-sm me-3" alt="user1">
                                                        @else
                                                        <img src="{{ asset($user->avatar ? $user->avatar : 'dashboard/assets/img/no_img.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if(isset($user->recovery_password))
                                                <label class="text-xs font-weight-bold mb-0 show{{ $user->id }}">*******</label>&nbsp; 
                                                <a class="eye_show show_pass{{ $user->id }}" id="{{ $user->id }}"> <i class="fa fa-eye" style="margin-top: 10px"></i></a>
                                                <a class="eye_hide hide_pass{{ $user->id }}" id="{{ $user->id }}" style="display: none"><i class="fa fa-eye-slash" style="margin-top: 10px"></i></a>
                                                <input type="hidden" id="pass_{{ $user->id }}" value="{{ $user->recovery_password }}"/>
                                                @else
                                                <label class="text-xs font-weight-bold mb-0">Faceboook or Google</label>&nbsp;                                        
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->phone }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($user->amount) }} VNĐ</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($user->banned_status == 0)
                                                    <a href="{{ route('users.banned', $user->id ) }}"><span class="badge badge-sm bg-gradient-danger">Khóa</span></a>
                                                @else
                                                <a href="{{ route('users.unbanned', $user->id ) }}"><span class="badge badge-sm bg-gradient-success">Mở</span></a>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <a href="3" data-bs-toggle="modal" data-bs-target="#exampleModalMessage{{ $user->id }}" class="text-secondary font-weight-bold text-xs">
                                                    <span class="badge bg-gradient-info">Sửa</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <div class="col-md-4">
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalMessage{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật tiền</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">×</span>
                                                    </button>
                                                  </div>
                                                  <form  action="{{ route('users.update.money', $user->id) }}"method="post" enctype="multipart/form-data" id="form_data">
                                                  @csrf
                                                    <div class="modal-body">                     
                                                      <div class="form-group">       
                                                        <label class="form-control-label" for="basic-url">Số tiền: </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-paint-brush"></i></span>
                                                            <input name="money" id="money" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Số tiền. . . . . . . . ." min="0" maxlength="50" value="{{ $user->amount }}" required>
                                                            <span class="input-group-text" id="basic-addon2">VNĐ</span>
                                                        </div>                        
                                                      </div>                                                 
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="submit" class="btn bg-gradient-secondary">Cập nhật</button>
                                                  </div>
                                                </form>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
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
      searchable: true,
      fixedHeight: true
    });

    $(document).ready(function(){       
        $(".eye_show").click(function(){
            var id = $(this).attr('id');
            $(".show"+id).html($('#pass_'+id).val());
            $(".hide_pass"+id).show();
            $(this).hide();
        });
        $(".eye_hide").click(function(){
            var id = $(this).attr('id');
            $(".show"+id).html('*******');
            $(".show_pass"+id).show();
            $(this).hide();
        });
    });
</script>
@endsection