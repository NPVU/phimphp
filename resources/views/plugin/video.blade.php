@if(strcmp($_GET['s'], md5('google'))==0)
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
    <div class="video-player">        
        <video id="video-player" width="100%" controls>            
            <source src="{{$tap[0]->googleRedirectLink['360p']}}" id="google360p" type="video/mp4"/>
            @if(!empty($tap[0]->googleRedirectLink['720p']))
            <source src="{{$tap[0]->googleRedirectLink['720p']}}" id="google720p" type="video/mp4"/>
            @endif
            @if(!empty($tap[0]->googleRedirectLink['1080p']))
            <source src="{{$tap[0]->googleRedirectLink['1080p']}}" id="google1080p" type="video/mp4"/>
            @endif     
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
        @if(!empty($tap[0]->googleRedirectLink['720p']))
        <li>
            <div class="npv-icon">
                <b class="npv-quality" quality="360">HD</b>
            </div>
        </li>
        @endif
    </ul>
    <script type="text/javascript">
        var video = document.getElementById('video-player');
        $('.npv-play').click(function(){           
           if(video.paused){               
               video.play();
           } else {               
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
            } else {
                console.log('360');
                video.setAttribute('src', $('#google360p').attr('src'));
                $('.npv-quality').css('color','gray');
                $('.npv-quality').attr('quality', "360");
            }     
            video.currentTime = currentTime;
            video.play();
        });
        video.onplaying = function(){
            $('.npv-play > i').addClass('fa-pause');
            $('.npv-play > i').removeClass('fa-play');
        };
        video.onpause = function(){
            $('.npv-play > i').addClass('fa-play');
            $('.npv-play > i').removeClass('fa-pause');
        }
    </script>
</div>
@elseif(strcmp($_GET['s'], md5('youtube'))==0)
    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
        <iframe class="npv-youtube" src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white"></iframe>
    </div>
@else
    
@endif 