<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">
    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/bootstrap-3.3.7/dist/js/bootstrap.min.js') }}"></script>        
    <script type="text/javascript" src="{{ asset('public/js/toast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/iziToast.min.js') }}"></script>
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
                var lx = ' lượt xem';
                $('.view-'+data.message.content.phimid+'-'+data.message.content.tapid).html(data.message.content.tview+' lượt xem');
                $('.view-'+data.message.content.phimid).html(data.message.content.pview+lx);
                $('.modal-view-'+data.message.content.phimid).html(data.message.content.pview);
                $('.view-str-'+data.message.content.phimid).html(data.message.content.pstrview+lx);
                $('.view-slider-'+data.message.content.phimid).html(data.message.content.pview);
                $('.view-week-'+data.message.content.phimid).html(data.message.content.pviewweek+lx);
                $('.view-month-'+data.message.content.phimid).html(data.message.content.pviewmonth+lx);                
            }else if(data.message.event==='pnew'){                       
                VanillaToasts.create({title: data.message.content.tenphim,text: data.message.content.tap+ (data.message.content.tentap!==null?' - '+data.message.content.tentap:'')+' mới được cập nhật',type: 'info',icon: data.message.content.icon,timeout: 10000,callback: function() {window.location.href = data.message.content.link;}});
            }});
        $(document).click(function(event) {var target = $(event.target);if (!target.parents().andSelf().is('.npv-user')&&!target.parents().andSelf().is('.open-popup-user')&&!target.parents().andSelf().is('#user-password')&&!target.parents().andSelf().is('#user-profile')) {$('.npv-user').hide('slow');}});
    </script>
    <script type="application/x-javascript">addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);function hideURLbar(){ window.scrollTo(0,1); }</script>        

    <!-- Styles -->
    <link href="{{ asset('public/bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/bootstrap-3.3.7/dist/css/bootstrap-theme.min.css') }}" rel="stylesheet">    
    <link href="{{ asset('public/css/toast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/iziToast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />        
    <link href="{{ asset('public/css/mainv2.css') }}" rel="stylesheet" type="text/css" />     
</head>
<body>    
    <div class="header">
        <div class="container">            
            <nav class="navbar" style="margin-bottom: unset">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img src="{{asset('public/img/themes/logo.png')}}" width="100"/>
                            
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">                          
                            <li><a href="#">About</a></li>
                            <li><a href="">Contact</a></li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li class="dropdown-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="search-addon">
                                <div class="input-group" style="padding:10px 10px;">
                                    <span class="input-group-addon btn-search" id="btn-search"><span class="glyphicon glyphicon-search"></span></span>
                                    <input type="text" class="form-control input-search" id="input-search" placeholder="Nhập tên phim..." aria-describedby="sizing-addon2">
                                </div>
                                <div class="result-search">
                                    
                                </div>
                            </li>
                            @guest
                            <li><a href="{{route('login')}}">Đăng nhập</a></li>
                            <li><a href="{{route('register')}}">Đăng ký</a></li>
                            @else
                            <li class="open-popup-user" onclick="$('.npv-user').toggle('fast');">
                                <a href="javascript:void(0)" style="margin:5px 5px;width:45px; height:45px; border-radius:100%; text-align:center; background-color:gray;">
                                    <i class="glyphicon glyphicon-user"></i>
                                </a>                        
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    Thoát
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>    
        </div>
    </div>
    <div class="container">
        <div class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="content-left col-xs-12 col-sm-12 col-md-8 col-lg-9">
                @yield('contentLeft')                
            </div>

            <div class="content-right col-xs-12 col-sm-12 col-md-4 col-lg-3">                
                <div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG TUẦN</h4>
                    <ul class="list-anime">
                        @foreach($phimXepHangTuan as $tuan)
                        <li><a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($tuan->phim_ten)))).'/?pid='.$tuan->phim_id.'&t=1&s='.md5('google')}}">
                            <div class="" style="float:left;">
                                <img src="{{$tuan->phim_hinhnen}}" width="50" height="60" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div>{{strlen($tuan->phim_ten)>24?substr($tuan->phim_ten,0,24).'...':$tuan->phim_ten}}</div>
                                <div><span class="glyphicon glyphicon-eye-open"></span> {{ClassCommon::formatLuotXem($tuan->phim_luotxem)}}</div>
                                <div>
                                    <?php 
                                        $star = ClassCommon::getStar($tuan->phim_id); 
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= intval($star)){
                                                echo '<span class="glyphicon glyphicon-star star star-color"></span>';
                                            } else if($i > $star && ($i-1) < $star){
                                                echo '<span class="glyphicon glyphicon-star-half-full star star-half-color"></span>';
                                            } else {
                                                echo '<span class="glyphicon glyphicon-star-o star"></span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </a></li>
                        @endforeach                        
                    </ul>
                </div>

                <div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG THÁNG</h4>
                    <ul class="list-anime">
                        @foreach($phimXepHangThang as $thang)
                        <li><a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($thang->phim_ten)))).'/?pid='.$thang->phim_id.'&t=1&s='.md5('google')}}">
                            <div class="" style="float:left;">
                                <img src="{{$thang->phim_hinhnen}}" width="50" height="60" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div>{{strlen($thang->phim_ten)>24?substr($thang->phim_ten,0,24).'...':$thang->phim_ten}}</div>
                                <div><span class="glyphicon glyphicon-eye-open"></span> {{ClassCommon::formatLuotXem($thang->phim_luotxem)}}</div>
                                <div>
                                    <?php 
                                        $star = ClassCommon::getStar($thang->phim_id); 
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= intval($star)){
                                                echo '<span class="glyphicon glyphicon-star star star-color"></span>';
                                            } else if($i > $star && ($i-1) < $star){
                                                echo '<span class="glyphicon glyphicon-star-half-full star star-half-color"></span>';
                                            } else {
                                                echo '<span class="glyphicon glyphicon-star-o star"></span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </a></li>
                        @endforeach                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-user">
        <input type="hidden" id="current-token" value="{{csrf_token()}}"/>
        @if (Auth::check())    
        @include('layouts.user')    
        @else
        @include('layouts.login')
        @endif
    </div>
    @yield('video')    
    @if (session('backURL'))        
        @include('layouts.backURL')
        <?php Session::forget('backURL'); ?>
    @endif     
</body>
</html>
