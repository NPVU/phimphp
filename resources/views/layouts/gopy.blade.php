@extends('layouts.app') 
@section('title')
    Góp Ý 
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">GÓP Ý</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @if(empty($reported))
        <form method="POST" action="{{ url('gop-y') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            @csrf            
            <div class="form-group">
                <label for="content" >Nội dung góp ý</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                    <textarea id="content" name="content" class="form-control" required rows="5" minlength="10">

                    </textarea>
                </div> 
                <span class="invalid-feedback content-feedback-message display-none">
                    <strong>Vui lòng nhập nội dung góp ý ạ.</strong>
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
                <button type="submit" class="btn btn-danger" onclick="return checkContentFeedback();">Góp ý</button>              
            </div>
        </form>
        @else
            <div class="text-center" style="color:#14cc5e">
                <span class="fa fa-2x fa-check-circle"></span>
                <h4>Chúng tôi đã ghi nhận ý kiến của bạn, cảm ơn bạn đã ủng hộ&nbsp;{{ config('app.name') }}.</h4>
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
    function checkContentFeedback(){
        $('.content-feedback-message').addClass('display-none');
        if($('#content').val().length < 2){
            $('.content-feedback-message').removeClass('display-none');
            return false;
        }
    }
</script>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 
