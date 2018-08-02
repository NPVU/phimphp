@extends('layouts.app')
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
                <img class="npv-server-google npv-server-active" src="{{asset('public/img/themes/google-drive-32x32.png')}}" />
                @endif
                @if(!empty($tap[0]->tap_youtubelink))
                <img class="npv-server-youtube" src="{{asset('public/img/themes/youtube-32x32.png')}}" />
                @endif
            </div>
        </div>
    </div>            
</section>

@endsection