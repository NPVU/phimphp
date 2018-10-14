@if($tap[0]->tap_tapso <= Request::cookie('tapSo-'.$phim[0]->phim_id))
<div id="modal-cookie-phim" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-center">
                    <h5>Lần trước bạn đã xem đến phút thứ&nbsp;<span style="font-weight:700">{{Request::cookie("time-".Request::cookie("tapID-".$phim[0]->phim_id))}}&nbsp;(Tập&nbsp;{{Request::cookie("tapSoHienThi-".$phim[0]->phim_id)}})</span>. Bạn có muốn tiếp tục xem không?</h5>                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-primary" onclick="xemTiepTuc();">Xem tiếp</button>
                <button class="btn btn-default" data-izimodal-close="">Không</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal-cookie-phim').iziModal({
        title: 'Xem tiếp lần trước',
        top: 100,        
        headerColor: '#263238',
        icon: 'fa fa-info-circle',
        iconColor: 'white'
    });
    var cookie = getParameterByName('n', '');
    if(cookie == null){
        $('#modal-cookie-phim').iziModal('open');
    }        
</script>
@endif
<script>    
$(document).ready(function(){  
    $('a[href]').click(function(){
       var currentTimeSecond = $('video').get(0).currentTime;
       if(currentTimeSecond == null){
           currentTimeSecond = 0;
       }
       var tap = getParameterByName('t','');
       console.log('tap '+tap);
       console.log('second '+currentTimeSecond);
       var xhttp = new XMLHttpRequest();
       xhttp.open("GET", $('meta[name="url"').attr('content') + '/cookie?t=' + tap + '&time=' + currentTimeSecond, false);
       xhttp.send();
      
    });
});
function xemTiepTuc(){
    if(getParameterByName('t', '') === {{$tap[0]->tap_id}}){
        $('#modal-cookie-phim').iziModal('close');
        $('video').get(0).currentTime = {{Request::cookie("time-".Request::cookie("tapID-".$phim[0]->phim_id))==null?0:Request::cookie("time-".Request::cookie("tapID-".$phim[0]->phim_id))}};
        $('video').get(0).play();            
    }else{
        window.location.href = "{{url('xem-phim')}}/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid={{$_GET['pid']}}&t={{Request::cookie('tapID-'.$phim[0]->phim_id)}}&s={{$_GET['s']}}&n=true";
    }    
}
</script>