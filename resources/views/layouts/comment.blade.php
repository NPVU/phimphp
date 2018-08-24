<section style="padding: 5em 0;" id="comment">
    <div class="container">
        <h3 class="heading">Bình luận</h3>    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="input-group">
                <textarea id="input-comment" class="form-control" rows="3" style="resize:none" {{Auth::check()?'':'disabled'}} >{{Auth::check()?'':'Vui lòng đăng nhập để bình luận'}}</textarea>     
                <span class="btn input-group-addon themes-color" onclick="{{Auth::check()?'sendComment("'.csrf_token().'");':'openLogin();'}}">Gửi</span>
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
            <i onclick="xtc()" aria-page="2" class="xtc npv-icon-xemthem fa fa-2x fa-angle-double-down" data-toggle="tooltip" title="Xem thêm"></i>
        </div>
    </div>    
</section>
<script>
    function sendComment(token){
        if($('#input-comment').val().trim().length > 0){
            $.ajax({
                type: "GET",
                url: "{{url('/comment/')}}/"+token+"/"+{{$_GET['pid']}}+"/" + $('#input-comment').val(),
                success: function (data) {
                    if (data !== 0 && data !== -1) {
                        $('.list-comment').html('');
                        var newPage = document.createElement('tbody');
                        newPage.className = 'comment-page-1';
                        $('.list-comment').append(newPage);
                        $('.comment-page-1').html(data);
                        newPage2 = document.createElement('tbody');
                        newPage2.className = 'comment-page-2';
                        $('.list-comment').append(newPage2);
                        $('.xtc').attr('aria-page', 2);
                        $('#input-comment').val('');
                    }
                }
            });
        }
    }    
    function xtc(){
        var page = $('.xtc').attr('aria-page');
        $.ajax({
            url: '{{url("/comment/")}}?pid='+{{$_GET['pid']}}+'&page='+page,
            dataType: 'text',                    
            type: 'get',                    
            success: function (data) {                
            $('.comment-page-'+page).html(data);
            var nextPage = parseInt(page)+1;
            $('.xtc').attr('aria-page', nextPage);
            var newPage = document.createElement('tbody');
            newPage.className = 'comment-page-'+nextPage;
            $('.list-comment').append(newPage);
            }
        });
    }
</script>