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
    <script type="text/javascript" src="{{ asset('public/js/main.min.js') }}"></script>
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
    <link href="{{ asset('public/css/main.min.css') }}" rel="stylesheet" type="text/css" />     
</head>