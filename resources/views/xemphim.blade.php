@extends('layouts.app') 
@section('title')
    {{$phim[0]->phim_ten}} - {{$tap[0]->tap_tapsohienthi}}
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">{{$phim[0]->phim_ten}}</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                    
        @include('layouts.video')
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 5px 10px;">
        @if(!empty($tap[0]->tap_googlelink))
        <a style="float:left;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('google')}}">
            <img class="server-google {{strcmp($_GET['s'], md5('google'))==0?'server-active':''}}" src="{{asset('public/img/themes/google-drive-32x32.png')}}" data-toggle="tooltip" title="Server Google" />
        </a>
        @endif                    
        @if(!empty($tap[0]->tap_youtubelink))
        <a style="float:left; margin-left:5px;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('youtube')}}">
            <img class="server-youtube {{strcmp($_GET['s'], md5('youtube'))==0?'server-active':''}}" src="{{asset('public/img/themes/youtube-32x32.png')}}" data-toggle="tooltip" title="Server Youtube" />
        </a>
        @endif
        <span class="title-video">
            {{$tap[0]->tap_tapsohienthi}}
        </span>
        <span class="view-times view-{{$phim[0]->phim_id}}-{{$tap[0]->tap_id}}">{{number_format($tap[0]->tap_luotxem)}}&nbsp;lượt xem</span>
    </div>
</div>

<div class="content-left-section">    
    <div>                                                    
        @if(strcmp($_GET['s'], md5('google'))==0)
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">                                    
            <button class="btn btn-success npv-icon npv-play"><i class="fa fa-play"></i></button>
            <button class="btn btn-success npv-quality" quality="360">HD</button>
        </div>
        <script>
            $('.npv-play').click(function(){
                if(video.paused){
                    video.play();
                }else{
                    video.pause();
                }
            });
            $('.npv-quality').click(function(){
                var currentTime = video.currentTime;
                if($('.npv-quality').attr('quality') === "360"){                
                    video.setAttribute('src', $('#google720p').attr('src'));
                    $('.npv-quality').css('color','white');
                    $('.npv-quality').css('font-weight',700);
                    $('.npv-quality').attr('quality', "720");
                    video.onerror = function(){
                        video.setAttribute('src', $('#google360p').attr('src'));
                        video.currentTime = currentTime;
                        video.play();
                    };
                }else{                
                    video.setAttribute('src', $('#google360p').attr('src'));
                    $('.npv-quality').css('color','gray');
                    $('.npv-quality').css('font-weight',400);
                    $('.npv-quality').attr('quality', "360");
                }
                video.currentTime = currentTime;video.play();
            });
            video.onplaying = function(){
                $('.npv-play > i').addClass('fa-pause');
                $('.npv-play > i').removeClass('fa-play');
                if(v===0){
                    v=1;
                    setTimeout(function(){
                        viewTimes($('meta[name="url"]').attr('content')+'/update/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+getParameterByName('t','')+"&s={{md5('google')}}&token={{csrf_token()}}");
                    }, 10000);
                }
            };
            video.onpause = function(){
                $('.npv-play > i').addClass('fa-play');
                $('.npv-play > i').removeClass('fa-pause');nextVideo();
            };
        </script>
        @endif
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">                                    
            <button class="btn btn-primary" data-izimodal-open="#modal-vote-phim"><i class="fa fa-star"></i></button>
            <button class="btn btn-warning" data-izimodal-open="#modal-error-phim"><i class="fa fa-exclamation-triangle"></i></button>

            <div id="modal-vote-phim" data-izimodal-transitionin="comingInDown">
                <div class="modal-body" style="padding: 20px">        
                    <div class="row vote-body">                
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center danh-gia">
                            @guest
                            <h5>Bạn cần phải đăng nhập để thực hiện đánh giá</h5>
                            <a href="javascript:void(0);" onclick="openLogin()" data-izimodal-close="">Bấm vào đây</a> để đăng nhập
                            @else
                            <div class="text-center">
                                <p>Mỗi tài khoản có thể đánh giá nhiều lần, nhưng chỉ tính lần sau cùng.</p>
                            </div>
                            <div class="rate text-center"></div> 
                            @endguest
                        </div>
                    </div>
                    <div class="row vote-result display-none">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <span class="glyphicon glyphicon-2x glyphicon-ok-sign icon-voted"></span>
                            <div class="content-vote-result"></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">                
                            <button class="btn btn-default" data-izimodal-close="">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>               
                $('#modal-vote-phim').iziModal({
                        title: 'Đánh giá phim',
                        top: 100,
                        overlayClose: true,                
                        width: 600,
                        openFullscreen:false,
                        headerColor: 'rgb(56, 98, 111)',
                        icon: 'fa fa-star-half-o',
                        iconColor: 'white',
                        onOpening: function(){
                            $('.rate').attr('data-rate-value',{{$star}});
                            $('.rate-select-layer').css('width', 20*{{$star}}+'%');
                        }
                    }); 
                $(document).ready(function(){            
                    $(".rate").rate();
                });                       
            </script>

        </div>        
    </div>
</div>

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">TẬP</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                    
        @foreach($listTap as $tap)            
            <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                @if($_GET['t'] != $tap->tap_tapso)
                <a class="click-loading btn btn-primary visit" style="min-width: 60px;margin-bottom: 5px;"
                   href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$tap->tap_tapso}}&s={{md5('google')}}">
                    <span>{{$tap->tap_tapsohienthi}}</span>
                </a>
                @else
                <a class="btn btn-success" style="min-width: 60px;margin-bottom: 5px;"
                   href="#">
                    <span>{{$tap->tap_tapsohienthi}}</span>
                </a>
                @endif
            </div>               
        @endforeach 
    </div>
</div>

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">BÌNH LUẬN</h2>
    </div>
    <div>
    @include('layouts.comment_min')
    </div>
</div>

@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 