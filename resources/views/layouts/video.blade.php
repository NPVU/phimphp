@if(strcmp($_GET['s'], md5('google'))==0)
<!--<video id="my-player" class="video-js">
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
</video>-->
<div id="video" class="video-js">
    <div id="my-player"><h4 style="margin-left:20px"> Đang xử lý dữ liệu ...
        <ol>
            <li>Nếu không xem được vui lòng nhấn Crtl+F5 </li>
            <li>Báo lỗi </li>
            <li>Chuyển Server khác (nếu có) </li>
        </ol>
    </h4></div>
</div>
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
                        ],
                    autostart: autoplay,image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",},
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
                            autostart: true,image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",},
                        });
                    @endif
                    jwplayer('my-player').load();
                    jwplayer('my-player').on('play', function(){        
                        if(vupdate===0){
                            vupdate=1;                                          
                            setTimeout(function(){
                                viewTimes({{$tap[0]->tap_id}});
                            }, 10000);
                        }        
                    });
                });
                xpr.on('play', function(){        
                    if(vupdate===0){
                        vupdate=1;                                     
                        setTimeout(function(){
                            viewTimes({{$tap[0]->tap_id}});
                        }, 10000);
                    }        
                });   
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
                                        window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t={{ClassCommon::getNextEpisode($tap[0]->tap_id)}}&s="+getParameterByName('s','');
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
                        image: "{{$phim[0]->phim_hinhnen}}","skin" : {"url":"{{asset('css/jwplayer-skin.min.css')}}","name": "glow",}
                    });
                    jwplayer('my-player').load();
                    jwplayer('my-player').on('play', function(){        
                        if(vupdate===0){
                            vupdate=1;                                          
                            setTimeout(function(){
                                viewTimes({{$tap[0]->tap_id}});
                            }, 10000);
                        }        
                    });
                }
            });
            
        });
    });
    
    function confirmAutoNext(i){         
        if(i <= 0){
             window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t={{ClassCommon::getNextEpisode($tap[0]->tap_id)}}&s="+getParameterByName('s','');
        } else {    
            $('.iziToast-title').html('Chuyển tập trong '+(i-1)+'s');
            auto = setTimeout(() => {
                confirmAutoNext(i-1);
            }, 1000);
        }
    }
</script>
@elseif(strcmp($_GET['s'], md5('openload'))==0)
<video id="my-player" class="video-js" src="" controls="true" autoplay="true">           
        <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="http://videojs.com/html5-video-support/" target="_blank">
            supports HTML5 video
            </a>
        </p>
</video>
<div id="modal-captcha" data-izimodal-transitionin="fadeInUp">            
    <div class="modal-body" style="padding-bottom: 20px">                
        <div>
            <img id="captcha" src="" alt="captcha" title="Mã xác nhận" width="25%"/> 
                <i id="iconLoadingCaptcha" class="fa fa-sync-alt fa-spin display-none" title="Loading..."></i>                                                   
                <label id="messageErrorCaptcha" class="text-danger display-none">Mã xác nhận không đúng, vui lòng nhập lại !</label>
        </div>
        <div style="width:90%;">
            <div class="input-group">
                <input type="text" id="txtCaptcha" class="form-control" placeholder="Nhập mã xác nhận" aria-label="Nhập mã xác nhận" aria-describedby="basic-addon2">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-outline-secondary"                                
                            title="Làm mới mã xác nhận" onclick="getTicket()">
                        <span class="fa fa-x fa-redo-alt"></span>
                    </button>                                                    
                    <button type="button" class="btn btn-primary btn-outline-secondary"title="Xác nhận" onclick="getVideo()">
                        <span class="fa fa-x fa-check-circle btn-api-video" ></span>
                    </button>
                </div>
            </div>     
        </div>                            
    </div>
</div>
<script>                        
        $('#modal-captcha').iziModal({
             title: 'Nhập captcha để xem video',
             overlayClose:false,
             headerColor: '#263238',
             icon: 'fa fa-shield-alt',
             onOpening: function(modal){
                 modal.startLoading();                 
             },
             onOpened: function(modal){
                 modal.stopLoading();                 
             }
         });                               
</script>
@elseif(strcmp($_GET['s'], md5('youtube'))==0) 
    @if(!empty($tap[0]->tap_youtubelink))
    <div id="video" class="video-js">
        <iframe class="npv-youtube" src="https://www.youtube.com/embed/{{$tap[0]->tap_youtubelink}}?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white" width="100%" height="100%"></iframe>
    </div>
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