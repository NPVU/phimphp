<html lang="{{ app()->getLocale() }}">
    <head>
        <link href="{{ asset('public/template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/template/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-red"> 401</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-red"></i> Không có quyền truy cập.</h3>

                    <p>
                        Bạn đang truy cập vào nguồn tài nguyên mà bạn không có đủ quyền.<br>
                        Vui lòng quay lại bằng cách <a href="{{isset($backURL)?$backURL:url('/')}}">bấm vào đây</a> .
                    </p>           
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
    </body>
</html>