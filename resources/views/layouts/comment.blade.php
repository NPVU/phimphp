<section style="padding: 5em 0;" id="comment">
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
                <table class="table no-border" style="margin-bottom:0px">
                    <tr>
                        <td style="width:120px;" class="text-center">
                            <img class="action-comment-avatar avatar img-circle" src="" width="100%" />
                        </td>
                        <td class="text-left">
                            <div class="action-comment-username" style="font-weight: 700"></div>
                            <div class="action-comment-content content-comment"></div>
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
<div id="report-comment" data-izimodal-transitionin="fadeInDown">
    <div class="modal-body" style="padding: 20px">
        <div class="row report-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table no-border" style="margin-bottom:0px">
                    <tr>
                        <td style="width:120px;" class="text-center">
                            <img class="report-comment-avatar avatar img-circle" src="" width="100%" />
                        </td>
                        <td class="text-left">
                            <div class="report-comment-username" style="font-weight: 700"></div>
                            <div class="report-comment-content content-comment"></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Nội dung report</label>
                    <textarea class="form-control" id="input-report-comment" ></textarea>
                    <i style="color:gray" class="help-report-comment">Nội dung report phải có độ dài lớn hơn 10 ký tự</i>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-danger btn-report-comment">Gửi</button>                
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>
        <div class="row report-result">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <span class="fa fa-2x fa-check icon-voted"></span>
                <div class="content-report-result"></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">                
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>
    </div>        
</div>
<script>
    $("#action-comment").iziModal({title:"Bình luận",overlayClose:!0,width:600,openFullscreen:!1,bodyOverflow:!0,headerColor:"rgb(56, 98, 111)"}),$("#report-comment").iziModal({title:"Report bình luận",overlayClose:!0,width:600,openFullscreen:!1,bodyOverflow:!0,icon:"fa fa-exclamation-triangle",headerColor:"rgb(56, 98, 111)",onOpening:function(){$(".report-result").addClass("display-none"),$(".report-body").removeClass("display-none"),$("#input-report-comment").val("")}});
</script>