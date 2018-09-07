<!DOCTYPE html><html lang="{{ app()->getLocale() }}">
@include('layouts.head_min')
<body> @include('layouts.header_min')
    @include('layouts.container_min')
    <div id="modal-user">
        <input type="hidden" id="current-token" value="{{csrf_token()}}"/>
        @if (Auth::check())    
        @include('layouts.user_min')  
        @else
        @include('layouts.login_min')
        @endif
    </div>
    @yield('video')    
    @if (session('backURL'))        
        @include('layouts.backURL')
        <?php Session::forget('backURL'); ?>
    @endif </body></html>
