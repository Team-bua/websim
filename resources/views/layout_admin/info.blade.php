<ul class="navbar-nav  justify-content-end">
    <li class="nav-item d-flex align-items-center" style="margin-right: 10px">
        <a href="{{ route('profile', Auth::user()->id) }}" class="nav-link text-body font-weight-bold px-0">
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
        </a>
    </li>
    <li class="nav-item d-flex align-items-center">
        <a href="{{ route('logout') }}">
            <img src="{{ asset('dashboard/assets/img/logout.svg') }}"  alt="" data-toggle="tooltip" data-placement="top" title="Đăng xuất">
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