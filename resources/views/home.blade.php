@extends('layouts.app')
@section('title')
    Trang Chủ - {{ config('app.name') }}
@endsection
@section('slider')
    @include('layouts.slider')
@endsection
@section('tapmoi')
<section class="special">
    <div class="container">        
        <h3 class="heading">Tập Mới</h3>  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 listTapMoi">
            <span class="tapmoi-page-1">
                <?php echo $htmlTapMoi ?>     
            </span>
            <span class="tapmoi-page-2"></span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <i onclick="xt()" aria-page="2" class="xttm npv-icon-xemthem fa fa-2x fa-angle-double-down" data-toggle="tooltip" title="Xem thêm"></i>
        </div>
    </div>
</section>
@endsection
@section('bangxephang')
    @include('layouts.rank')
@endsection