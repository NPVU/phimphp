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
    </div>
</section>

@endsection