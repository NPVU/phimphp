@extends('layouts.app') 
@section('title')
    Trang Chủ
@endsection 
@section('contentLeft')
<div class="slider">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="owl-carousel owl-theme">
            @foreach($phimXepHangTuan as $tuan)
            <div class="item">                
                <img src="{{$tuan->phim_hinhnen}}" width="100%" height="450"/>
                <div class="slider-info">
                    <div class="slider-info-inner">
                        <div class="slider-name text-center">{{$tuan->phim_ten}}</div>
                        <div class="slider-button text-center">
                            <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($tuan->phim_ten)))).'/?pid='.$tuan->phim_id.'&t=1&s='.md5('google')}}">
                                <button class="btn btn-danger">Xem ngay</button>
                            </a>
                        </div>
                    </div>
                </div>                       
            </div>   
            @endforeach     
        </div>

        <script>
            $(document).ready(function(){
                $('.owl-carousel').owlCarousel({
                    items:1,
                    lazyLoad:true,
                    loop:true,
                    autoplay:true,
                    autoplayTimeout:3000,
                    autoplayHoverPause:true,
                    margin:10
                });
            });
        </script>
    </div>
</div>

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