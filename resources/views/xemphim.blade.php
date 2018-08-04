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
        <div>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1"></div>
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11" style="padding-bottom: 5px;">
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    @if(!empty($tap[0]->googleRedirectLink))
                    <a style="float:left;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('google')}}&token={{$_GET['token']}}">
                        <img class="npv-server-google {{strcmp($_GET['s'], md5('google'))==0?'npv-server-active':''}}" src="{{asset('public/img/themes/google-drive-32x32.png')}}" data-toggle="tooltip" title="Server Google" />
                    </a>
                    @endif                    
                    @if(!empty($tap[0]->tap_youtubelink))
                    <a style="float:left;" class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('youtube')}}&token={{$_GET['token']}}">
                        <img class="npv-server-youtube {{strcmp($_GET['s'], md5('youtube'))==0?'npv-server-active':''}}" src="{{asset('public/img/themes/youtube-32x32.png')}}" data-toggle="tooltip" title="Server Youtube" />
                    </a>
                    @endif
                    <span class="npv-title-video">
                        {{$phim[0]->phim_ten}} - {{$tap[0]->tap_tapsohienthi}}
                    </span>
                    <span class="npv-view-times">{{$tap[0]->tap_luotxem}} lượt xem</span>
                </div>
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
        @if(count($listTap) > 10)
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px;">            
            <div class="col-xs-12 col-sm-4 col-md-3" style="float:right;">
                <div class="input-group totap">
                    <input type="number" id="toTap" value="" placeholder="Nhập tập muốn xem" class="form-control" />
                    <span class="input-group-addon" style="cursor: pointer" id="iconToTap"><i class="fa fa-youtube-play"></i></span>                                
                </div>
                <a id="hrefToTap" class="click-loading display-none" href="" ></a>
            </div>            
            <script>
                $('#iconToTap').click(function(){
                   var t = $('#toTap').val();
                   if(t.length === 0){                       
                       showToast('error', 'Vui lòng nhập số tập', '', true);
                       $('.totap').addClass('has-error');
                   } else {
                       t = t<0?(t*-1):t;
                       if(t > {{count($listTap)}}){
                            showToast('error', 'Số tập không hợp lệ', '', true);
                            $('.totap').addClass('has-error');
                       } else {
                            $('#toTap').val(t);
                            $('.totap').removeClass('has-error');                          
                            $('#hrefToTap').click();
                            window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}/?pid={{$_GET['pid']}}&t="+t+"&s={{md5('google')}}&token={{$_GET['token']}}";                   
                       }                       
                    }                   
                });
            </script>
        </div>        
        @endif
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            @foreach($listTap as $tap)            
            <div class="col-xs-4 col-sm-2 col-md-1">
                @if($_GET['t'] != $tap->tap_tapso)
                <a class="click-loading btn btn-primary" style="min-width: 80px;margin-bottom: 5px;"
                   href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten)))}}//?pid={{$_GET['pid']}}&t={{$tap->tap_tapso}}&s={{md5('google')}}&token={{$_GET['token']}}">
                    <span>{{$tap->tap_tapsohienthi}}</span>
                </a>
                @else
                <a class="btn btn-warning" style="min-width: 80px;margin-bottom: 5px;"
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
        <h3 class="heading">BÌNH LUẬN</h3>        
        <div id="binhluan" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
        </div>
    </div>
</section>
<section class="npv-icon-right">      
    <ul>
        <li>
            <a data-toggle="tooltip" title="Thông tin" data-izimodal-open="#modal-info-phim">
                <div>
                    <span class="fa fa fa-film" style="color: red; line-height: 2.8;"></span>
                </div>
            </a>            
        </li>
        <li>
            <a href="#binhluan" data-toggle="tooltip" title="Bình luận">
                <div>
                    <span class="fa fa fa-comment" style="color: red; line-height: 2.8;"></span>
                </div>
            </a>            
        </li>
    </ul>    
</section>
<section>
    <div id="modal-info-phim" data-izimodal-transitionin="comingInDown">
        <div class="modal-body" style="padding-bottom: 20px">        
            <div class="row">                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
                        <img src="{{$phim[0]->phim_hinhanh}}" width="100%"/>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="text-center">
                            <strong style="color: lightseagreen;font-size: 1.5em;">
                                {{$phim[0]->phim_ten}}
                            </strong>                            
                        </div>
                        <div>
                            <ul class="">
                                <li>
                                    <label>Tên khác:</label>
                                    <span>{{$phim[0]->phim_tenkhac}}</span>
                                </li>
                                <li>
                                    <label>Thể loại:</label>
                                    <span>
                                        <?php
                                            for($i = 0; $i < count($listTheLoai); $i++){
                                                echo $listTheLoai[$i]->theloai_ten;
                                                echo $i+1<count($listTheLoai)?', ':'.';
                                            }
                                        ?>                                        
                                    </span>
                                </li>
                                <li>
                                    <label>Số tập:</label>
                                    <span>{{$phim[0]->phim_sotap}}</span>
                                </li>
                                <li>
                                    <label>Năm phát hành:</label>
                                    <span>{{$phim[0]->phim_nam}}</span>
                                </li>
                                <li>
                                    <label>Lượt xem:</label>
                                    <span>{{$phim[0]->phim_luotxem}}</span>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul>
                            <li>
                                <label>Đánh giá:</label>
                                <span></span>
                            </li>
                            <li>
                                <label>Nguồn video:</label>
                                <span>{{$phim[0]->phim_nguon}}</span>
                            </li>
                            <li>
                                <label>Tóm tắt nội dung:</label>
                                <span>{{empty($phim[0]->phim_gioithieu)?'đang cập nhật':$phim[0]->phim_gioithieu}}</span>
                            </li>
                        </ul>
                    </div>
                </div>               
            </div>            
        </div>
    </div>
    <script>
        $('#modal-info-phim').iziModal({
                title: 'Thông tin phim {{$phim[0]->phim_ten}}',
                top: 100,
                overlayClose: true,                
                width: 600,
                headerColor: 'rgb(56, 98, 111)',
                icon: 'fa fa-info',
                iconColor: 'white'
            }); 
    </script>
</section>
@endsection