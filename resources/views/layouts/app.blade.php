<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('public/template/road_travel/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/SmoothScroll.min.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/move-top.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/easing.js') }}"></script>
    <script src="{{ asset('public/template/road_travel/js/responsiveslides.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/toast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/iziModal.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/rater.min.js') }}"></script>   
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    <script>        
        var pusher = new Pusher('836033107e962f12f88f', {
          cluster: 'ap1',
          encrypted: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('App\\Events\\PusherEvent', function(data) {
            if(data.message.event==='view'){
                $('.view-'+data.message.content.phimid+'-'+data.message.content.tapid).html(data.message.content.tview+' lượt xem');
                $('.view-'+data.message.content.phimid).html(data.message.content.pview+' lượt xem');
                $('.view-str-'+data.message.content.phimid).html(data.message.content.pstrview+ ' lượt xem');
                $('.view-slider-'+data.message.content.phimid).html(data.message.content.pview);
                $('.view-week-'+data.message.content.phimid).html(data.message.content.pviewweek+ ' lượt xem');
                $('.view-month-'+data.message.content.phimid).html(data.message.content.pviewmonth+ ' lượt xem');                
            }else if(data.message.event==='pnew'){
                
            }
        });
    </script>
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
    <link href="{{ asset('public/css/toast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />    
    <link href="{{ asset('public/css/video-player.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/main.css') }}" rel="stylesheet" type="text/css" />    
</head>
<body> 
    <div class="npv-page-loading">        
    </div>
    <div class="progress sm npv-progress">
        <div class="progress-bar progress-bar-aqua npv-progress-bar" style="width: 10%"></div>
    </div>
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
                    <a href="{{ url('/') }}" class="click-loading">
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
                    <li onclick="$('.npv-user').toggle('fast');">
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
                    <li><a href="#" class="hvr-underline-from-center scroll" data-izimodal-open="#tapmoi">TẬP MỚI</a></li>
                    <li><a href="{{url('/')}}/#top" class="hvr-underline-from-center scroll">TOP</a></li>
                    <li><a href="#" class="hvr-underline-from-center scroll" data-izimodal-open="#theloai">THỂ LOẠI</a></li>
                    <li><a href="#" class="hvr-underline-from-center scroll" data-izimodal-open="#nam">NĂM</a></li>                                                          
                    @if(Session::has('roles'))                                
                        <li><a href="{{ url('quan-ly') }}" class="hvr-underline-from-center scroll">Quản lý</a></li>
                    @endif
                </ul>
            </div>

            <div class="clearfix"> </div>	
        </nav>
    </div>
    
    @yield('slider')    
    @yield('tapmoi')
    @yield('bangxephang')
    @include('layouts.tapmoi')
    @include('layouts.theloai')
    @include('layouts.nam')
    @if (Auth::check())
    @include('layouts.user')
    @endif
    @yield('video')
    @include('layouts.footer')
    @if (session('backURL'))        
        @include('layouts.backURL')
        <?php Session::forget('backURL'); ?>
    @endif
    <script type="text/javascript">
	$(document).ready(function() {
            $().UItoTop({ easingType: 'easeOutQuart' });								
	});        
    </script>        
</body>
</html>
