<div id="modal-cookie-phim" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-center">
                    <h5 class="chuyentap-content"> 
                        <div>Lần trước bạn đã xem đến phút thứ&nbsp;<span style="font-weight:700">{{$cookiePhim['timeDisplay']}}&nbsp;của tập&nbsp;{{$cookiePhim['tapSoHienThi']}}</span>.</div>
                        <div> Bạn có muốn tiếp tục xem không?</div>
                    </h5>                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-primary" onclick="xemTiepTuc();">Tiếp tục</button>
                <button class="btn btn-default" data-izimodal-close="">Không</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    var tap = {{$cookiePhim['tapID']}};

    $('#modal-cookie-phim').iziModal({
        title: 'Tiếp tục lần trước',        
        headerColor: '#263238',
        icon: 'fa fa-info-circle',
        iconColor: 'white'
    });
    if($('meta[name="tid"]').attr('content') != tap){
        $('#modal-cookie-phim').iziModal('open');
    } else {
        setTimeout(function(){
            $('video').get(0).currentTime = {{$cookiePhim['time']}};
            $('video').get(0).play();
        } , 3000);        
    }
});
function xemTiepTuc(){        
    $('#modal-cookie-phim').iziModal('startLoading');
    window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/{{$cookiePhim['tapID']}}.html";    
}
function millisToMinutesAndSeconds(millis) {
  var minutes = Math.floor(millis / 60000);
  var seconds = ((millis % 60000) / 1000).toFixed(0);
  return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}
</script>