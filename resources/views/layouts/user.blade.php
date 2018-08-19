<section class="npv-user" style="display: none;">
    <div class="npv-user-popup" style="width:300px; position: absolute; top: 60px; right: 0px; z-index: 1000;background: white;
         border-radius: 3px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:20px">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                <img src="{{ asset((Auth::user()->avatar)) }}" class="avatar img-circle" width="100%"/>                                
            </div>   
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <span style="font-size:18px;"><b>{{ Auth::user()->name }}</b></span>
                <span style="font-size:14px;color:gray">{{ Auth::user()->email }}</span>
            </div>                        
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:20px;">
            <hr/>            
            <button type="button" class="btn btn-primary" style="width: 120px; float: left">Profile</button>
            <button type="button" class="btn btn-primary" style="width: 120px; float: right">Đổi mật khẩu</button>
        </div>
    </div>
</section>
