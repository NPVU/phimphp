<div id="modal-backurl" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <h5>Bạn có đồng ý chuyển đến trang trước khi đăng nhập không ?</h5>
                <div class="text-center" style="margin-top: 10px;">
                    <a href="{{ session('backURL') }}" class="btn btn-danger">Đồng ý</a>
                    <button type="button" class="btn btn-default" data-izimodal-close="">Không</button>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    $('#modal-backurl').iziModal({
        title: 'Chuyển trang',
        top: 100,
        overlayClose: true,                                
        openFullscreen:false,
        headerColor: 'rgb(56, 98, 111)',
        icon: 'fa fa-check',
        iconColor: 'white'
    }); 
    $('#modal-backurl').iziModal('open');
</script>