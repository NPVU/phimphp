@extends('layouts.app') 
@section('title') 
XemPhimZero.com - Xem Phim Không Quảng Cáo 
@endsection 
@section('metaCEO')
<meta property="og:image" content="{{asset('img/themes/fb-logo.png')}}">
<meta property="og:title" content="XemPhimZero.com - Xem Phim Không Quảng Cáo" />
<meta property="og:description" content="Xem Phim Chất Lượng Cao Không Bị Quảng Cáo Làm Gián Đoạn" /> 
<meta name="keywords" content="XemPhimZero.com - Xem Phim Không Quảng Cáo" />
@endsection 
@section('contentLeft')
<div class="slider">    
        <div class="owl-carousel owl-theme">
            @foreach($listRandom as $random)
            <div class="item">                
                <img class="lazy" src="{{$random->phim_hinhnen}}" />
                <div class="slider-info">
                    <div class="slider-info-inner">
                        <div class="slider-name text-center" style="background-color: #dc0f0fb8;">{{$random->phim_ten}}</div>
                        <div class="slider-name text-center" style="font-size:1em">Season&nbsp;{{$random->phim_season}}&nbsp;({{$random->phim_nam}})</div>
                        <div class="slider-button text-center">
                            <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($random->phim_ten)))).'/?pid='.$random->phim_id.'&t='.$random->tap_id.'&s='.md5('google')}}">
                                <button class="xem-ngay">Xem ngay</button>
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
                    autoplayTimeout:5000,
                    autoplayHoverPause:true,
                    margin:10
                });

                var $button = $('button.xem-ngay');

                $button.on('click', function () {
                    var $this = $(this);
                    if ($this.hasClass('active') || $this.hasClass('success')) {
                        return false;
                    }
                    $this.addClass('active');
                    setTimeout(function () {
                        $this.addClass('loader');
                    }, 125);
                    setTimeout(function () {
                        $this.removeClass('loader active');
                        $this.text('OK');
                        $this.addClass('success animated pulse');
                    }, 3000);
                    setTimeout(function () {
                        $this.text('Xem ngay');
                        $this.removeClass('success animated pulse');
                        $this.blur();
                    }, 2900);
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