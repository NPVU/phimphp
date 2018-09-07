@extends('layouts.app') 
@section('title')
    Trang Chủ - {{ config('app.name') }}
@endsection 
@section('contentLeft')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h2 class="content-left-title">TẬP MỚI</h2>
</div>
<div class="listTapMoi">
    <span class="tapmoi-page-1">
        <?php echo $htmlTapMoi ?>     
    </span>
    <span class="tapmoi-page-2"></span>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 10px;">
    <i onclick="xt()" aria-page="2" class="xttm npv-icon-xemthem glyphicon glyphicon-2x glyphicon-chevron-down" data-toggle="tooltip" title="Xem thêm"></i>
</div>
@endsection