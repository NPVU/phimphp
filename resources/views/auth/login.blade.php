@extends('layouts.app') 
@section('title')
    Đăng Nhập 
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">ĐĂNG NHẬP</h2>
    </div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form method="POST" action="{{ route('login') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
        @csrf
        <div class="form-group">
            <label for="email">Tài khoản (e-mail)</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>        

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ
                </label>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-danger">
                Đăng nhập
            </button>

            <a class="btn btn-link" href="{{ route('password.request') }}">
                Quên mật khẩu
            </a>
        </div>
    </form>
</div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 