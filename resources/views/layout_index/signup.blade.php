<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dashboard/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/favicon.png') }}">
  <title>
    Trang đăng ký
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="{{ asset('dashboard/assets/js/plugins/42d5adcbca.js') }}" crossorigin="anonymous"></script>
  <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('dashboard/assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
    <div class="container">
      {{-- <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="../pages/dashboards/default.html">
        Soft UI Dashboard
      </a>
      <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button> --}}
      {{-- <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
        <ul class="navbar-nav navbar-nav-hover mx-auto">
          <li class="nav-item dropdown dropdown-hover mx-2">
            <a href="{{ route('index') }}" class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center ">
              Trang chủ
            </a>
          </li>
          <li class="nav-item dropdown dropdown-hover mx-2">
            <a href="{{ route('card') }}" class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center ">
              Mua thẻ
            </a>
          </li>
          <li class="nav-item dropdown dropdown-hover mx-2">
            <a class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center ">
              Hướng dẫn
            </a>
          </li>
          <li class="nav-item dropdown dropdown-hover mx-2">
            <a href="{{ route('about') }}" class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center ">
              Về chúng tôi
            </a>
          </li>
          <li class="nav-item dropdown dropdown-hover mx-2">
            <a {{ route('contact') }} class="nav-link ps-2 d-flex justify-content-between cursor-pointer align-items-center ">
              Liên hệ   
            </a>
          </li>
        </ul>
      </div> --}}
    </div>
  </nav>
  <!-- End Navbar -->
  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('dashboard/assets/img/curved-images/curved14.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Chào mừng!</h1>
            <p class="text-lead text-white">Bạn đã đến với trang đăng ký.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h4>Đăng ký</h4>
            </div>
            <div class="card-body">
              <form role="form text-left" action="{{route('signup')}}" method="post">
                @csrf
                <div class="mb-3">
                  <input type="text" name="name" class="form-control" placeholder="Tên" aria-label="Name" aria-describedby="email-addon">
                  @error('name')
                    <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                  @error('email')
                    <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" aria-label="Password" aria-describedby="password-addon">
                  @error('phone')
                    <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="password" name="password" class="form-control" placeholder="Mật khẩu" aria-label="Password" aria-describedby="password-addon">
                  @error('password')
                    <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu" aria-label="Password" aria-describedby="password-addon">
                  @error('confirm_password')
                    <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                  @enderror
                </div>
                <div class="form-check form-check-info text-left">
                  <input class="form-check-input" type="checkbox" name="checkbox" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    Tôi đồng ý với các <a href="#" class="text-dark font-weight-bolder">Điều khoản sử dụng</a>
                  </label>
                </div>
                @error('checkbox')
                  <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                @enderror
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Đăng ký</button>
                </div>
                <p class="text-sm mt-3 mb-0">Bạn đã có tài khoản? <a href="{{ route('signin') }}" class="text-dark font-weight-bolder">Đăng nhập</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--   Core JS Files   -->
  <script src="{{ asset('dashboard/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('dashboard/assets/js/plugins/jquery.min.js') }}" type="text/javascript"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  {{-- <script src="{{ asset('dashboard/assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script> --}}
  <script type="text/javascript">
    $(document).ready(function () {
      var msg = "{{Session::get('message')}}";
      var exist = "{{Session::has('message')}}";
      if (exist && msg == '1') {
          Swal.fire({
              icon: 'success',
              title: 'Đăng ký thành công!',
              showConfirmButton: false,
              timer: 2500
          })
        }
    })
  </script>
</body>

</html>