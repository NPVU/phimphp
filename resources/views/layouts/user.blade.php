<section class="npv-user" style="display: none;">
    <div class="npv-user-popup" style="width:300px; position: absolute; top: 55px; right: 10px; z-index: 1000;background: white;
         border-radius: 3px;">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:20px">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                <img src="{{ asset((Auth::user()->avatar)) }}" class="avatar img-circle" width="100%"/>                                
            </div>   
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <div style="font-size:18px;"><b class="username-popup" style="color:#777;font-family:'-webkit-body'">{{ Auth::user()->name }}</b></div>
                <div style="font-size:14px;color:gray">{{ Auth::user()->email }}</div>
            </div>                        
        </div>
        <div class="clearfix"></div>
        <div>
            <hr/> 
            <ul class="user-menu">
                <a href="javascript:void(0)" data-izimodal-open="#user-profile"><li>Thông tin cá nhân</li></a>                
                <a href="javascript:void(0)" data-izimodal-open="#user-password"><li>Đổi mật khẩu</li></a>
                @if(Session::has('roles')) 
                <a href="{{url('/quan-ly')}}"><li>Quản lý</li></a>
                @endif
                @guest
                @else
                <a href="javascript:void(0)"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <li>Thoát</li>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </ul>            
        </div>
    </div>
</section>
<div id="user-password" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center " >
                <span class="rs-pw" style="font-weight: 700;"></span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group pw1">  
                    <label>Mật khẩu cũ</label>
                    <input type="password" id="pw1" class="form-control required" />                                    
                    <span class="help-block pw1-error"></span>
                </div>
                
                <div class="form-group pw2">  
                    <label>Mật khẩu mới</label>
                    <input type="password" id="pw2" class="form-control required" />                                    
                    <span class="help-block pw2-error"></span>
                </div>
                
                <div class="form-group re-pw2">  
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" id="re-pw2" class="form-control required" />                                    
                    <span class="help-block re-pw2-error"></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-danger" onclick="changePassword()">Xác nhận</button>
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div id="user-profile" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center " >
                <span class="rs-profile" style="font-weight: 700;"></span>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">        
                <input type="file" id="avatar-file" class="display-none" onchange="autoUploadFile();$('.a-s, .a-c').removeClass('display-none');" />
                <a href="javascript:void(0)" onclick="$('#avatar-file').click();">
                    <img id="user-avatar" src="{{ asset((Auth::user()->avatar)) }}" width="100%" style="min-width:60px;min-height: 60px;max-width:120px"/>
                    <input type="hidden" id="avatar-before" value="{{ asset((Auth::user()->avatar)) }}" />                    
                </a>
                <div class="text-center" style="margin-top:10px">
                    <a href="javascript:void(0)" class="a-s btn btn-primary display-none" onclick="changeAvatar();" style="padding:6px 10px;"><i class="glyphicon glyphicon-check"></i> </a>
                    <a href="javascript:void(0)" class="a-c btn btn-danger display-none" onclick="$('.a-s, .a-c').addClass('display-none');$('#user-avatar').attr('src',$('#avatar-before').val());$('#avatar-file').val('');" style="padding:6px 10px;"> <i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">                
                <table class="table" style="background:white">
                    <tr>
                        <td class="text-left" style="width:20%"><label>Tài khoản</label></td>
                        <td class="text-left" style="width:60%"><label style="color:gray">{{Auth::user()->email}}</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width:20%"><label>Họ tên</label></td>
                        <td class="text-left" style="width:60%">
                            <label class="username" style="color:gray">{{Auth::user()->name}}</label>
                            <input type="text" id="username" class="display-none form-control" value="{{Auth::user()->name}}" name-before="{{Auth::user()->name}}" />
                        </td>
                        <td class="text-right" style="width:20%">
                            <a href="#" class="u-e btn" onclick="$('.u-s, .u-c, #username').removeClass('display-none');$('.u-e, .username').addClass('display-none')">Chỉnh sửa</a>
                            <a href="#" class="u-s btn display-none" onclick="changeUsername()">Lưu </a>
                            <a href="#" class="u-c btn display-none" onclick="$('.u-s, .u-c, #username').addClass('display-none');$('.u-e, .username').removeClass('display-none');$('.username').html($('#username').attr('name-before'));$('#username').val($('#username').attr('name-before'));"> Hủy</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width:20%"><label>Ngày sinh (mm/dd/yyyy)</label></td>
                        <td class="text-left" style="width:60%">
                            <label class="ns" style="color:gray">{{date_format(date_create(Auth::user()->birthday),"m/d/Y")}}</label>
                            <input type="date" id="ns" class="display-none form-control" value="{{date_format(date_create(Auth::user()->birthday),"Y-m-d")}}" ns-before="{{date_format(date_create(Auth::user()->birthday),"m/d/Y")}}" ns-value-before="{{date_format(date_create(Auth::user()->birthday),"Y-m-d")}}" />
                        </td>
                        <td class="text-right" style="width:20%">
                            <a href="#" class="ns-e btn" onclick="$('.ns-s, .ns-c, #ns').removeClass('display-none');$('.ns-e, .ns').addClass('display-none')">Chỉnh sửa</a>
                            <a href="#" class="ns-s btn display-none" onclick="changeBirthday()">Lưu </a>
                            <a href="#" class="ns-c btn display-none" onclick="$('.ns-s, .ns-c, #ns').addClass('display-none');$('.ns-e, .ns').removeClass('display-none');$('.ns').html($('#ns').attr('ns-before'));$('#ns').val($('#ns').attr('ns-value-before'));"> Hủy</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width:20%"><label>Giới tính</label></td>
                        <td class="text-left" style="width:60%">
                            <label class="gender" style="color:gray">{{Auth::user()->gender==1?'Nam':'Nữ'}}</label>
                            <select id="gender" class="display-none form-control" value="{{Auth::user()->gender}}" gender-before="{{Auth::user()->gender}}" gender-text-before="{{Auth::user()->gender==1?'Nam':'Nữ'}}">
                                <option value="0">Nữ</option>
                                <option value="1">Nam</option>
                            </select>                            
                        </td>
                        <td class="text-right" style="width:20%">
                            <a href="#" class="g-e btn" onclick="$('.g-s, .g-c, #gender').removeClass('display-none');$('.g-e, .gender').addClass('display-none')">Chỉnh sửa</a>
                            <a href="#" class="g-s btn display-none" onclick="changeGender()">Lưu </a>
                            <a href="#" class="g-c btn display-none" onclick="$('.g-s, .g-c, #gender').addClass('display-none');$('.g-e, .gender').removeClass('display-none');$('.gender').html($('#gender').attr('gender-text-before'));$('#gender').val($('#gender').attr('gender-before'));"> Hủy</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width:20%"><label>Phone</label></td>
                        <td class="text-left" style="width:60%">
                            <label class="phone" style="color:gray">{{Auth::user()->phone}}</label>
                            <input type="text" id="phone" class="display-none form-control" value="{{Auth::user()->phone}}" phone-before="{{Auth::user()->phone}}" />
                        </td>
                        <td class="text-right" style="width:20%">
                            <a href="#" class="p-e btn" onclick="$('.p-s, .p-c, #phone').removeClass('display-none');$('.p-e, .phone').addClass('display-none')">Chỉnh sửa</a>
                            <a href="#" class="p-s btn display-none" onclick="changePhone()">Lưu </a>
                            <a href="#" class="p-c btn display-none" onclick="$('.p-s, .p-c, #phone').addClass('display-none');$('.p-e, .phone').removeClass('display-none');$('.phone').html($('#phone').attr('phone-before'));$('#phone').val($('#phone').attr('phone-before'));$('#phone').css('color','gray');"> Hủy</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">                
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('public/js/user.min.js') }}"></script>
