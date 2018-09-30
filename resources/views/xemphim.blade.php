@extends('layouts.app') 
@section('title')
    {{$phim[0]->phim_ten}}&nbsp;- &nbsp;{{$tap[0]->tap_tapsohienthi}}
@endsection 
@section('metaCEO') 
<meta property="og:description" content="Download phim <?php echo $phim[0]->phim_ten ?>, Tải Phim <?php echo $phim[0]->phim_ten?>" /> 
<meta property="og:description" content="Xem Phim <?php echo $phim[0]->phim_ten?>, Xem Phim <?php echo $phim[0]->phim_ten?> Online, Xem Phim <?php echo $phim[0]->phim_ten?> HD, Xem Phim <?php echo $phim[0]->phim_ten?> Miễn Phí, Xem Phim <?php echo $phim[0]->phim_ten?> Không Quảng Cáo" /> 
<meta property="og:image" content="{{$phim[0]->phim_hinhnen}}">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="850">
<script type="text/javascript" src="{{ asset('js/openload-plugin.min.js') }}"></script>
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
            <img class="server-google {{strcmp($_GET['s'], md5('google'))==0?' server-active':''}}" src="{{asset('img/themes/google-drive-32x32.png')}}" data-toggle="tooltip" title="Server Google" />
        </a>
        @endif      
        @if(!empty($tap[0]->tap_youtubelink))
        <a style="float:left; margin-left:5px;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('youtube')}}">
            <img class="server-youtube {{strcmp($_GET['s'], md5('youtube'))==0?' server-active':''}}" src="{{asset('img/themes/youtube-32x32.png')}}" data-toggle="tooltip" title="Server Youtube" />
        </a>
        @endif 
        <!--             
        @if(!empty($tap[0]->tap_openloadlink))
        <a style="float:left; margin-left:5px;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('openload')}}">
            <img class="server-openload {{strcmp($_GET['s'], md5('openload'))==0?' server-active':''}}" src="{{asset('img/themes/openload-32x32.png')}}" data-toggle="tooltip" title="Server Phụ" />
        </a>
        @endif  
        -->       
        <span class="title-video">
            {{$tap[0]->tap_tapsohienthi}}
        </span>
        <span class="view-times view-{{$phim[0]->phim_id}}-{{$tap[0]->tap_id}}">{{number_format($tap[0]->tap_luotxem)}}&nbsp;lượt xem</span>
    </div>
</div>

<div class="content-left-section">    
    <div>                                                    
        @if(strcmp($_GET['s'], md5('google'))==0 || strcmp($_GET['s'], md5('openload'))==0)
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 func-video-align" style="margin-top:5px;">                                    
            <button class="btn btn-success pre-15s" title="15 giây trước">15&nbsp;<span class="glyphicon glyphicon-backward"></span></button>
            <button class="btn btn-success npv-icon npv-play" title="Xem phim"><i class="fa fa-play"></i></button>
            <button class="btn btn-success next-15s" title="15 giây sau"><span class="glyphicon glyphicon-forward"></span>&nbsp;15</button>
            @if(strcmp($_GET['s'], md5('google'))==0)
            <button class="btn btn-success npv-quality" title="Bật HD" quality="360">HD</button>                        
            @endif
        </div>
        <script type="text/javascript">    
            var sotap = {{$listTap[count($listTap)-1]->tap_tapso}};        
            var auto;
            var video = document.getElementById('my-player');
            @if(strcmp($_GET['s'], md5('google'))==0)
            $(document).ready(function(){
                $('#my-player').load();
                $.ajax({
                    url: $('meta[name="url"]').attr('content')+'/autoload/?pid='+getParameterByName('pid','')+'&t='+getParameterByName('t','')+'&token={{Session::token()}}',
                    dataType: 'text',
                    type: 'get',
                    success:function(data){
                        if(data!=null){
                            data = JSON.parse(data);                                   
                            $('#google360p').attr('src', data['360p']);
                            if(data['720p']!=null){
                                $('#my-player').attr('src', data['720p']);                                                   
                                $('.npv-quality').css('color','white');
                                $('.npv-quality').css('font-weight',700);
                                $('.npv-quality').attr('quality', "720");
                                $('.npv-quality').attr('title', "Tắt HD");
                                video.onerror = function(){                                
                                    video.setAttribute('src', $('#google360p').attr('src'));                                
                                    video.play();
                                };
                                $('.icon-quality').removeClass('display-none');
                                $('#google720p').attr('src', data['720p']);
                            }else{
                                $('#my-player').attr('src', data['360p']);
                                $('.npv-quality').css('display','none');                       
                            }
                            if(data['1080p']!=null){
                                $('#google1080p').attr('src', data['1080p']);
                            }
                            $('#my-player').removeAttr('poster');
                            $('#my-player').prop('controls',true);
                        }                    
                    }
                });
            });     
            @endif
            @if(strcmp($_GET['s'], md5('openload'))==0)
                $(window).load(function() {
                    getLinkOpenload('{{$tap[0]->tap_openloadlink}}');
                });                 
            @endif
            var v = 0;        
            video.onloadeddata = function(){
                video.play();
            };        
            function nextVideo(){
                var v = document.getElementById('my-player');
                var auto = $('.btn-auto-next').attr('aria-auto').trim();
                if(v.duration - v.currentTime === 0 && auto==1){
                    if(getParameterByName('t','') < sotap){
                        iziToast.show({
                            timeout: 3000,
                            theme: 'dark',
                            icon: 'fa fa-play',
                            title: 'Chuyển tập trong 5s',                        
                            position: 'center', 
                            progressBarColor: '#27ABDB',
                            buttons: [
                                ['<button>Chuyển ngay</button>', function (instance, toast) {
                                    window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+(parseInt(getParameterByName('t',''))+1)+"&s="+getParameterByName('s','');
                                }, true], 
                                ['<button>Hủy</button>', function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp',
                                        onClosing: function(instance, toast, closedBy){
                                            clearTimeout(auto);
                                        }
                                    }, toast, 'buttonName');
                                }]
                            ],
                            onClosing: function(instance, toast, closedBy){
                                clearTimeout(auto);
                            }
                        });
                        confirmAutoNext(3);                    
                    }
                }
            }
                function confirmAutoNext(i){         
                    if(i <= 0){
                        window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+(parseInt(getParameterByName('t',''))+1)+"&s="+getParameterByName('s','');
                    } else {    
                        $('.iziToast-title').html('Chuyển tập trong '+(i-1)+'s');
                        auto = setTimeout(() => {
                            confirmAutoNext(i-1);
                        }, 1000);
                    }
                }
            $('.npv-play').click(function(){
                if(video.paused){
                    video.play();
                }else{
                    video.pause();
                }
            });
            @if(strcmp($_GET['s'], md5('google'))==0)
            $('.npv-quality').click(function(){
                var currentTime = video.currentTime;
                if($('.npv-quality').attr('quality') === "360"){                
                    video.setAttribute('src', $('#google720p').attr('src'));
                    $('.npv-quality').css('color','white');
                    $('.npv-quality').css('font-weight',700);
                    $('.npv-quality').attr('quality', "720");
                    $('.npv-quality').attr('title', "Tắt HD");
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
                    $('.npv-quality').attr('title', "Bật HD");
                }
                video.currentTime = currentTime;video.play();
            });
            @endif
            $('.pre-15s').click(function(){
                video.currentTime += -15;
            });
            $('.next-15s').click(function(){
                video.currentTime += 15;
            });
            video.onplaying = function(){
                $('.npv-play > i').addClass('fa-pause');
                $('.npv-play > i').removeClass('fa-play');
                $('.npv-play').attr('title','Tạm dừng');
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
                $('.npv-play').attr('title','Xem phim');
            };
        </script>
        @endif
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 func_phim_align" style="margin-top:5px;">
            <!--<button class="btn btn-primary" data-izimodal-open="#modal-info-phim" title="Thông tin phim"><i class="fa fa-info-circle">&nbsp;<span>Thông tin phim</span></i></button>-->
            <button class="btn btn-primary btn-auto-next" aria-auto="@if(Session::has('autoNext')) {{Session::get('autoNext')}} @else 1 @endif" title="@if(Session::has('autoNext')) {{Session::get('autoNext')==1?'Tắt Auto':'Bật Auto'}} @else Tắt Auto @endif">
                <i class="icon-auto-next fa {{Session::get('autoNext')==1?' fa-check-circle':' fa-ban'}}">&nbsp;<span>Tự chuyển tập:<span class="text-auto-next">@if(Session::has('autoNext')) {{Session::get('autoNext')==1?' Bật':' Tắt'}} @else Bật @endif</span></span></i>
            </button>
            <!--<button class="btn btn-primary btn-follow-phim" title="{{$follow_phim == 0?'Theo dõi':'Bỏ theo dõi'}}" follow="{{$follow_phim}}">
                <i class="{{$follow_phim == 0?'fa fa-bell-slash':'fa fa-bell'}}">
                    <span>{{$follow_phim == 0?'Chưa theo dõi':'Đã theo dõi'}}</span>
                    <sup style="" class="follows-tip">{{$follows}}</sup>
                </i>
            </button>
            <button class="btn btn-primary" data-izimodal-open="#modal-vote-phim" title="Đánh giá phim"><i class="fa fa-star">&nbsp;<span>Đánh giá</span></i></button>-->
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
                                    <input type="text" class="form-control" id="input-report-error" placeholder="Vui lòng mô tả lỗi ít nhất 6 ký tự" />
                                </div>
                                <span class="help-block help-block-report-error"></span>
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
                <a class="click-loading btn btn-primary visit btn-tap"
                   href="{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$tap->tap_tapso}}&s={{$_GET['s']}}">
                    <span style="padding: 0px 5px;">{{$tap->tap_tapsohienthi}}</span>
                </a>
                @else
                <a class="btn btn-success btn-tap"
                   href="#">
                    <span style="padding: 0px 5px;">{{$tap->tap_tapsohienthi}}</span>
                </a>
                @endif
            </div>               
        @endforeach 
    </div>
    <script>
    $('a.click-loading').click(function(){
        $("html,body").animate({scrollTop:$("#my-player").offset().top},"slow");
    })
    </script>
</div>
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">THÔNG TIN PHIM</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-radius: 3px;">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                                <img src="{{$phim[0]->phim_hinhanh}}" width="100%" style="max-width:300px"/>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="text-center">
                                    <strong style="color: lightseagreen;font-size: 1.5em;">
                                        {{$phim[0]->phim_ten}}
                                    </strong>                            
                                </div>
                                <div>
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
                                            <span>{{$phim[0]->phim_kieu}}</span>
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
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:-50px;">
                                <ul style="list-style: none;padding-left: 0px;">                            
                                    <li>
                                        <label>Nguồn video:</label>
                                        <span>{{empty($phim[0]->phim_nguon)?'Đang cập nhật':$phim[0]->phim_nguon}}</span>
                                    </li>
                                    <li>
                                        <label>Tóm tắt nội dung:</label>
                                        <span>{{empty($phim[0]->phim_gioithieu)?'đang cập nhật':$phim[0]->phim_gioithieu}}</span>
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
    <!-- @include('layouts.comment_min') -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.1&appId=1228373097312732&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-comments" data-href="{{url('xem-phim')}}/{{$phim[0]->phim_id}}" data-width="100%" data-numposts="10" data-colorscheme="dark" data-order-by="reverse_time"></div>
    </div>
</div>

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">PHIM LIÊN QUAN</h2>
    </div>
    <div>
        @if(count($listSeason) > 0)
            @foreach($listSeason as $season)
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                    <a class="click-loading" href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($season->phim_ten)))).'/?pid='.$season->phim_id.'&t=1&s='.md5('google')}}" data-toggle="modal" data-target="">
                        <div class="box-phim">
                            <div class="box-image">
                                <img src="{{$season->phim_hinhnen}}">
                            </div>
                            <div class="box-overlay-rich"></div>
                            <div class="box-info">
                            <div class="box-title">
                                <div>{{(strlen($season->phim_ten.' (SS'.$season->phim_season.')')>20?substr($season->phim_ten,0,20).'...':$season->phim_ten.' (SS'.$season->phim_season.')')}}</div>
                                <div class="title-vn">{{(strlen($season->phim_tenvn)>28?substr($season->phim_tenvn,0,28).'...':$season->phim_tenvn)}}</div>
                            </div>
                                <div class="box-text">Season&nbsp;{{$season->phim_season}}</div>
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
                                <span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Dạng:</span> {{$season->phim_kieu}}
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
        @else
            <div class="text-center"><i style="color:gray">Không tìm thấy phim liên quan</i></div>
        @endif
    </div>
</div>

<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">PHIM GỢI Ý</h2>
    </div>
    <div>
        @if(count($listGoiY) > 0)
        @foreach($listGoiY as $row)
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                    <a class="click-loading" href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google')}}" data-toggle="modal" data-target="">
                        <div class="box-phim">
                            <div class="box-image">
                                <img src="{{$row->phim_hinhnen}}">
                            </div>
                            <div class="box-overlay-rich"></div>
                            <div class="box-info">
                                <div class="box-title">
                                    <div>{{(strlen($row->phim_ten.' (SS'.$row->phim_season.')')>20?substr($row->phim_ten,0,20).'...':$row->phim_ten.' (SS'.$row->phim_season.')')}}</div>
                                    <div class="title-vn">{{(strlen($row->phim_tenvn)>28?substr($row->phim_tenvn,0,28).'...':$row->phim_tenvn)}}</div>
                                </div>
                                <!--<div class="box-text">{{$row->phim_sotap}}&nbsp;tập</div>-->
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
                                <span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Dạng:</span> {{$row->phim_kieu}}
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