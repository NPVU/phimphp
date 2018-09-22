@if(strcmp($_GET['s'], md5('google'))==0)
<video id="my-player" class="video-js">
            <source src="" id="google360p" type="video/mp4"/>
            <source src="" id="google720p" type="video/mp4"/>
            <source src="" id="google1080p" type="video/mp4"/>
        <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="http://videojs.com/html5-video-support/" target="_blank">
            supports HTML5 video
            </a>
        </p>
</video>

@elseif(strcmp($_GET['s'], md5('youtube'))==0)
    @if(!empty($tap[0]->tap_youtubelink))
    <iframe class="npv-youtube" src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white" width="100%" height="380"></iframe>
    @else    
    <script>
        window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+getParameterByName('t','')+"&s={{md5('google')}}";
    </script>
    @endif
@else
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px;">
    <h4 style="color:red">Vui lòng không tự ý sửa đường dẫn trên trình duyệt</h4>
</div>
@endif 