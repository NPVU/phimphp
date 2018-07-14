/* <video id = "video-player" /> */
var videoID = document.getElementById("video-player");
$(document).ready(function(){
        videoID.onloadstart = function(){          
            $('.video-background-loading').removeClass('display-none');
        };
        videoID.onloadeddata = function() {
            $('.video-background-loading').addClass('display-none');
            $('.video-background-overlay').removeClass('display-none');
            $('.duration-time').html(fancyTimeFormat(videoID.duration));
            $('.video-control').css('z-index', 1000);            
        };       
        videoID.onplaying = function(){
            progressTime();
        };
        $('#video-player, .video-background-overlay').click(function(){
           playVideo();
        });       
        $('#video-player, .video-control').hover(function(){
            $('.video-control').css('z-index', 1000);
        }, function(){
            if(!videoID.paused){
                $('.video-control').css('z-index', -1);
            }            
        });
	$('.btn-play').click(function(){
            playVideo();
	});
        $('.btn-replay').click(function(){
            videoID.currentTime = 0;
            if(videoID.paused){
                $('.btn-play').addClass('fa-pause');
                $('.btn-play').removeClass('fa-play'); 
                videoID.play(); 
            }
        });
        $('.btn-screen').click(function(){
            if (videoID.requestFullscreen) {
            videoID.requestFullscreen();
            } else if (videoID.mozRequestFullScreen) {
                videoID.mozRequestFullScreen();
            } else if (videoID.webkitRequestFullscreen) {
                videoID.webkitRequestFullscreen();
            }
        });        
        $('.progress-duration-time').mousemove(function(e){
            console.log('time: '+fancyTimeFormat(calculatorTime(e)));
        });
        $('.progress-duration-time').click(function(e){
            videoID.currentTime = calculatorTime(e);
            if(videoID.paused){
                $('.current-time').html(fancyTimeFormat(videoID.currentTime));
                $('.progress-current-time').css('width',getRateCurrentPerDuration(videoID.currentTime, videoID.duration));
            }
        });
        $('.volume-control').hover(function(){            
            var volume = $('.volume-panel').attr('aria-valuenow');
            $('.volume-panel').animate({
               width: '50px'
            });
            $('.volume-slider').animate({
               width: volume+'px'
            });
        },function(){
            $('.volume-panel').animate({
               width: '0px'
            });
            $('.volume-slider').animate({
               width: '0px'
            });
        });
        $('.btn-volume').click(function(){
           if(videoID.volume > 0){
               videoID.volume = 0;
               $('.volume-slider').css('width','0px');
               $('.volume-panel').attr('aria-valuenow',0);
           } else {
               videoID.volume = 1.0;
               $('.volume-slider').css('width',$('.volume-panel').width()+'px');
               $('.volume-panel').attr('aria-valuenow',$('.volume-panel').width());
           }
           progessVolume(videoID.volume);
        });
        $('.volume-panel').click(function(e){
            var volume = calculatorVolume(e);
            $('.volume-slider').css('width',volume+'px');
            $('.volume-panel').attr('aria-valuenow',volume);            
            videoID.volume = parseFloat(volume*2/100);            
            console.log('volume: '+videoID.volume);
            progessVolume(videoID.volume);
        });        
});
function playVideo(){
    if(videoID.paused){
	$('.btn-play').addClass('fa-pause');
	$('.btn-play').removeClass('fa-play');  
        $('.video-background-overlay').addClass('display-none');
	videoID.play();                        
    } else {
	$('.btn-play').addClass('fa-play');
	$('.btn-play').removeClass('fa-pause');
        $('.video-background-overlay').removeClass('display-none');
        videoID.pause();
    }
}
function progressTime(){
   $('.current-time').html(fancyTimeFormat(videoID.currentTime));
   $('.progress-current-time').css('width',getRateCurrentPerDuration(videoID.currentTime, videoID.duration));
   if(videoID.currentTime === videoID.duration){
       $('.btn-play').addClass('fa-play');
       $('.btn-play').removeClass('fa-pause');
   }
   if(!videoID.paused){
       console.log('Video is playing ...');
       $('.btn-play').addClass('fa-pause');
       $('.btn-play').removeClass('fa-play');
       setTimeout(progressTime,100);
   } else {
       console.log('Video is stoped.');
       $('.btn-play').addClass('fa-play');
       $('.btn-play').removeClass('fa-pause');
   }
}
function progessVolume(vol) {
    if (vol > 0.5) {
        $('.btn-volume').removeClass('fa-volume-down');
        $('.btn-volume').removeClass('fa-volume-off');
        $('.btn-volume').addClass('fa-volume-up');
    } else if (vol > 0) {
        $('.btn-volume').removeClass('fa-volume-up');
        $('.btn-volume').removeClass('fa-volume-off');
        $('.btn-volume').addClass('fa-volume-down');
    } else {
        $('.btn-volume').removeClass('fa-volume-up');
        $('.btn-volume').removeClass('fa-volume-down');
        $('.btn-volume').addClass('fa-volume-off');
    }
}
function fancyTimeFormat(time)
{   
    // Hours, minutes and seconds
    var hrs = ~~(time / 3600);
    var mins = ~~((time % 3600) / 60);
    var secs = Math.floor(time % 60);

    // Output like "1:01" or "4:03:59" or "123:03:59"
    var ret = "";

    if (hrs > 0) {
        ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
    }

    ret += "" + mins + ":" + (secs < 10 ? "0" : "");
    ret += "" + secs;
    return ret;
}
function getRateCurrentPerDuration(current, duration){
    return parseFloat((current/duration)*100)+"%";
}
function calculatorTime(e){
    var widthDiv = $('.video-control').width();
    var widthMouse = e.pageX - $('.video-control').offset().left;
    var rate = parseFloat(widthMouse/widthDiv);
    var time = rate*videoID.duration;
    return time;
}
function calculatorVolume(e){
    var widthDiv = $('.volume-panel').width();
    var widthMouse = e.pageX - $('.volume-panel').offset().left;    
    return widthMouse;
}
function resetVideo(){
    $('.duration-time').html('0:00');
    $('.current-time').html('0:00');
    $('.progress-current-time').css('width',0);
    $('.video-background-overlay').addClass('display-none');
}