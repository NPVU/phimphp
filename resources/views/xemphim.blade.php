@extends('layouts.app')
@section('title')
    {{$phim[0]->phim_ten}} - {{$tap[0]->tap_tapsohienthi}}
@endsection
@section('video')
<section>
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
    <div class="clearfix"></div>
    
    
</section>
<section style="padding: 5em 0;">
    <div class="container">
        <h3 class="heading">DANH SÁCH TẬP</h3>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            @foreach($listTap as $tap)            
            <div class="col-md-2">
                @if($_GET['t'] != $tap->tap_tapso)
                <a class="click-loading btn btn-primary" style="width: 100px;margin-bottom: 5px;"
                   href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}//?pid={{$_GET['pid']}}&t={{$tap->tap_tapso}}&s={{md5('google')}}&token={{$_GET['token']}}">
                    <span>{{$tap->tap_tapsohienthi}}</span>
                </a>
                @else
                <a class="btn btn-warning" style="width: 100px;margin-bottom: 5px;"
                   href="#">
                    <span>{{$tap->tap_tapsohienthi}}</span>
                </a>
                @endif
            </div>               
            @endforeach                            
        </div>        
    </div>
</section>
<section style="padding: 5em 0;">
    <div class="container">
        <h3 class="heading">THÔNG TIN PHIM</h3>        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <img src="{{$phim[0]->phim_hinhanh}}" width="100%"/>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-left">
                <span>{{$phim[0]->phim_ten}} ({{$phim[0]->phim_tenkhac}})</span>
                <span>{{count($listTap)}}/{{$phim[0]->phim_sotap}}</span>
            </div>
        </div>
    </div>
</section>
@endsection