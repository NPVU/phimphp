<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/template/road_travel/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/SmoothScroll.min.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/move-top.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/easing.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/responsiveslides.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/iziModal.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/main.js') }}"></script>
    <script type="application/x-javascript"> 
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    
    <!-- Fonts -->        
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=cyrillic,cyrillic-ext,latin-ext,vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('public/template/road_travel/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/road_travel/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/road_travel/css/flexslider.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/road_travel/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/road_travel/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/road_travel/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />    
    <link href="{{ asset('public/css/video-player.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/main.css') }}" rel="stylesheet" type="text/css" />   
</head>
<body>                    
    <div class="header">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1>
                    <a href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </h1>
            </div>
            <div class="top-nav-text">
<!--                <ul class="social_agileinfo">
                    <li><a href="#" class="w3_facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" class="w3_twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" class="w3_instagram"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#" class="w3_google"><i class="fa fa-google-plus"></i></a></li>
                </ul>-->
                <ul class="social_agileinfo">
                    @guest
                    <li><a href="{{ route('login') }}" class="w3_facebook"><i class="fa fa-sign-in"></i></a></li>
                    <li><a href="{{ route('register') }}" class="w3_facebook"><i class="fa fa-registered"></i></a></li>
                    @else
                    <li>
                        <a href="#" class="w3_facebook">
                            <i class="fa fa-user"></i>
                        </a>                        
                    </li>
                    <li>
                        <a href="#" class="w3_facebook"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
            <!-- navbar-header -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{url('/')}}#tapmoi" class="hvr-underline-from-center scroll">TẬP MỚI</a></li>
                    <li><a href="{{url('/')}}#top" class="hvr-underline-from-center scroll">TOP</a></li>
                    <li><a href="#" data-toggle="dropdown"><span data-hover="dropdown">THỂ LOẠI</span><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($listTheLoai as $row)
                            <li>
                                <a href="#{{md5($row->theloai_ten)}}" class="scroll">
                                    <span data-hover="{{$row->theloai_ten}}">{{$row->theloai_ten}}</span>
                                </a>
                            </li>
                            @endforeach                            
                        </ul>
                    </li>
                    <li><a href="#" data-toggle="dropdown"><span data-hover="dropdown">NĂM</span><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($listNam as $row)
                            <li class="text-center">
                                <a href="#{{md5($row->nam)}}" class="scroll">
                                    <span data-hover="{{$row->nam}}">{{$row->nam}}</span>
                                </a>
                            </li>
                            @endforeach                            
                        </ul>
                    </li>                                       
                    @if(Session::has('roles'))                                
                        <li><a href="{{ url('quan-ly') }}" class="hvr-underline-from-center scroll">Quản lý</a></li>
                    @endif
                </ul>
            </div>

            <div class="clearfix"> </div>	
        </nav>
    </div>
    
    @yield('slider')
    @yield('hot')
    @yield('video')
    
    <script type="text/javascript">
	$(document).ready(function() {
            $().UItoTop({ easingType: 'easeOutQuart' });								
	});
    </script>
    <div class="npv-page-loading">        
    </div>
</body>
</html>
