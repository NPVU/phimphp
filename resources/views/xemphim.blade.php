@extends('layouts.app')
@section('title')
    {{$phim[0]->phim_ten}} - {{$tap[0]->tap_tapsohienthi}}
@endsection
@section('video')
<section class="npv-viewer">
    <div class="npv-viewer-container">
        <div style="background: url({{$phim[0]->phim_hinhnen}}) no-repeat 0px 0px;background-size: 100%;">            
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"></div>
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                @include('plugin.video')
            </div>            
        </div>  
        <div class="npv-server-box">
            <div class="text-center">
                @if(!empty($tap[0]->googleRedirectLink))
                <a class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('google')}}&token={{$_GET['token']}}">
                    <img class="npv-server-google {{strcmp($_GET['s'], md5('google'))==0?'npv-server-active':''}}" src="{{asset('public/img/themes/google-drive-32x32.png')}}" data-toggle="tooltip" title="Server Google" />
                </a>
                @endif
                @if(!empty($tap[0]->tap_youtubelink))
                <a class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('youtube')}}&token={{$_GET['token']}}">
                    <img class="npv-server-youtube {{strcmp($_GET['s'], md5('youtube'))==0?'npv-server-active':''}}" src="{{asset('public/img/themes/youtube-32x32.png')}}" data-toggle="tooltip" title="Server Youtube" />
                </a>
                @endif
            </div>
        </div>
    </div>            
</section>

@endsection