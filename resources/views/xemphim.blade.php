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
        @include('layouts.video_min')        
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 5px 10px;">
        @if(!empty($tap[0]->tap_googlelink))
        <a style="float:left;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('google')}}">
            <img class="server-google {{strcmp($_GET['s'], md5('google'))==0?'server-active':''}}" src="{{asset('public/img/themes/google-drive-32x32.png')}}" data-toggle="tooltip" title="Server Google" />
        </a>
        @endif                    
        @if(!empty($tap[0]->tap_youtubelink))
        <a style="float:left;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('youtube')}}">
            <img class="server-youtube {{strcmp($_GET['s'], md5('youtube'))==0?'server-active':''}}" src="{{asset('public/img/themes/youtube-32x32.png')}}" data-toggle="tooltip" title="Server Youtube" />
        </a>
        @endif
        <span class="title-video">
            {{$tap[0]->tap_tapsohienthi}}
        </span>
        <span class="view-times view-{{$phim[0]->phim_id}}-{{$tap[0]->tap_id}}">{{number_format($tap[0]->tap_luotxem)}}&nbsp;lượt xem</span>
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
                <a class="btn btn-warning" style="min-width: 60px;margin-bottom: 5px;"
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