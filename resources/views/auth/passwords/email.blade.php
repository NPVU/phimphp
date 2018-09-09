@extends('layouts.app') 
@section('title')
    Lấy Lại Mật Khẩu 
@endsection 
@section('contentLeft')
<div class="content-left-section">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">LẤY LẠI MẬT KHẨU</h2>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form method="POST" action="{{ route('password.email') }}" class="col-sm-offset-3 col-sm-6 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            @csrf
            <div class="form-group">
                <label for="email">Tài khoản (e-mail)</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
            </div>                   

                            
        </form>
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 
