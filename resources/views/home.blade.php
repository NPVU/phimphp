@extends('layouts.app') 
@section('title') 
ANIME VIETSUB ONLINE | XEM PHIM KHÔNG QUẢNG CÁO | XEMPHIMZERO.COM 
@endsection 
@section('metaCEO')
<meta name="description" content="Xem Phim, Anime Online Miễn Phí" />
<meta name="keywords" content="Xem Phim, Anime Online Miễn Phí" />
<meta property="og:image" content="{{asset('img/themes/fb-logo.png')}}">
<meta property="og:title" content="ANIME VIETSUB ONLINE | XEMPHIMZERO.COM" />
<meta property="og:description" content="Xem Phim, Anime Online Miễn Phí" /> 
<meta property="description" content="Xem Phim, Anime Online Miễn Phí" /> 
<meta itemprop="name" content="ANIME VIETSUB ONLINE | XEMPHIMZERO.COM" />
<meta itemprop="description" content="Xem Phim, Anime Online Miễn Phí" />
<meta itemprop="image" content="{{asset('img/themes/fb-logo.png')}}" />
@endsection 
@section('contentLeft')
<div class="slider">    
        <div class="owl-carousel owl-theme">
            @foreach($listRandom as $random)
            <div class="item">                
                <img class="lazy" src="{{$random->phim_hinhnen}}" />
                <div class="slider-info">
                    <div class="slider-info-inner">
                        <div class="slider-name text-center">{{$random->phim_ten . ' ('.$random->phim_nam.')'}}</div>                        
                        <div class="slider-button text-center" style="margin-top:15px">
                            <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($random->phim_ten)))).'/'.$random->tap_id.'.html'}}">
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
    @include('layouts.rank') 
@endsection 