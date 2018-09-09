@extends('layouts.app') 
@section('title')
    Mật Khẩu Mới
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">ĐẶT MẬT KHẨU MỚI</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form method="POST" action="{{ route('password.request') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">Tài khoản (e-mail)</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password-confirm">Xác nhận mật khẩu mới</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>                
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger">
                    {{ __('Reset Password') }}
                </button>                
            </div>
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 
