@if(strcmp($_GET['s'], md5('google'))==0)
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
    <div class="video-player">        
        <video id="video-player" autoplay="true" width="100%" poster="{{asset('public/img/themes/video-poster.gif')}}">            
            <source src="" id="google360p" type="video/mp4"/>
            <source src="" id="google720p" type="video/mp4"/>
            <source src="" id="google1080p" type="video/mp4"/>
            Máy chủ bị lỗi, vui lòng chọn máy chủ khác
        </video>                   
    </div>
</div>
<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    <ul class="npv-list-action">
        <li>
            <div class="npv-icon npv-play">
                <i class="fa fa-play"></i>
            </div>
        </li>             
        <li class="icon-quality display-none">
            <div class="npv-icon">
                <b class="npv-quality" quality="360">HD</b>
            </div>
        </li>        
    </ul>
    <script type="text/javascript">    
        var video = document.getElementById('video-player');
        $(document).ready(function(){
            $('#video-player').load();
            $.ajax({
                url: '{{url("/autoload")}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&token={{Session::token()}}',
                dataType: 'text',
                type: 'get',
                success:function(data){
                    if(data!=null){
                        data = JSON.parse(data);                                   
                        $('#google360p').attr('src', data['360p']);
                        if(data['720p']!=null){
                            $('#video-player').attr('src', data['720p']);                                                   
                            $('.npv-quality').css('color','white');
                            $('.npv-quality').attr('quality', "720");
                            video.onerror = function(){                                
                                video.setAttribute('src', $('#google360p').attr('src'));                                
                                video.play();
                            };
                            $('.icon-quality').removeClass('display-none');
                            $('#google720p').attr('src', data['720p']);
                        }else{
                            $('#video-player').attr('src', data['360p']);                            
                        }
                        if(data['1080p']!=null){
                            $('#google1080p').attr('src', data['1080p']);
                        }
                        $('#video-player').removeAttr('poster');
                        $('#video-player').prop('controls',true);
                    }
                }
            });
        });        
        var v = 0;
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
                console.log('720');
                video.setAttribute('src', $('#google720p').attr('src'));
                $('.npv-quality').css('color','white');
                $('.npv-quality').attr('quality', "720");
                video.onerror = function(){
                    video.setAttribute('src', $('#google360p').attr('src'));
                    video.currentTime = currentTime;
                    video.play();
                };
            }else{
                console.log('360');
                video.setAttribute('src', $('#google360p').attr('src'));
                $('.npv-quality').css('color','gray');
                $('.npv-quality').attr('quality', "360");
            }
            video.currentTime = currentTime;video.play();
        });
        video.onloadeddata = function(){
            video.play();
        }
        video.onplaying = function(){
            $('.npv-play > i').addClass('fa-pause');
            $('.npv-play > i').removeClass('fa-play');
            if(v===0){v=1;setTimeout(function(){viewTimes("{{url('update')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('google')}}&token={{csrf_token()}}");}, 10000);}};video.onpause = function(){$('.npv-play > i').addClass('fa-play');$('.npv-play > i').removeClass('fa-pause');nextVideo();};function nextVideo(){var v = document.getElementById('video-player');if(v.duration - v.currentTime === 0){setTimeout(() => {window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']+1}}&s={{md5('google')}}";}, 3000);}}
    </script>    
</div>
@elseif(strcmp($_GET['s'], md5('youtube'))==0)
    @if(!empty($tap[0]->tap_youtubelink))
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <iframe class="npv-youtube" src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white"></iframe>
    </div>
    @else    
    <script>
        window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{$_GET['t']}}&s={{md5('google')}}";
    </script>
    @endif
@else
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px;">
    <h4 style="color:red">Vui lòng không tự ý sửa đường dẫn trên trình duyệt</h4>
</div>
@endif 