<div id="user-login" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center " >
                <span class="rs-login" style="font-weight: 700;"></span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">  
                    <label>Tài khoản (Email)</label>
                    <input type="email" id="user-login-email" class="form-control required" required="true"/>                                    
                    <span class="help-block"></span>
                </div>
                
                <div class="form-group">  
                    <label>Mật khẩu</label>
                    <input type="password" id="user-login-password" class="form-control required" required="true" />                                    
                    <span class="help-block"></span>
                </div>                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-danger user-login-btn">Đăng nhập</button>
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#user-login').iziModal({
        title: 'Đăng nhập',
        top: 100,
        overlayClose: true,                
        width: 600,
        openFullscreen:false,
        headerColor: 'rgb(56, 98, 111)',
        icon: 'fa fa-sign-in',
        iconColor: 'white',
        onOpening: function(){
            $('#user-login-email').val('');
            $('#user-login-password').val('');
        }
    });
    function openLogin(){
        $('#user-login').iziModal('open');
    }
    $('.user-login-btn').click(function(e){
        e.preventDefault();
        login();
    });
    $('#user-login').keyup(function(e){
        if(e.keyCode == 13)
        {
            login();
        }
    });
    function login(){
        var e = $('#user-login-email').val();
        var p = $('#user-login-password').val();        
        $.ajax({
            type: "POST",
            url: "{{url('/login')}}",
            data: {email: e, password: p, _token:$('meta[name="csrf-token"]').attr('content')},
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            success: function(data) {
                $('#user-login').iziModal('close');
                $("#comment").load(location.href+" #comment>*","");
                $(".header").load(location.href+" .header>*","");
                $("#modal-user").load(location.href+" #modal-user>*",function() {
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
                        zindex: 1001
                    });
                });                         
                $(".danh-gia").load(location.href+" .danh-gia>*",function() {                                        
                    $('.rate').attr('data-rate-value',{{isset($star)?$star:3}});
                    $('.rate-select-layer').css('width', 20*{{isset($star)?$star:3}}+'%');
                    $(".rate").rate();
                });
            },                                    
            error: function(XMLHttpRequest, textStatus, errorThrown) {                
                var json = JSON.parse(XMLHttpRequest.responseText);                
                $('.rs-login').css('color','red');
                $('.rs-login').html(json.errors.email);
             }
        });
    }
</script>