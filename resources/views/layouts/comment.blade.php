<section style="padding: 5em 0;" id="comment" aria-token="{{csrf_token()}}">
    <div class="container">
        <h3 class="heading">Bình luận</h3>    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="input-group">
                <textarea id="input-comment" class="form-control" rows="3" style="resize:none" {{Auth::check()?'':'disabled'}} >{{Auth::check()?'':'Vui lòng đăng nhập để bình luận'}}</textarea>     
                <span class="btn input-group-addon themes-color" onclick="{{Auth::check()?'sendComment('.$phim[0]->phim_id.',"'.csrf_token().'");':'openLogin();'}}">Gửi</span>
            </div>
        </div>    
        
        <div id="binhluan" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
            <table class="table list-comment">
                <tbody class="comment-page-1">
                    <?php echo $comment ?>
                </tbody>
                <tbody class="comment-page-2">
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <i onclick="xtc({{$_GET['pid']}})" aria-page="2" class="xtc npv-icon-xemthem fa fa-2x fa-angle-double-down" data-toggle="tooltip" title="Xem thêm"></i>
        </div>
    </div>    
</section>
<div id="action-comment" data-izimodal-transitionin="fadeInDown">
    <div class="modal-body" style="padding: 20px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table">
                    <tr>
                        <td style="width:120px;" class="text-center">
                            <img class="action-comment-avatar avatar img-circle" src="" width="100%" />
                        </td>
                        <td class="text-left">
                            <div class="action-comment-username" style="font-weight: 700"></div>
                            <div class="action-comment-content"></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-danger btn-lock-account">Khóa tài khoản</button>
                <button class="btn btn-warning btn-delete-comment">Xóa bình luận</button>
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>
    </div>        
</div>
<script>
    $('#action-comment').iziModal({
        title: 'Bình luận',        
        overlayClose: true,
        width:600,
        openFullscreen:false,
        bodyOverflow:true,
        headerColor: 'rgb(56, 98, 111)'            
    });
</script>