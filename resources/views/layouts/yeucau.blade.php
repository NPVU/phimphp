@extends('layouts.app') 
@section('title')
    Yêu Cầu Phim 
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">YÊU CẦU PHIM</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @if(empty($success))
        <form method="POST" action="{{ url('yeu-cau-phim') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            @csrf
            <div class="form-group">
                <label for="email" >E-Mail</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                    <input id="email" type="email" class="form-control" name="email" value="{{isset($_POST['email'])?$_POST['email']:''}}" required autofocus placeholder="Nhập vào địa chỉ e-mail của bạn.">
                </div>                
            </div>
            <div class="form-group">
                <label for="content" >Danh sách phim yêu cầu</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-film"></span></span>
                    <textarea id="content" name="content" class="form-control" rows="5" placeholder="Vui lòng nhập chính xác tên phim, mỗi 1 phim 1 dòng nhé">{{isset($_POST['content'])?$_POST['content']:''}}</textarea>
                </div>        
                <span class="invalid-feedback">
                    <strong class="error-content"></strong>
                </span>             
            </div>            
            <div class="form-group form-captcha">
                <label for="captcha">Mã xác nhận</label>
                <?php echo $captcha?> <span class="glyphicon glyphicon-refresh btn-refresh-captcha"></span>
                <div class="input-group" style="margin-top:5px">
                    <span class="input-group-addon"><span class="fa fa-shield-alt"></span></span>
                    <input type="text" class="form-control" name="captcha" required>
                </div>
                @if (!empty($errorCaptcha))
                    <span class="invalid-feedback">
                        <strong>Mã xác nhận không đúng</strong>
                    </span>
                @endif          
            </div>            
            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger" onclick="return checkYeuCauContent()">Gửi yêu cầu</button>              
            </div>
        </form>
        @else
            <div class="text-center" style="color:#14cc5e">
                <span class="fa fa-2x fa-check-circle"></span>
                <h4>Yêu cầu của bạn đã được ghi nhận thành công.</h4>
                <h5>Chúng tôi sẽ thông báo cho bạn khi hệ thống đã cập nhật phim. Cảm ơn bạn đã ủng hộ {{ config('app.name') }}.</h5>
            </div>
        @endif
    </div>
</div>
<script>
    $('.btn-refresh-captcha').click(function(){
        $.ajax({
            type: "GET",
            url: $('meta[name="url"]').attr('content')+'/get-captcha',            
            success: function(data) {
                $('.form-captcha > img').attr('src', data);
            }
        });
    });
    function checkYeuCauContent(){
        var str =  $('#content').val();
        if(str.trim().length < 6){
            $('.error-content').html('Vui lòng nhập tên phim chính xác, ít nhất 6 ký tự nhé');
            return false;
        }
    }
</script>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 
