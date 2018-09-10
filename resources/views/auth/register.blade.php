@extends('layouts.app') 
@section('title')
    Đăng Ký
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">ĐĂNG KÝ</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form method="POST" action="{{ route('register') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            @csrf
            <div class="form-group">
                <label for="name" >Tên hiển thị</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="email" >Tài khoản (e-mail)</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                </div>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password" >Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-key"></span></span>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password-confirm" >Xác nhận mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-key"></span></span>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>                
                </div>
            </div>
            <div class="form-group form-captcha">
                <label for="captcha">Mã xác nhận</label>
                <?php echo $captcha?> <span class="glyphicon glyphicon-refresh btn-refresh-captcha"></span>
                <div class="input-group" style="margin-top:5px">
                    <span class="input-group-addon"><span class="fa fa-shield-alt"></span></span>
                    <input type="text" class="form-control" name="captcha" required>
                </div>
                @if ($errors->has('captcha'))
                    <span class="invalid-feedback">
                        <strong>Mã xác nhận không đúng</strong>
                    </span>
                @endif          
            </div>            
            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger">Đăng ký</button>              
            </div>
        </form>
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
