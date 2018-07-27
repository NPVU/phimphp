<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Đăng nhập - {{ config('app.name') }}</title>

    <!-- Scripts -->    

    <!-- Fonts -->      
    <link rel="stylesheet" type="text/css" href="{{ asset('public/template/login_version_1/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/login_version_1/vendor/animate/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/login_version_1/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/login_version_1/vendor/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/login_version_1/css/util.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/login_version_1/css/main.css') }}" rel="stylesheet">
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt text-center" data-tilt>
                    <img src="{{ asset('public/template/login_version_1/images/img-01.png') }}" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    <span class="login100-form-title">
                        Đăng nhập
                    </span>
                    @csrf
                        
                    @if ($errors->has('email'))
                            <span class="invalid-feedback" style="display:block;">
                                <strong class="invalid-alert">{{ $errors->first('email') }}</strong>
                            </span>
                    @endif
                    <div class="wrap-input100 validate-input" data-validate="Email có dạng: ex@abc.xyz">
                        <input class="input100" id="email" type="email" value="{{ old('email') }}" autofocus name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>                          
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Mật khẩu là bắt buộc">
                        <input class="input100" id="password" type="password" name="password" placeholder="Mật khẩu">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>                          
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Đăng nhập
                        </button>
                    </div>

                    <div class="text-center p-t-12">                        
                        <a class="txt2" href="{{ route('password.request') }}">
                           Quên mật khẩu
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="{{ url('/') }}" style="margin-right: 15px;">
                            <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
                            Quay về trang chủ                          
                        </a>
                        <a class="txt2" href="{{ route('register') }}">
                            Đăng ký tài khoản
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('public/template/login_version_1/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('public/js/popper.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/template/login_version_1/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/template/login_version_1/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script >
            $('.js-tilt').tilt({
                scale: 1.1
            })
    </script>
    <script src="{{ asset('public/js/main.js') }}"></script>
</body>
</html>
    