<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset(isset($logo->icon) ? $logo->icon : 'dashboard/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset(isset($logo->icon) ? $logo->icon : 'dashboard/assets/img/apple-icon.png') }}">
  <title>
    Trang đăng nhập
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

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        {{-- <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="{{ route('index') }}">
                    Trang chủ
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="{{ route('card') }}">
                    Mua thẻ
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="#">
                    Hướng dẫn
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="{{ route('about') }}">
                    Về chúng tôi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="{{ route('contact') }}">
                    Liên hệ
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav> --}}
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Chào mừng trở lại!</h3>
                  <p class="mb-0">Nhập email và mật khẩu của bạn để đăng nhập</p>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-3 ms-auto px-1">
                        <a class="btn btn-outline-light w-100"  href="{{ route('social.login', ['facebook']) }}">
                          <svg width="24px" height="32px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink32">
                            <g id="Artboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <g id="facebook-3" transform="translate(3.000000, 3.000000)" fill-rule="nonzero">
                                <circle id="Oval" fill="#3C5A9A" cx="29.5091719" cy="29.4927506" r="29.4882047"></circle>
                                <path d="M39.0974944,9.05587273 L32.5651312,9.05587273 C28.6886088,9.05587273 24.3768224,10.6862851 24.3768224,16.3054653 C24.395747,18.2634019 24.3768224,20.1385313 24.3768224,22.2488655 L19.8922122,22.2488655 L19.8922122,29.3852113 L24.5156022,29.3852113 L24.5156022,49.9295284 L33.0113092,49.9295284 L33.0113092,29.2496356 L38.6187742,29.2496356 L39.1261316,22.2288395 L32.8649196,22.2288395 C32.8649196,22.2288395 32.8789377,19.1056932 32.8649196,18.1987181 C32.8649196,15.9781412 35.1755132,16.1053059 35.3144932,16.1053059 C36.4140178,16.1053059 38.5518876,16.1085101 39.1006986,16.1053059 L39.1006986,9.05587273 L39.0974944,9.05587273 L39.0974944,9.05587273 Z" id="Path" fill="#FFFFFF"></path>
                              </g>
                            </g>
                          </svg>
                        </a>
                      </div>
                      <div class="col-3 me-auto px-1">
                        <a class="btn btn-outline-light w-100" href="{{ route('social.login', ['google']) }}">
                          <svg width="24px" height="32px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Artboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <g id="google-icon" transform="translate(3.000000, 2.000000)" fill-rule="nonzero">
                                <path d="M57.8123233,30.1515267 C57.8123233,27.7263183 57.6155321,25.9565533 57.1896408,24.1212666 L29.4960833,24.1212666 L29.4960833,35.0674653 L45.7515771,35.0674653 C45.4239683,37.7877475 43.6542033,41.8844383 39.7213169,44.6372555 L39.6661883,45.0037254 L48.4223791,51.7870338 L49.0290201,51.8475849 C54.6004021,46.7020943 57.8123233,39.1313952 57.8123233,30.1515267" id="Path" fill="#4285F4"></path>
                                <path d="M29.4960833,58.9921667 C37.4599129,58.9921667 44.1456164,56.3701671 49.0290201,51.8475849 L39.7213169,44.6372555 C37.2305867,46.3742596 33.887622,47.5868638 29.4960833,47.5868638 C21.6960582,47.5868638 15.0758763,42.4415991 12.7159637,35.3297782 L12.3700541,35.3591501 L3.26524241,42.4054492 L3.14617358,42.736447 C7.9965904,52.3717589 17.959737,58.9921667 29.4960833,58.9921667" id="Path" fill="#34A853"></path>
                                <path d="M12.7159637,35.3297782 C12.0932812,33.4944915 11.7329116,31.5279353 11.7329116,29.4960833 C11.7329116,27.4640054 12.0932812,25.4976752 12.6832029,23.6623884 L12.6667095,23.2715173 L3.44779955,16.1120237 L3.14617358,16.2554937 C1.14708246,20.2539019 0,24.7439491 0,29.4960833 C0,34.2482175 1.14708246,38.7380388 3.14617358,42.736447 L12.7159637,35.3297782" id="Path" fill="#FBBC05"></path>
                                <path d="M29.4960833,11.4050769 C35.0347044,11.4050769 38.7707997,13.7975244 40.9011602,15.7968415 L49.2255853,7.66898166 C44.1130815,2.91684746 37.4599129,0 29.4960833,0 C17.959737,0 7.9965904,6.62018183 3.14617358,16.2554937 L12.6832029,23.6623884 C15.0758763,16.5505675 21.6960582,11.4050769 29.4960833,11.4050769" id="Path" fill="#EB4335"></path>
                              </g>
                            </g>
                          </svg>
                        </a>
                      </div>
                      <div class="mt-2 position-relative text-center">
                        <p class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                          Hoặc
                        </p>
                      </div>
                    </div>
                    <form role="form" action="{{route('post.signin')}}" method="post">
                      @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                      @error('email')
                        <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                      @enderror
                    </div>
                    <label>Mật khẩu</label>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                      @error('password')
                        <p style="color:red; font-size: 13px; margin-left: 10px">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Nhớ mật khẩu</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Đăng nhập</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Không có tài khoản?
                    <a href="{{ route('signup') }}" class="text-info text-gradient font-weight-bold">Đăng ký</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('dashboard/assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
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
  function update(){
    Swal.fire({
        title: 'Tính năng đang cập nhật!',
        showConfirmButton: true,
        timer: 2000
    })
  }
    $(document).ready(function () {
      var msg = "{{Session::get('message')}}";
      var exist = "{{Session::has('message')}}";
      if (exist && msg == '2') {
        Swal.fire({
              icon: 'success',
              title: 'Đăng nhập thành công!',
              showConfirmButton: false,
              timer: 2500
          })
        }else if(exist && msg == '3') {
          Swal.fire({
              icon: 'error',
              title: 'Tài khoản không chính xác',
              showConfirmButton: false,
              timer: 2500
          })
        }else if(exist && msg == '4') {
            Swal.fire({
                icon: 'error',
                title: 'Tài khoản của bạn đã bị khóa!',
                showConfirmButton: false,
                timer: 2500
            })
        }
    })
  </script>
</body>

</html>