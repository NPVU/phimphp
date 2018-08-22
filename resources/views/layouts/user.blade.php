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
            <button type="button" class="btn btn-primary" style="width: 120px; float: left" data-izimodal-open="#user-profile">Profile</button>
            <button type="button" class="btn btn-primary" style="width: 120px; float: right" data-izimodal-open="#user-password">Đổi mật khẩu</button>
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
            <div class="col-xs-5 col-sm-3 col-md-3 col-lg-3">        
                <input type="file" id="avatar-file" class="display-none" onchange="autoUploadFile();$('.a-s, .a-c').removeClass('display-none');" />
                <a href="#" onclick="$('#avatar-file').click();">
                    <img id="user-avatar" src="{{ asset((Auth::user()->avatar)) }}" width="100%" style="min-width:60px;min-height: 60px;"/>
                    <input type="hidden" id="avatar-before" value="{{ asset((Auth::user()->avatar)) }}" />                    
                </a>
                <div class="text-center" style="margin-top:10px">
                    <a href="#" class="a-s btn btn-primary display-none" onclick="changeAvatar();"><i class="fa fa-check"></i> </a>
                    <a href="#" class="a-c btn btn-danger display-none" onclick="$('.a-s, .a-c').addClass('display-none');$('#user-avatar').attr('src',$('#avatar-before').val());$('#avatar-file').val('');"> <i class="fa fa-close"></i></a>
                </div>
            </div>
            <div class="col-xs-7 col-sm-9 col-md-9 col-lg-9">                
                <table class="table">
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
                            <a href="#" class="p-c btn display-none" onclick="$('.p-s, .p-c, #phone').addClass('display-none');$('.p-e, .phone').removeClass('display-none');$('.phone').html($('#phone').attr('phone-before'));$('#phone').val($('#phone').attr('phone-before'));$('#phone').css('color','unset');"> Hủy</a>
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

<script>
    $('#user-password').iziModal({
        title: 'Đổi mật khẩu',
        top: 100,
        overlayClose: true,                
        width: 600,
        openFullscreen:false,
        headerColor: 'rgb(56, 98, 111)',
        icon: 'fa fa-password',
        iconColor: 'white',
        onOpening: function(){
            $('#pw1').val('');$('.pw1').removeClass('has-error');$('.pw1-error').html('');
            $('#pw2').val('');$('.pw2').removeClass('has-error');$('.pw2-error').html('');
            $('#re-pw2').val('');$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');
            $('.rs-pw').html('');$('.rs-pw').removeClass('fa-check');$('.rs-pw').removeClass('fa-close');
        }
    });$('#user-profile').iziModal({
        title: 'Thông tin tài khoản',
        top: 100,
        overlayClose: true,                
        width: 800,
        openFullscreen:false,
        headerColor: 'rgb(56, 98, 111)',
        icon: 'fa fa-user',
        iconColor: 'white',
        zindex: 1001,        
        onClosing: function (modal) {
//            window.location.reload();         
        }
    });function changePassword(){var pw1 = $('#pw1').val();var pw2 = $('#pw2').val();var repw2 = $('#re-pw2').val();var valid = true;if(pw1===""){$('.pw1').addClass('has-error');$('.pw1-error').html('Mật khẩu cũ không được bỏ trống');valid = false;}else if(pw1.length < 6){$('.pw1').addClass('has-error');$('.pw1-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.pw1').removeClass('has-error');$('.pw1-error').html('');}if(pw2===""){$('.pw2').addClass('has-error');$('.pw2-error').html('Mật khẩu mới không được bỏ trống');valid = false;}else if(pw2.length < 6){$('.pw2').addClass('has-error');$('.pw2-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.pw2').removeClass('has-error');$('.pw2-error').html('');}if(repw2===""){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Xác nhận mật khẩu không được bỏ trống');valid = false;}else if(repw2.length < 6){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');}if(valid){if(pw2!==repw2){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Xác nhận mật khẩu không trùng khớp');valid = false;}else{$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');}}if(valid){$.ajax({type: "GET",url: "{{url('/quan-ly/tai-khoan/change-password')}}/{{csrf_token()}}/" + pw1 + "/" + pw2,success: function (data) {if (data.status === 1) {$('.rs-pw').css('color','green');$('.rs-pw').removeClass('fa fa-close');$('.rs-pw').addClass('fa fa-check');$('.rs-pw').html(' '+data.msg);$('#pw1').val('');$('#pw2').val('');$('#re-pw2').val('');} else if (data.status === 0) {$('.rs-pw').css('color','red');$('.rs-pw').addClass('fa fa-close');$('.rs-pw').html(' '+data.msg);}}});}}    
    function changeUsername() {
        $.ajax({
            type: "GET",
            url: "{{url('/quan-ly/tai-khoan/change-display-name')}}/{{csrf_token()}}/" + $('#username').val(),
            success: function (data) {
                if (data.status === 1) {
                    $('.username').html($('#username').val());$('#username').attr('name-before',$('#username').val());
                    $('#username, .u-s, .u-c').addClass('display-none');$('.username, .u-e').removeClass('display-none');
                }
            }
        });
    }
    function changeUsername() {
        $.ajax({
            type: "GET",
            url: "{{url('/quan-ly/tai-khoan/change-display-name')}}/{{csrf_token()}}/" + $('#username').val(),
            success: function (data) {
                if (data.status === 1) {
                    $('.username').html($('#username').val());$('#username').attr('name-before',$('#username').val());
                    $('#username, .u-s, .u-c').addClass('display-none');$('.username, .u-e').removeClass('display-none');
                }
            }
        });
    }function changeBirthday() {
        $.ajax({
            type: "GET",
            url: "{{url('/quan-ly/tai-khoan/change-birthday')}}/{{csrf_token()}}/" + $('#ns').val(),
            success: function (data) {
                if (data.status === 1) {
                    $('.ns').html(data.msg);$('#ns').attr('ns-before',data.msg);$('#ns').attr('ns-value-before',data.value);
                    $('#ns, .ns-s, .ns-c').addClass('display-none');$('.ns, .ns-e').removeClass('display-none');
                }
            }
        });
    }function changeGender() {
        $.ajax({
            type: "GET",
            url: "{{url('/quan-ly/tai-khoan/change-gender')}}/{{csrf_token()}}/" + $('#gender').val(),
            success: function (data) {
                if (data.status === 1) {
                    $('.gender').html(data.text);$('#gender').attr('gender-before',data.msg);$('#gender').attr('gender-text-before',data.text);
                    $('#gender, .g-s, .g-c').addClass('display-none');$('.gender, .g-e').removeClass('display-none');
                }
            }
        });
    }function changePhone() {
        if($('#phone').val().length >= 10){
            $('#phone').css('color','unset');
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/tai-khoan/change-phone')}}/{{csrf_token()}}/" + $('#phone').val(),
                success: function (data) {
                    if (data.status === 1) {
                        $('.phone').html($('#phone').val());$('#phone').attr('phone-before',$('#phone').val());
                        $('#phone, .p-s, .p-c').addClass('display-none');$('.phone, .p-e').removeClass('display-none');
                    }
                }
            });
        }else{
            $('#phone').css('color','red');
        }
    }
    function autoUploadFile() {        
        var file_data = $('#avatar-file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('avatar', file_data);
        $.ajax({
                url: '{{url("quan-ly/tai-khoan/upload-avatar")}}',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {                    
                    $('#user-avatar').attr('src', '{{url("/")}}/'+data);                    
                }
        });
    }
    function changeAvatar() {        
        $.ajax({
            type: "GET",
            url: "{{url('/quan-ly/tai-khoan/change-avatar')}}/{{csrf_token()}}/",
            success: function (data) {
               if (data.status === 1) {
                    $('#user-avatar').attr('src', '{{asset("")}}'+data.msg);
                    $('.a-s, .a-c').addClass('display-none');$('#avatar-before').val('{{asset("")}}'+data.msg);
                }
            }
        });        
    }
</script>
