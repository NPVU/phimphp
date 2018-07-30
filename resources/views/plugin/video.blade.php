@if(!empty($tap[0]->googleRedirectLink))
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
    <div class="video-player">        
        <video id="video-player" width="100%" src="{{!empty($tap[0]->googleRedirectLink['720p'])?$tap[0]->googleRedirectLink['720p']:$tap[0]->googleRedirectLink['360p']}}" controls>            
            <source src="{{$tap[0]->googleRedirectLink['360p']}}" id="google360p" />
            @if(!empty($tap[0]->googleRedirectLink['720p']))
            <source src="{{$tap[0]->googleRedirectLink['720p']}}" id="google720p" />
            @endif
            @if(!empty($tap[0]->googleRedirectLink['1080p']))
            <source src="{{$tap[0]->googleRedirectLink['1080p']}}" id="google1080p" />
            @endif
        </video>                   
    </div>
</div>
<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    <ul class="npv-list-action">
        <li>
            <div class="npv-icon">
                <i class="fa fa-play"></i>
            </div>
        </li>                    
        <li>
            <div class="npv-icon">
                <b>HD</b>
            </div>
        </li>
    </ul>
    <script>
                    
    </script>
</div>
 @else
    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
        <iframe class="npv-youtube" src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white"></iframe>
    </div>
@endif 