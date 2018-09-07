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
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="email" >Tài khoản (Email)</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password" >{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>                
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger">Đăng ký</button>              
            </div>
        </form>
    </div>
</div>
@endsection 
