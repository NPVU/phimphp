    <div class="container">
        <div class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="content-top col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <h5><strong style="color:#00a5ad">{{ config('app.name') }}</strong>&nbsp; chỉ vừa mới hoạt động, nên số lượng phim trên hệ thống còn hạn chế. Mong các bạn thông cảm!</h5>
                </div>
                @yield('contentTop')                
            </div>
            
            <div class="content-left col-xs-12 col-sm-12 col-md-8 col-lg-9">
                @yield('contentLeft')                
            </div>

            <div class="content-right col-xs-12 col-sm-12 col-md-4 col-lg-3">
                @yield('contentRight')                
            </div>
        </div>
    </div>