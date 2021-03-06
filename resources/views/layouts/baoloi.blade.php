@extends('layouts.app') 
@section('title')
    Báo Lỗi 
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">BÁO LỖI</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @if(empty($reported))
        <form method="POST" action="{{ url('bao-loi') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            @csrf
            <div class="form-group">
                <label for="url" >URL lỗi</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-link"></span></span>
                    <input id="url" type="text" class="form-control" name="url" value="" required autofocus placeholder="Nhập vào URL bị lỗi">
                </div>                
            </div>
            <div class="form-group">
                <label for="content" >Mô tả lỗi</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                    <textarea id="content" name="content" class="form-control" required rows="5">

                    </textarea>
                </div>                
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
                <button type="submit" class="btn btn-danger">Báo lỗi</button>              
            </div>
        </form>
        @else
            <div class="text-center" style="color:#14cc5e">
                <span class="fa fa-2x fa-check-circle"></span>
                <h4>Báo lỗi thành công, cảm ơn bạn đã nhiệt tình hỗ trợ&nbsp;{{ config('app.name') }}.</h4>
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
</script>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 
