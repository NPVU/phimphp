@extends('layouts.app') @section('title') 401 @endsection @section('contentTop') <div class="page-error" style="height: 500px;"> <div class="error-header error-header-401"> <span class="error-code"><span class="fa fa-ban"></span>&nbsp;401 !</span> <span class="error-name">Không có quyền truy cập</span> </div><div class="error-content"> Bạn đang truy cập vào nguồn tài nguyên không cho phép.<br>Vui lòng quay lại bằng cách <a href="{{isset($backURL)?$backURL:url('/')}}">bấm vào đây</a> . </div></div>@endsection 