@if($phim[0]->phim_dotuoi > 0 && (!Session::has('confirmAge') || (Session::has('confirmAge') && !in_array($phim[0]->phim_id, Session::get('confirmAge')))))
<div id="modal-confirm-age" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="text-center">
                    <h5>Phim này có cảnh quay nhạy cảm không phù hợp với khán giả dưới&nbsp;{{$phim[0]->phim_dotuoi.' tuổi'}}</h5>
                    <h4>Bạn cần cân nhắc trước khi xem</h4>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-danger" data-izimodal-close="">Tôi đã đủ&nbsp;{{$phim[0]->phim_dotuoi.' tuổi'}}</button>
                <a href="{{url('/')}}"><button class="btn btn-default" >Tôi chưa đủ&nbsp;{{$phim[0]->phim_dotuoi.' tuổi'}}</button></a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal-confirm-age').iziModal({
        title: 'Cảnh báo độ tuổi',        
        overlayClose: false,
        closeButton:false,
        closeOnEscape:false,
        width: 600,
        headerColor: 'rgb(217, 83, 79)',
        icon: 'fa fa-exclamation-triangle',
        iconColor: 'white',
        onClosing: function(){
            confirmAge({{$phim[0]->phim_id}});
        }
    });
    $('#modal-confirm-age').iziModal('open');
</script>
@endif