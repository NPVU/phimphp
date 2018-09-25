<head>    
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('../favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">
    <script type="text/javascript" src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/iziModal.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('template/plugins/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template/adminlte.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>     
    <link href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/bower_components/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />    
    <link href="{{ asset('css/toast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />   
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" />    
    
    <title><?php echo $title ?></title>
</head>