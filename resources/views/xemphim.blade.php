@extends('layouts.app') 
@section('title') 
 <?php echo $phim[0]->phim_ten.' - Tập '.$tap[0]->tap_tapsohienthi?>
@endsection 
@section('metaCEO') 
<meta property="description" content="{{$phim[0]->phim_gioithieu}}" /> 
<meta name="keywords" content="<?php echo $phim[0]->phim_ten?> | <?php echo $phim[0]->phim_tenvn?> | <?php echo $phim[0]->phim_tenkhac?>" />
<meta itemprop="name" content="<?php echo $phim[0]->phim_ten?> <?php echo strlen($phim[0]->phim_tenvn)>0? '| '.$phim[0]->phim_tenvn:''?>" />
<meta itemprop="description" content="{{$phim[0]->phim_gioithieu}}" />
<meta itemprop="image" content="{{$phim[0]->phim_hinhnen}}" />
<meta name="pid" content="{{ $phim[0]->phim_id }}">
<meta name="tid" content="{{ $tap[0]->tap_id }}">

<meta property="og:url" content="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{$tap[0]->tap_id}}.html" />
<meta property="og:title" content="<?php echo $phim[0]->phim_ten?> <?php echo strlen($phim[0]->phim_tenvn)>0? '| '.$phim[0]->phim_tenvn:''?>" />
<meta property="og:description" content="{{$phim[0]->phim_gioithieu}}" /> 
<meta property="og:image" content="{{$phim[0]->phim_hinhnen}}">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="850">
<meta property="og:site_name" content="XemPhimZero" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $phim[0]->phim_ten.' - Tập '.$tap[0]->tap_tapsohienthi?>">
<meta name="twitter:description" content="{{$phim[0]->phim_gioithieu}}">
<meta name="twitter:site" content="@xemphimzero">
<meta name="twitter:image" content="{{$phim[0]->phim_hinhnen}}">
<script type="text/javascript" src="{{ asset('js/openload-plugin.min.js') }}"></script>
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">{{$phim[0]->phim_ten}}</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height:300px;">                                       
        @include('layouts.confirmAge_min') 
        @include('layouts.video_min') 
        @if($cookiePhim['openCookie']) 
            @include('layouts.cookiePhim_min') 
        @endif 
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 5px 10px;">
        @if(!empty($tap[0]->tap_googlelink))
        <a style="float:left;" class="click-loading" onclick="loadServer(this,1, {{$tap[0]->tap_id}},'')">
            <img class="server server-active" src="{{asset('img/themes/server-1.svg')}}" width="24" data-toggle="tooltip" title="Server chính" />
        </a>
        @endif      
        @if(!empty($tap[0]->tap_youtubelink))
        <a style="float:left; margin-left:5px;" class="click-loading" onclick="loadServer(this,3, {{$tap[0]->tap_id}},'{{$tap[0]->tap_youtubelink}}')">
            <img class="server" src="{{asset('img/themes/server-3.png')}}" width="24" data-toggle="tooltip" title="Server phụ" />
        </a>
        @endif               
        <span class="title-video">
            {{'Tập '.$tap[0]->tap_tapsohienthi}} <span class="name-video">{{strlen($tap[0]->tap_ten)>0?': '.$tap[0]->tap_ten:''}}</span>
        </span>        
        <span class="view-times view-{{$phim[0]->phim_id}}-{{$tap[0]->tap_id}}">{{number_format($tap[0]->tap_luotxem)}}&nbsp;lượt xem</span>
        <span class="fb-button">
            <div class="fb-share-button" 
                data-href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{$tap[0]->tap_id}}.html" 
                data-layout="button">
            </div>
        </span>
    </div>
</div>

<div class="content-left-section">    
    <div>   
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 func-video-align" style="margin-top:5px;">
            <button class="btn btn-primary" title="Tập trước" onclick="epBefore()" {{ClassCommon::isFirstEpisode($tap[0]->tap_id)?'disabled':''}}><span class="glyphicon glyphicon-step-backward" style="cursor:unset;"></span></button>
            <button class="btn btn-primary" title="Tập tiếp theo" onclick="epAfter()" {{ClassCommon::isLastEpisode($tap[0]->tap_id)?'disabled':''}}><span class="glyphicon glyphicon-step-forward" style="cursor:unset;"></span></button>  
        </div>         
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 func_phim_align" style="margin-top:5px;">   
              
            <button class="btn btn-primary btn-auto-next" aria-auto="@if(Session::has('autoNext')) {{Session::get('autoNext')}} @else 1 @endif" title="@if(Session::has('autoNext')) {{Session::get('autoNext')==1?'Tắt Auto':'Bật Auto'}} @else Tắt Auto @endif">
                <i class="icon-auto-next fa @if(Session::has('autoNext')) {{Session::get('autoNext')==1?' fa-check-circle':' fa-ban'}} @else fa-check-circle @endif">&nbsp;<span>Tự chuyển tập:<span class="text-auto-next">@if(Session::has('autoNext')) {{Session::get('autoNext')==1?' Bật':' Tắt'}} @else Bật @endif</span></span></i>
            </button>
       
            <!--<button class="btn btn-primary btn-follow-phim" title="{{$follow_phim == 0?'Theo dõi':'Bỏ theo dõi'}}" follow="{{$follow_phim}}">
                <i class="{{$follow_phim == 0?'fa fa-bell-slash':'fa fa-bell'}}">
                    <span>{{$follow_phim == 0?'Chưa theo dõi':'Đã theo dõi'}}</span>
                    <sup style="" class="follows-tip">{{$follows}}</sup>
                </i>
            </button>-->            
            <button class="btn btn-warning" data-izimodal-open="#modal-report-error" title="Báo lỗi"><i class="fa fa-exclamation-triangle">&nbsp;<span>Báo lỗi</span></i></button>
            
            <!--@include('layouts.infophim_min')-->            
            <div id="modal-report-error" data-izimodal-transitionin="comingInDown">
                <div class="modal-body" style="padding: 20px">        
                    <div class="row">                
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Mô tả lỗi</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-exclamation-circle"></span></span>
                                    <input type="text" class="form-control" id="input-report-error" placeholder="Vui lòng mô tả lỗi rõ ràng" />
                                </div>                                
                                <span class="help-block help-block-report-error"></span>
                                <div style="margin-top:10px">Mô tả lỗi càng rõ ràng chúng tôi sẽ sửa lỗi càng nhanh.
                                    <ul>
                                        <li>VD: Tập này không có sub, không có âm thanh.</li>
                                        <li>VD: Tập này bị mất sub, mất âm thanh ở phút thứ 13 (cụ thể móc thời gian).</li>
                                        <li>VD: Tập này bị nhầm lẫn với tập (nào đó) rồi.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                            <button class="btn btn-danger btn-report-error">Gửi</button>
                            <button class="btn btn-default" data-izimodal-close="">Đóng</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <script>                       
                $('#modal-report-error').iziModal({
                        title: 'Báo lỗi',
                        top: 100,
                        overlayClose: true,                
                        width: 600,
                        openFullscreen:false,
                        headerColor: '#263238',
                        icon: 'fa fa-exclamation-triangle',
                        iconColor: 'white',
                        onOpening: function(){
                            $('#input-report-error').val('');
                            $('.help-block-report-error').html('');
                        }
                    }); 
                $(document).ready(function(){            
                    $(".rate").rate();
                    $('.rate').attr('data-rate-value',{{$star}});
                    $('.rate-select-layer').css('width', 20*{{$star}}+'%');
                    $('a[href]').click(function(){
                        var currentTimeSecond = $('video').get(0).currentTime;
                        if(currentTimeSecond == null){
                            currentTimeSecond = 0;
                        }
                        var xhttp = new XMLHttpRequest();
                        xhttp.open("GET", $('meta[name="url"').attr('content') + '/cookie?t=' + {{$tap[0]->tap_id}} + '&time=' + currentTimeSecond, false);
                        xhttp.send();
                        
                    });
                });                     
                var sticky = document.getElementById('video').offsetTop;
                window.onscroll = function() {
                    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {                    
                    } else {
                        if (window.pageYOffset >= sticky+520) {
                            document.getElementById('video').classList.add("sticky-video")
                        } else {
                            document.getElementById('video').classList.remove("sticky-video");
                        }
                    }                    
                };       
                function epBefore(){
                    window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{ClassCommon::getPreviousEpisode($tap[0]->tap_id)}}.html";
                }
                function epAfter(){
                    window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{ClassCommon::getNextEpisode($tap[0]->tap_id)}}.html";
                }             
            </script>          
            <style>
                .sticky-video {
                    position: fixed;
                    bottom: 60px;
                    right:0px;
                    width: 360px;
                    height:200px;
                    z-index:9;
                }
            </style>
        </div>        
    </div>
</div>

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">TẬP - VIETSUB</h2>
    </div>
    <div id="list-ep" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                    
        @foreach($listTapVS as $ep)            
            <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                @if($tap[0]->tap_id != $ep->tap_id)
                <a class="click-loading btn btn-primary visit btn-tap"
                   href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{$ep->tap_id}}.html">
                    <span style="padding: 0px 5px;">{{$ep->tap_tapsohienthi}}</span>
                </a>
                @else
                <a class="btn btn-success btn-tap"
                   href="#">
                    <span style="padding: 0px 5px;">{{$ep->tap_tapsohienthi}}</span>
                </a>
                @endif
            </div>               
        @endforeach 
    </div>

    @if(count($listTapTM) > 0)
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">TẬP - THUYẾT MINH</h2>
    </div>
    <div id="list-ep" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                    
        @foreach($listTapTM as $ep)            
            <div class="col-xs-3 col-sm-2 col-md-1 no-padding">
                @if($tap[0]->tap_id != $ep->tap_id)
                <a class="click-loading btn btn-primary visit btn-tap"
                   href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{$ep->tap_id}}.html">
                    <span style="padding: 0px 5px;">{{$ep->tap_tapsohienthi}}</span>
                </a>
                @else
                <a class="btn btn-success btn-tap"
                   href="#">
                    <span style="padding: 0px 5px;">{{$ep->tap_tapsohienthi}}</span>
                </a>
                @endif
            </div>               
        @endforeach 
    </div>
    @endif    
</div>
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">THÔNG TIN PHIM</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-radius: 3px;">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                                <img src="{{$phim[0]->phim_hinhanh}}" width="100%" style="max-width:300px;max-height: 230px;"/>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="text-center phim-title-header">
                                    <strong>
                                        {{$phim[0]->phim_ten}}
                                    </strong>                            
                                </div>
                                <div class="info-phim">
                                    <ul style="list-style: none;padding-left: 0px;">
                                        @if(!empty($phim[0]->phim_tenvn))
                                        <li>
                                            <label>Tên khác:</label>
                                            <span>{{$phim[0]->phim_tenvn}}</span>
                                        </li>
                                        @endif
                                        <li>
                                            <label>Season:</label>
                                            <span>{{$phim[0]->phim_season}}</span>
                                        </li>
                                        <li>
                                            <label>Thể loại:</label>
                                            <span>
                                                <?php
                                                    for($i = 0; $i < count($listTheLoaiPhim); $i++){
                                                        echo $listTheLoaiPhim[$i]->theloai_ten;
                                                        echo $i+1<count($listTheLoaiPhim)?', ':'.';
                                                    }
                                                ?>                                        
                                            </span>
                                        </li>
                                        <li>
                                            <label>Số tập:</label>
                                            <span>{{$phim[0]->phim_sotap}}</span>
                                        </li>
                                        <li>
                                            <label>Loại phim:</label>
                                            <span>{{$phim[0]->loaiphim_ten}}</span>
                                        </li>
                                        <li>
                                            <label>Quốc gia:</label>
                                            <span>{{$phim[0]->quocgia_ten}}</span>
                                        </li>
                                        <li>
                                            <label>Năm phát hành:</label>
                                            <span>{{$phim[0]->phim_nam}}</span>
                                        </li>                                
                                        <li>
                                            <label>Lượt xem:</label>
                                            <span class="npv-modal-view-times modal-view-{{$phim[0]->phim_id}}">{{number_format($phim[0]->phim_luotxem)}}</span>
                                        </li>
                                        <li>
                                            <label>Đánh giá:</label>                                    
                                            <div class="rate" aria-value="{{Session::get('voted')}}"></div> <span class="vote-times">({{$voteTimes==0?1:$voteTimes}}&nbsp;lượt)</span>
                                        </li>                                                                
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 info-phim" style="margin-top:-20px;">
                                <ul style="list-style: none;padding-left: 0px;">                            
                                    <li>
                                        <label>Nhóm sub:</label>
                                        <span>{{empty($phim[0]->phim_nguon)?'Đang cập nhật':$phim[0]->phim_nguon}}</span>
                                    </li>
                                    <li>
                                        <label>Tóm tắt nội dung:</label>
                                        <span style="white-space: pre-line;">{{empty($phim[0]->phim_gioithieu)?'đang cập nhật':$phim[0]->phim_gioithieu}}</span>
                                    </li>
                                </ul>
                            </div>
    </div>
</div>
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">BÌNH LUẬN</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-radius: 3px;">    
        <div id="fb-root"></div>
        
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=277037466252028&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-comments" data-href="{{url('xem-phim')}}/{{$phim[0]->phim_id}}" data-width="100%" width="100%" data-numposts="10" data-colorscheme="dark" data-order-by="reverse_time"></div>
    </div>
</div>

@if(count($listSeason) > 0) 
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">PHIM LIÊN QUAN</h2>
    </div>
    <div>
        
            @foreach($listSeason as $season)
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    @if($season->phim_id == $phim[0]->phim_id)
                    <a title="{{$season->phim_ten}}&nbsp;{{strlen($season->phim_tenvn)>0?'| '.$season->phim_tenvn:''}}" class="click-loading" href="javascript:void(0)">
                    @else
                    <a title="{{$season->phim_ten}}&nbsp;{{strlen($season->phim_tenvn)>0?'| '.$season->phim_tenvn:''}}" class="click-loading" href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($season->phim_ten)))).'/'.$season->tap_id.'.html'}}" data-toggle="modal" data-target="">
                    @endif
                        <div class="box-phim box-phim-lienquan {{$season->phim_id == $phim[0]->phim_id?' phim-runing':''}}">
                            <div class="box-image">
                                <img class="lazy" data-src="{{$season->phim_hinhnen}}">
                            </div>
                            <div class="box-overlay-rich"></div>
                            <div class="box-info">
                                <div class="box-title">
                                    <div>{{$season->phim_ten}}</div>
                                    <div class="title-vn">{{$season->phim_tenvn}}</div>
                                </div>
                                @if($season->phim_kieu == 1)
                                <div class="box-text {{$season->phim_id == $phim[0]->phim_id?' box-text-runing':''}}">{{$season->phim_id == $phim[0]->phim_id?'Đang xem':'Phần '.$season->phim_season}}</div> 
                                @elseif($season->phim_kieu == 2)
                                <div class="box-text {{$season->phim_id == $phim[0]->phim_id?' box-text-runing':''}}">{{$season->phim_id == $phim[0]->phim_id?'Đang xem':'Movie '.$season->phim_season}}</div> 
                                @elseif($season->phim_kieu == 3)
                                <div class="box-text {{$season->phim_id == $phim[0]->phim_id?' box-text-runing':''}}">{{$season->phim_id == $phim[0]->phim_id?'Đang xem':'Ova '.$season->phim_season}}</div> 
                                @elseif($season->phim_kieu == 4)
                                <div class="box-text {{$season->phim_id == $phim[0]->phim_id?' box-text-runing':''}}">{{$season->phim_id == $phim[0]->phim_id?'Đang xem':'Live Action '.$season->phim_season}}</div> 
                                @endif                                
                            </div>
                        </div>
                        <div class="phim-tip">
                            <div class="phim-tip-content">
                            <div class="phim-tip-ten">{{$season->phim_ten}}</div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-time"></span>&nbsp;<span class="title">Season</span>&nbsp; {{$season->phim_season}}
                                <span style="float:right">
                                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;<span class="title">Năm</span>&nbsp; {{$season->phim_nam}}
                                    <span></span>
                                </span>
                            </div>
                            <div class="phim-tip-noidung">
                                @if(is_null($season->phim_gioithieu))
                                    Đang cập nhật ...
                                @else
                                {{strlen($season->phim_gioithieu)>255?substr($season->phim_gioithieu,0,strrpos(substr($season->phim_gioithieu,0,255),' ')).' ...':$season->phim_gioithieu}}
                                @endif                            
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-tasks"></span>&nbsp;<span class="title">Thể loại:</span> 
                                        {{$season->listTheLoai}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-list"></span>&nbsp;<span class="title">Số tập:</span> {{$season->phim_sotap}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Loại phim:</span> {{$season->loaiphim_ten}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-globe"></span>&nbsp;<span class="title">Quốc gia:</span> {{$season->quocgia_ten}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;<span class="title">Lượt xem:</span> {{$season->phim_luotxem}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-star"></span>&nbsp;<span class="title">Đánh giá:</span> 
                                <?php
                                    $star = ClassCommon::getStar($season->phim_id); 
                                    for($i = 1; $i <= 5; $i++){
                                        if($i <= intval($star)){
                                            echo '<span class="glyphicon fa fa-star star star-color"></span>';
                                        } else if($i > $star && ($i-1) < $star){
                                            echo '<span class="glyphicon fa fa-star-half-alt star star-half-color"></span>';
                                        } else {
                                            echo '<span class="fa fa-star star"></span>';
                                        }
                                    }   
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
    </div>
</div>
@endif 

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">PHIM GỢI Ý</h2>
    </div>
    <div>
        @if(count($listGoiY) > 0)
        @foreach($listGoiY as $row)
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <a title="{{$row->phim_ten}}&nbsp;{{strlen($row->phim_tenvn)>0?'| '.$row->phim_tenvn:''}}" class="click-loading" href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/'.$row->tap_id.'.html'}}" data-toggle="modal" data-target="">
                        <div class="box-phim">
                            <div class="box-image">
                                <img class="lazy" data-src="{{$row->phim_hinhnen}}">
                            </div>
                            <div class="box-overlay-rich"></div>
                            <div class="box-info">
                                <div class="box-title">
                                    <div>{{$row->phim_ten}}</div>
                                    <div class="title-vn">{{$row->phim_tenvn}}</div>
                                </div>
                                <div class="box-text">{{$row->tap[0]->tap_tapso.'/'.$row->phim_sotap}}</div>
                            </div>
                        </div>
                        <div class="phim-tip">
                            <div class="phim-tip-content">
                            <div class="phim-tip-ten">{{$row->phim_ten}}</div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-time"></span>&nbsp;<span class="title">Season</span>&nbsp; {{$row->phim_season}}
                                <span style="float:right">
                                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;<span class="title">Năm</span>&nbsp; {{$row->phim_nam}}
                                    <span></span>
                                </span>
                            </div>
                            <div class="phim-tip-noidung">
                                @if(is_null($row->phim_gioithieu))
                                    Đang cập nhật ...
                                @else
                                {{strlen($row->phim_gioithieu)>255?substr($row->phim_gioithieu,0,strrpos(substr($row->phim_gioithieu,0,255),' ')).' ...':$row->phim_gioithieu}}
                                @endif                            
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-tasks"></span>&nbsp;<span class="title">Thể loại:</span> 
                                        {{$row->listTheLoai}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-list"></span>&nbsp;<span class="title">Số tập:</span> {{$row->phim_sotap}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Loại phim:</span> {{$row->loaiphim_ten}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-globe"></span>&nbsp;<span class="title">Quốc gia:</span> {{$row->quocgia_ten}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;<span class="title">Lượt xem:</span> {{$row->phim_luotxem}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-star"></span>&nbsp;<span class="title">Đánh giá:</span> 
                                <?php
                                    $star = ClassCommon::getStar($row->phim_id); 
                                    for($i = 1; $i <= 5; $i++){
                                        if($i <= intval($star)){
                                            echo '<span class="glyphicon fa fa-star star star-color"></span>';
                                        } else if($i > $star && ($i-1) < $star){
                                            echo '<span class="glyphicon fa fa-star-half-alt star star-half-color"></span>';
                                        } else {
                                            echo '<span class="fa fa-star star"></span>';
                                        }
                                    }   
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        @else
            <div class="text-center"><i style="color:gray">Không tìm thấy phim liên quan</i></div>
        @endif
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection