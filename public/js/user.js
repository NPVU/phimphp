$('#user-notification').iziModal({
    title: 'Thông báo',
    top: 100,
    overlayClose: true,                
    width: 600,
    openFullscreen:false,
    headerColor: '#263238',
    icon: 'fa fa-bell',
    iconColor: 'white',
    zindex: 1001
});
$('#user-password').iziModal({
    title: 'Đổi mật khẩu',
    top: 100,
    overlayClose: true,                
    width: 600,
    openFullscreen:false,
    headerColor: '#263238',
    icon: 'glyphicon glyphicon-password',
    iconColor: 'white',
    zindex: 1001,
    onOpening: function(){
        $('#pw1').val('');$('.pw1').removeClass('has-error');$('.pw1-error').html('');
        $('#pw2').val('');$('.pw2').removeClass('has-error');$('.pw2-error').html('');
        $('#re-pw2').val('');$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');
        $('.rs-pw').html('');$('.rs-pw').removeClass('glyphicon-check');$('.rs-pw').removeClass('glyphicon-close');
    }
});$('#user-profile').iziModal({
    title: 'Thông tin tài khoản',
    top: 100,
    overlayClose: true,                
    width: 800,
    openFullscreen:false,
    headerColor: '#263238',
    icon: 'glyphicon glyphicon-user',
    iconColor: 'white',
    zindex: 1001
});
function changePassword(){var pw1 = $('#pw1').val();var pw2 = $('#pw2').val();var repw2 = $('#re-pw2').val();var valid = true;if(pw1===""){$('.pw1').addClass('has-error');$('.pw1-error').html('Mật khẩu cũ không được bỏ trống');valid = false;}else if(pw1.length < 6){$('.pw1').addClass('has-error');$('.pw1-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.pw1').removeClass('has-error');$('.pw1-error').html('');}if(pw2===""){$('.pw2').addClass('has-error');$('.pw2-error').html('Mật khẩu mới không được bỏ trống');valid = false;}else if(pw2.length < 6){$('.pw2').addClass('has-error');$('.pw2-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.pw2').removeClass('has-error');$('.pw2-error').html('');}if(repw2===""){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Xác nhận mật khẩu không được bỏ trống');valid = false;}else if(repw2.length < 6){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Mật khẩu có ít nhất 6 ký tự');valid = false;}else{$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');}if(valid){if(pw2!==repw2){$('.re-pw2').addClass('has-error');$('.re-pw2-error').html('Xác nhận mật khẩu không trùng khớp');valid = false;}else{$('.re-pw2').removeClass('has-error');$('.re-pw2-error').html('');}}if(valid){$.ajax({type: "GET",url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/change-password/'+$('#current-token').val()+"/" + pw1 + "/" + pw2,success: function (data) {if (data.status === 1) {$('.rs-pw').css('color','green');$('.rs-pw').removeClass('fa fa-close');$('.rs-pw').addClass('fa fa-check');$('.rs-pw').html(' '+data.msg);$('#pw1').val('');$('#pw2').val('');$('#re-pw2').val('');} else if (data.status === 0) {$('.rs-pw').css('color','red');$('.rs-pw').addClass('fa fa-close');$('.rs-pw').html(' '+data.msg);}}});}}    
function changeUsername() {
    $.ajax({
        type: "GET",
        url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/change-display-name/'+$('#current-token').val()+"/" + $('#username').val(),
        success: function (data) {
            if (data.status === 1) {
                $('.username').html($('#username').val());$('#username').attr('name-before',$('#username').val());
                $('#username, .u-s, .u-c').addClass('display-none');$('.username, .u-e').removeClass('display-none');
            }
        }
    });
}

function changeBirthday() {
    $.ajax({
        type: "GET",
        url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/change-birthday/'+$('#current-token').val()+"/" + $('#ns').val(),
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
        url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/change-gender/'+$('#current-token').val()+"/" + $('#gender').val(),
        success: function (data) {
            if (data.status === 1) {
                $('.gender').html(data.text);$('#gender').attr('gender-before',data.msg);$('#gender').attr('gender-text-before',data.text);
                $('#gender, .g-s, .g-c').addClass('display-none');$('.gender, .g-e').removeClass('display-none');
            }
        }
    });
}function changePhone() {
    if($('#phone').val().length >= 10){
        $('#phone').css('color','gray');
        $.ajax({
            type: "GET",
            url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/change-phone/'+$('#current-token').val()+"/" + $('#phone').val(),
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
            url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/upload-avatar',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('#current-token').val()
            },
            success: function (data) {                    
                $('#user-avatar').attr('src', $('meta[name="url"]').attr('content')+'/'+data);                    
            }
    });
}
function changeAvatar() {        
    $.ajax({
        type: "GET",
        url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/change-avatar/'+$('#current-token').val()+'/',
        success: function (data) {
           if (data.status === 1) {
                $('#user-avatar, .avatar').attr('src', $('meta[name="url"]').attr('content')+'/'+data.msg);
                $('.a-s, .a-c').addClass('display-none');$('#avatar-before').val($('meta[name="url"]').attr('content')+'/'+data.msg);
            }
        }
    });        
}