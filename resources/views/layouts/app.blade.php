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
    <script src="{{ asset('public/template/version_1/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/SmoothScroll.min.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/move-top.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/easing.js') }}"></script>
    <script src="{{ asset('public/template/version_1/js/responsiveslides.min.js') }}"></script>    
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
    <link href="{{ asset('public/template/version_1/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/version_1/css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/version_1/css/flexslider.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/version_1/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/version_1/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/template/version_1/css/font-awesome.css') }}" rel="stylesheet">    
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
                    <li class="open-popup-user" onclick="$('.npv-user').toggle('fast');">
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
                    <li><a href="#" class="hvr-underline-from-center scroll" data-izimodal-open="#theloai">THỂ LOẠI</a></li>
                    <li><a href="#" class="hvr-underline-from-center scroll" data-izimodal-open="#nam">NĂM</a></li>                                                          
                    @if(Session::has('roles'))                                
                        <li><a href="{{ url('quan-ly') }}" class="hvr-underline-from-center scroll">QUẢN LÝ</a></li>
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
    <div id="modal-user">
        <input type="hidden" id="current-token" value="{{csrf_token()}}"/>
        @if (Auth::check())    
        @include('layouts.user')    
        @else
        @include('layouts.login')
        @endif
    </div>
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
            
        function changePassword(){var pw1 = $('#pw1').val();var pw2 = $('#pw2').val();var repw2 = $('#re-pw2').val();var valid = true;if(pw1===""){$('.pw1').addClass('has-error');$('.pw1-error').html('Mật khẩu cũ không được bỏ trống');valid = false;}else if(pw1.length < 6){$('.pw1').addClass('has-error');$('.pw1-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.pw1').removeClass('has-error');$('.pw1-error').html('');}if(pw2===""){$('.pw2').addClass('has-error');$('.pw2-error').html('Mật khẩu mới không được bỏ trống');valid = false;}else if(pw2.length < 6){$('.pw2').addClass('has-error');$('.pw2-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.pw2').removeClass('has-error');$('.pw2-error').html('');}if(repw2===""){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Xác nhận mật khẩu không được bỏ trống');valid = false;}else if(repw2.length < 6){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');}if(valid){if(pw2!==repw2){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Xác nhận mật khẩu không trùng khớp');valid = false;}else{$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');}}if(valid){$.ajax({type: "GET",url: "{{url('/quan-ly/tai-khoan/change-password')}}/"+$('#current-token').val()+"/" + pw1 + "/" + pw2,success: function (data) {if (data.status === 1) {$('.rs-pw').css('color','green');$('.rs-pw').removeClass('fa fa-close');$('.rs-pw').addClass('fa fa-check');$('.rs-pw').html(' '+data.msg);$('#pw1').val('');$('#pw2').val('');$('#re-pw2').val('');} else if (data.status === 0) {$('.rs-pw').css('color','red');$('.rs-pw').addClass('fa fa-close');$('.rs-pw').html(' '+data.msg);}}});}}    
        function changeUsername() {
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/tai-khoan/change-display-name')}}/"+$('#current-token').val()+"/" + $('#username').val(),
                success: function (data) {
                    if (data.status === 1) {
                        $('.username').html($('#username').val());$('#username').attr('name-before',$('#username').val());
                        $('#username, .u-s, .u-c').addClass('display-none');$('.username, .u-e').removeClass('display-none');
                    }
                }
            });
        }
        function changeUsername() {
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/tai-khoan/change-display-name')}}/"+$('#current-token').val()+"/" + $('#username').val(),
                success: function (data) {
                    if (data.status === 1) {
                        $('.username, .username-popup').html($('#username').val());$('#username').attr('name-before',$('#username').val());
                        $('#username, .u-s, .u-c').addClass('display-none');$('.username, .u-e').removeClass('display-none');
                    }
                }
            });
        }function changeBirthday() {
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/tai-khoan/change-birthday')}}/"+$('#current-token').val()+"/" + $('#ns').val(),
                success: function (data) {
                    if (data.status === 1) {
                        $('.ns').html(data.msg);$('#ns').attr('ns-before',data.msg);$('#ns').attr('ns-value-before',data.value);
                        $('#ns, .ns-s, .ns-c').addClass('display-none');$('.ns, .ns-e').removeClass('display-none');
                    }
                }
            });
        }function changeGender() {
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/tai-khoan/change-gender')}}/"+$('#current-token').val()+"/" + $('#gender').val(),
                success: function (data) {
                    if (data.status === 1) {
                        $('.gender').html(data.text);$('#gender').attr('gender-before',data.msg);$('#gender').attr('gender-text-before',data.text);
                        $('#gender, .g-s, .g-c').addClass('display-none');$('.gender, .g-e').removeClass('display-none');
                    }
                }
            });
        }function changePhone() {
            if($('#phone').val().length >= 10){
                $('#phone').css('color','unset');
                $.ajax({
                    type: "GET",
                    url: "{{url('/quan-ly/tai-khoan/change-phone')}}/"+$('#current-token').val()+"/" + $('#phone').val(),
                    success: function (data) {
                        if (data.status === 1) {
                            $('.phone').html($('#phone').val());$('#phone').attr('phone-before',$('#phone').val());
                            $('#phone, .p-s, .p-c').addClass('display-none');$('.phone, .p-e').removeClass('display-none');
                        }
                    }
                });
            }else{
                $('#phone').css('color','red');
            }
        }
        function autoUploadFile() {        
            var file_data = $('#avatar-file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('avatar', file_data);            
            $.ajax({
                    url: '{{url("quan-ly/tai-khoan/upload-avatar")}}',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('#current-token').val()
                    },
                    success: function (data) {                    
                        $('#user-avatar').attr('src', '{{url("/")}}/'+data);                    
                    }
            });
        }
        function changeAvatar() {        
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/tai-khoan/change-avatar')}}/"+$('#current-token').val().attr('content')+"/",
                success: function (data) {
                   if (data.status === 1) {
                        $('#user-avatar, .avatar').attr('src', '{{asset("")}}'+data.msg);
                        $('.a-s, .a-c').addClass('display-none');$('#avatar-before').val('{{asset("")}}'+data.msg);
                    }
                }
            });        
        }
    </script>        
</body>
</html>
