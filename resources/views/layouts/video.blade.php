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
<script type="text/javascript">    
        var sotap = {{$listTap[count($listTap)-1]->tap_tapso}};        
        var auto;
        var video = document.getElementById('my-player');
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
                            $('.npv-quality').attr('quality', "720");
                            video.onerror = function(){                                
                                video.setAttribute('src', $('#google360p').attr('src'));                                
                                video.play();
                            };
                            $('.icon-quality').removeClass('display-none');
                            $('#google720p').attr('src', data['720p']);
                        }else{
                            $('#my-player').attr('src', data['360p']);                            
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
        };
        video.onplaying = function(){
            $('.npv-play > i').addClass('fa-pause');
            $('.npv-play > i').removeClass('fa-play');
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
        };
        function nextVideo(){
            var v = document.getElementById('my-player');
            if(v.duration - v.currentTime === 0){
                if(getParameterByName('t','') < sotap){
                    iziToast.show({
                        timeout: 10000,
                        theme: 'dark',
                        icon: 'fa fa-play',
                        title: 'Chuyển tập trong 5s',                        
                        position: 'center', 
                        progressBarColor: '#27ABDB',
                        buttons: [
                            ['<button>Chuyển ngay</button>', function (instance, toast) {
                                window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+(parseInt(getParameterByName('t',''))+1)+"&s={{md5('google')}}";
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
                    confirmAutoNext(10);                    
                }
            }
        }
            function confirmAutoNext(i){         
                if(i <= 0){
                    window.location.href = $('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+(parseInt(getParameterByName('t',''))+1)+"&s={{md5('google')}}";
                } else {    
                    $('.iziToast-title').html('Chuyển tập trong '+(i-1)+'s');
                    auto = setTimeout(() => {
                        confirmAutoNext(i-1);
                    }, 1000);
                }
            }
    </script>
@elseif(strcmp($_GET['s'], md5('youtube'))==0)
    @if(!empty($tap[0]->tap_youtubelink))
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <iframe class="npv-youtube" src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white"></iframe>
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