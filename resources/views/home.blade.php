@extends('layouts.app') 
@section('title')
XEM PHIM ONLINE MIỄN PHÍ | XEM PHIM KHÔNG QUẢNG CÁO | XEMPHIMZERO.COM 
@endsection 
@section('metaCEO')
<meta property="og:description" content="Xem Phim Anime Vietsub Online, Xem phim anime, Anime Hành động, Anime Download, Anime HD, Anime Vietsub Online" /> 
@endsection 
@section('contentLeft')
<div class="slider">    
        <div class="owl-carousel owl-theme">
            @foreach($listRandom as $random)
            <div class="item">                
                <img src="{{$random->phim_hinhnen}}" />
                <div class="slider-info">
                    <div class="slider-info-inner">
                        <div class="slider-name text-center">{{$random->phim_ten}}</div>
                        <div class="slider-name text-center" style="font-size:1em">Season&nbsp;{{$random->phim_season}}&nbsp;({{$random->phim_nam}})</div>
                        <div class="slider-button text-center">
                            <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($random->phim_ten)))).'/?pid='.$random->phim_id.'&t=1&s='.md5('google')}}">
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

<div class="content-left-section" >
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
</div>

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">MOVIE MỚI</h2>
    </div>
    <div class="listMovieMoi">
        <span class="moviemoi-page-1">
            <?php echo $htmlMovieMoi ?>     
        </span>
        <span class="moviemoi-page-2"></span>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 10px;">
        <i onclick="xtmv()" aria-page="2" class="xtmv npv-icon-xemthem glyphicon glyphicon-2x glyphicon-chevron-down" data-toggle="tooltip" title="Xem thêm"></i>
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 