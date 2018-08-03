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
<section style="padding: 3em 0;">
    <div class="container">
        <h3 class="heading">
             DANH SÁCH
        </h3>
        @if(count($listTap) > 36)
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;">            
            <div class="col-xs-8 col-sm-4 col-md-3" style="float:right;">
                <div class="input-group totap">
                    <input type="number" id="toTap" value="" placeholder="Tập" class="form-control" />
                    <span class="input-group-addon" style="cursor: pointer" id="iconToTap"><i class="fa fa-youtube-play"></i></span>                                
                </div>
                <a id="hrefToTap" class="click-loading display-none" href="" ></a>
            </div>            
            <script>
                $('#iconToTap').click(function(){
                   var t = $('#toTap').val();
                   if(t.length === 0){                       
                       $('#toTap').attr('placeholder', 'Vui lòng nhập số tập');
                       $('.totap').addClass('has-error');
                   } else {                
                       t = t<0?(t*-1):t;
                       $('#toTap').val(t);
                       $('.totap').removeClass('has-error');                          
                       $('#hrefToTap').click();
                       window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}/?pid={{$_GET['pid']}}&t="+t+"&s={{md5('google')}}&token={{$_GET['token']}}";
                   }                   
                });
            </script>
        </div>        
        @endif
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            @foreach($listTap as $tap)            
            <div class="col-xs-6 col-sm-3 col-md-2">
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
        <h3 class="heading">THÔNG TIN</h3>        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <img src="{{$phim[0]->phim_hinhanh}}" width="100%"/>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-left">
                <table class="table-light">
                    <tbody>
                        <tr>
                            <td style="width:25%">Tên phim</td>
                            <td style="width:75%"><b>{{$phim[0]->phim_ten}}</b></td>
                        </tr>
                        <tr>
                            <td style="width:25%">Số tập</td>
                            <td style="width:75%">{{count($listTap)}}/{{$phim[0]->phim_sotap}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection