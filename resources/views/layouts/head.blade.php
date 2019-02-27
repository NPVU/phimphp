<head>
    <title>@yield('title')</title>
    @yield('metaCEO')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('img/themes/favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">             
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:site_name" content="XemPhimZero.com" />
    <meta property="fb:app_id" content="277037466252028" />
    <meta property="fb:pages" content="1180507848768085" />
    <meta property="fb:admins" content="1078149449014815"/>
    <meta name="googlebot" content="index,follow" />
    <meta name="robots" content="index,follow" />
    <meta name="google-site-verification" content="7j1ujTZTYuBw7gSgVCJLa7vM_uBlLZ7OpbgTuo8m_QQ" />


    <!-- Scripts -->
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bootstrap-3.3.7/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/move-top.js') }}"></script>        
    <script src="{{ asset('js/easing.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.qtip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.lazy/jquery.lazy.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/iziToast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/iziModal.min.js') }}"></script>    
    <script type="text/javascript" src="{{ asset('js/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/rater.min.js') }}"></script>    
    <script type="text/javascript" src="{{ asset('js/tippy.min.js') }}"></script>    
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
            }else if(data.message.event==='pnew'){                       
                VanillaToasts.create({title: data.message.content.tenphim,text: '<span style="color:#00a5ad">'+data.message.content.tap+ (data.message.content.tentap!==null?' - '+data.message.content.tentap:'')+'</span> vừa được cập nhật',type: 'info',icon: data.message.content.icon,timeout: 15000,callback: function() {window.location.href = data.message.content.link;}});
            }});
        $(document).click(function(event) {var target = $(event.target);if (!target.parents().andSelf().is('.npv-user')&&!target.parents().andSelf().is('.open-popup-user')&&!target.parents().andSelf().is('#user-password')&&!target.parents().andSelf().is('#user-profile')) {$('.npv-user').hide('slow');}});
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
                $().UItoTop({ easingType: 'easeOutQuart' });								
        });          
        $(function() {
            $('.lazy').lazy();
            $('.phim-tip-content').removeClass('display-none');
            refreshTippy();            
        });
        
    </script>
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "url": "http://www.xemphimzero.com/",
        "name": "XemPhimZero.com",
        "alternateName": "XP Zero",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "http://www.xemphimzero.com/tim-kiem/{keyword}/",
            "query-input": "required name=keyword"
        }
    }
    </script>

    <!-- Styles -->
    <link href="{{ asset('bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-3.3.7/dist/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="{{ asset('css/jquery.qtip.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/toast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/iziToast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />        
    <link href="{{ asset('css/main.min.css') }}" rel="stylesheet" type="text/css" />  
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126631519-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-126631519-1');
    </script>       
</head>