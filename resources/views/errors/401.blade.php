@extends('layouts.app') 
@section('title')
    401
@endsection 
@section('contentLeft')
<div class="content-left-section" >
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
</div>
@endsection