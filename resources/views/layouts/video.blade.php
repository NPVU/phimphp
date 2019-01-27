<div id="video" class="video-js">
    <div id="my-player" style="width: 100%; height: 100%;">       
        @if(empty($tap[0]->tap_googlelink))
            @if(!empty($tap[0]->tap_openloadlink))
                <iframe src="{{$tap[0]->tap_openloadlink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen width="100%" height="100%"></iframe>
            @else
                <iframe src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen width="100%" height="100%"></iframe>
            @endif
        @endif
    </div>
</div>
@if(!empty($tap[0]->tap_googlelink))
<script type="text/javascript" src="{{ asset('js/jwplayer.min.js') }}"></script>
<script type="text/javascript">    
    jwplayer.key=$videoKey;    
    var vupdate = 0;    
    var auto;    
    var xpr = jwplayer('my-player');
    var autoplay = '{{!($phim[0]->phim_dotuoi > 0 && (!Session::has('confirmAge') || (Session::has('confirmAge') && !in_array($phim[0]->phim_id, Session::get('confirmAge')))))?true:false}}';
    var sourcesTemp = '';
    $(document).ready(function(){
        $.ajax({
            type: 'post',           
            url: $('meta[name="url"]').attr('content')+'/load',
            data: {'id':{{$tap[0]->tap_id}} },        
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {                
                sourcesTemp = data['360p'];
                xpr.setup({
                    width: "100%",
                    height: "100%",
                    sources: [
                            {file: data['360p'],label:'360p','type':'mp4'},  
                            @if($tap[0]->tap_chatluong >= 3)
                            {file: data['720p'],label:'720p','type':'mp4','default': 'true'},
                            @endif  
                            @if($tap[0]->tap_chatluong >= 4)
                            {file: data['1080p'],label:'1080p','type':'mp4'},
                            @endif                                                         
                        ],
                    autostart: true,
                    playbackRateControls:[0.5,0.75,1,1.5,2],
                    image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",},
                });    
                xpr.on('error', function() { 
                    @if(!empty($tap[0]->tap_facebooklink))                       
                        $.ajax({
                            type: 'post',           
                            url: $('meta[name="url"]').attr('content')+'/api/fb',
                            data: {'tapid':{{$tap[0]->tap_id}} },        
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {                                
                                jwplayer('my-player').setup({            
                                    width: "100%",
                                    height: "100%",
                                    sources: [
                                        {file: data.sd,label:'360p','type':'mp4'},     
                                        {file: data.hd,label:'720p','type':'mp4','default': 'true'},                                                
                                    ],
                                    autostart: true,
                                    playbackRateControls:[0.5,0.75,1,1.5,2],
                                    image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",}
                                });
                            }
                        });
                        
                    @else
                        jwplayer('my-player').setup({
                            width: "100%",
                            height: "100%",
                            sources: [
                                    {file:sourcesTemp,label:'360p','type':'mp4','default': 'true'},                                                                
                                ],
                            autostart: true,
                            playbackRateControls:[0.5,0.75,1,1.5,2],
                            image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",},
                        });
                    @endif
                    jwplayer('my-player').load();
                    /*jwplayer('my-player').on('play', function(){        
                        if(vupdate===0){
                            vupdate=1;                                          
                            setTimeout(function(){
                                viewTimes({{$tap[0]->tap_id}});
                            }, 10000);
                        }        
                    });*/
                });
                /*xpr.on('play', function(){        
                    if(vupdate===0){
                        vupdate=1;                                     
                        setTimeout(function(){
                            viewTimes({{$tap[0]->tap_id}});
                        }, 10000);
                    }        
                });*/
                xpr.on('complete', function(){      
                    var autoconfig = $('.btn-auto-next').attr('aria-auto').trim();
                    if(xpr.getDuration() - xpr.getPosition() === 0 && autoconfig==1){
                        @if(!ClassCommon::isLastEpisode($tap[0]->tap_id))
                        
                            iziToast.show({
                                timeout: 3000,
                                theme: 'dark',
                                icon: 'fa fa-play',
                                title: 'Chuyển tập trong 5s',                        
                                position: 'center', 
                                progressBarColor: '#27ABDB',
                                buttons: [
                                    ['<button>Chuyển ngay</button>', function (instance, toast) {
                                        window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{ClassCommon::getNextEpisode($tap[0]->tap_id)}}.html";
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
                        @endif
                    }
                });
            }
        }).fail(function() {
            $.ajax({
                type: 'post',           
                url: $('meta[name="url"]').attr('content')+'/api/fb',
                data: {'tapid':{{$tap[0]->tap_id}} },        
                headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {                                
                    jwplayer('my-player').setup({            
                        width: "100%",
                        height: "100%",
                        sources: [
                            {file: data.sd,label:'360p','type':'mp4'},     
                            {file: data.hd,label:'720p','type':'mp4','default': 'true'},                                                
                        ],
                        autostart: true,
                        playbackRateControls:[0.5,0.75,1,1.5,2],
                        image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",}
                    });
                    jwplayer('my-player').load();
                    /*jwplayer('my-player').on('play', function(){        
                        if(vupdate===0){
                            vupdate=1;                                          
                            setTimeout(function(){
                                viewTimes({{$tap[0]->tap_id}});
                            }, 10000);
                        }        
                    });*/
                }
            });
            
        });
    });
    
    function confirmAutoNext(i){         
        if(i <= 0){
             window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{ClassCommon::getNextEpisode($tap[0]->tap_id)}}.html";
        } else {    
            $('.iziToast-title').html('Chuyển tập trong '+(i-1)+'s');
            auto = setTimeout(() => {
                confirmAutoNext(i-1);
            }, 1000);
        }
    }
</script>
@endif