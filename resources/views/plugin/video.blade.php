
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="video-player">
        <video id="video-player" width="100%" poster="{{ asset('img/poster-video.png') }}"></video>                             
        <div class="video-background-loading display-none">
            <div class="video-loader"></div>
        </div>
        <div class="video-background-overlay display-none">
            
        </div>
    </div>
    <div class="video-control">
        <div class="player-control progress-duration-time" title="0:20">     
            <div class="player-control progress-current-time">                                
            </div>
        </div>            
        <div class="control-left">                            
            <div class="player-control">
                <i class="btn-play fa fa-play"></i>
            </div>
            <div class="player-control">
                <i class="btn-replay fa fa-redo-alt" data-toggle="tooltip" title="Replay"></i>
            </div>
            <div class="player-control" data-toggle="tooltip" title="Volume">
                <div class="volume-control">
                    <i class="btn-volume fa fa-volume-up">
                    </i>
                    <div class="volume-panel" aria-valuemin="0" aria-valuemax="50" aria-valuenow="50" aria-valuetext="79% volume">
                        <div class="volume-slider" draggable="true"></div>
                    </div>      
                </div>
            </div>
            <div class="player-control" style="color:white">
                <span class="current-time">0:00</span>
                /
                <span class="duration-time">0:00</span>
            </div>                                  
        </div>
        <div class="control-right">                                
            <div class="player-control" data-toggle="tooltip" title="Setting">
                <i class="btn-setting fab fa-whmcs"></i>
            </div>
            <div class="player-control" data-toggle="tooltip" title="Full screen">
                <i class="btn-screen fa fa-expand"></i>
            </div>
        </div>
    </div>
</div>
<!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="list-episode">
        <div class="title title-episode">
            Danh sách tập
            <span>19/24</span>
        </div>

        <ul class="ul-list-episode">
            <li>
                <img src="http://images6.fanpop.com/image/photos/38700000/esdeath-akame-ga-kill-anime-girl-art-picture-sword-edsese-esdeath-38784542-1920-1080.jpg" >
                <h5>The Grasslands</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod ultrices ante, ac laoreet nulla vestibulum adipiscing. Nam quis justo in augue auctor imperdiet.</p>
            </li>

            <li>
                <img src="http://images6.fanpop.com/image/photos/38700000/esdeath-akame-ga-kill-anime-girl-art-picture-sword-edsese-esdeath-38784542-1920-1080.jpg" >
                <h5>Paradise Found</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod ultrices ante, ac laoreet nulla vestibulum adipiscing. Nam quis justo in augue auctor imperdiet.</p>
            </li>

            <li>
                <img src="http://images6.fanpop.com/image/photos/38700000/esdeath-akame-ga-kill-anime-girl-art-picture-sword-edsese-esdeath-38784542-1920-1080.jpg" >
                <h5>Smoke On The Water</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod ultrices ante, ac laoreet nulla vestibulum adipiscing. Nam quis justo in augue auctor imperdiet.</p>
            </li>

            <li>
                <img src="http://images6.fanpop.com/image/photos/38700000/esdeath-akame-ga-kill-anime-girl-art-picture-sword-edsese-esdeath-38784542-1920-1080.jpg" >
                <h5>Headline</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod ultrices ante, ac laoreet nulla vestibulum adipiscing. Nam quis justo in augue auctor imperdiet.</p>
            </li>
        </ul>
    </div>

</div>-->

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="chaxbox">
        <div class="title">
            chaxbox            
        </div>
    </div>
</div>

<script src="https://vjs.zencdn.net/7.0.3/video.js"></script>