<nav style="margin-top: 15px" class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
    <div class="container-fluid py-1">
        <nav aria-label="breadcrumb">
            <h3 class="text-white font-weight-bolder ms-2">Thông tin</h3>
        </nav>
        <div class="collapse navbar-collapse me-md-0 me-sm-4 mt-sm-0 mt-2" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">           
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="{{ route('logout') }}" class="nav-link text-white font-weight-bold px-0">
                            <i class="fa fa-sign-out me-sm-1"></i>
                            <span class="d-sm-inline d-none">Đăng xuất</span>
                        </a>
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                          <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                          </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>    
</nav>
<!-- End Navbar -->
<div class="container-fluid">
    <div class="page-header min-height-300 border-radius-xl mt-4">
        <span class="mask bg-gradient-primary opacity-6"></span>
    </div>
    <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden" style="margin-top: 50px;">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    @if(Auth::user()->avatar_original)
                    <img src="{{ Auth::user()->avatar_original }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    @else
                    <img src="{{ asset(Auth::user()->avatar ? Auth::user()->avatar : 'dashboard/assets/img/no_img.jpg') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                       {{ Auth::user()->name }}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        Số dư : {{ number_format(Auth::user()->amount) }} VNĐ
                    </p>
                </div>
            </div>
    </div>
</div>