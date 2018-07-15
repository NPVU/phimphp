<head>    
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/ico" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('public/template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/template/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/toast.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/iziModal.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('public/template/adminlte.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/dropzone.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('public/js/main.js') }}"></script> 
    <link href="{{ asset('public/template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/toast.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/css/iziModal.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />   
    <link href="{{ asset('public/css/dropzone.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ asset('public/css/main.css') }}" rel="stylesheet" type="text/css" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <title><?php echo $title ?></title>
</head>