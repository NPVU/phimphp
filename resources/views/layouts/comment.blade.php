<section style="padding: 5em 0;" id="comment">
    <div class="container">
        <h3 class="heading">Bình luận</h3>    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="input-group">
                <textarea id="input-comment" class="form-control" rows="3" style="resize:none" {{Auth::check()?'':'disabled'}} >{{Auth::check()?'':'Vui lòng đăng nhập để bình luận'}}</textarea>     
                <span class="btn input-group-addon themes-color" onclick="{{Auth::check()?'sendComment('.$phim[0]->phim_id.');':'openLogin();'}}">Gửi</span>
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