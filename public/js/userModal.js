/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#modal-avatar').iziModal({
    overlayClose: false,
    width: 500,
    headerColor: 'rgb(56, 98, 111)',
    onOpening: function (modal) {
        modal.startLoading();
        $('#imgDragDrop').removeClass('display-none');
        $('#btnReUploadAvatar').addClass('display-none');
        $('.boxAvatar').addClass('display-none');
    },
    onOpened: function (modal) {
        modal.stopLoading();
    },
    onClosing: function (modal) {
        $('.notify-change-avatar-error').addClass('display-none');
    }
});
$('#modal-avatar').iziModal('setTitle', 'Thay đổi ảnh đại diện');
$('#modal-avatar').iziModal('setTop', 100);

$('#modal-name').iziModal({
    overlayClose: false,
    headerColor: 'rgb(56, 98, 111)',
    onOpening: function (modal) {
        modal.startLoading();
    },
    onOpened: function (modal) {
        modal.stopLoading();
    },
    onClosing: function (modal) {
        $('.notify-change-display-username-error').addClass('display-none');
        $('#txtDisplayUserName').val($('.displayUserName').html());
    }
});
$('#modal-name').iziModal('setTitle', 'Thay đổi tên hiển thị');

$('#modal-password').iziModal({
    overlayClose: false,
    headerColor: 'rgb(56, 98, 111)',
    onOpening: function (modal) {
        modal.startLoading();
    },
    onOpened: function (modal) {
        modal.stopLoading();
    },
    onClosing: function (modal) {
        $('#oldPassword').val('');
        $('#newPassword').val('');
        $('#renewPassword').val('');
        $('.notify-change-password-success').addClass('display-none');
        $('.notify-change-password-error').addClass('display-none');
        $('.renew-password').removeClass('has-error');
        $('.msg_renewpassword_error').html('');
    }
});
$('#modal-password').iziModal('setTitle', 'Thay đổi mật khẩu');
$('#modal-password').iziModal('setTop', 100);

function updateDisplayUserName() {
    $.ajax({
        type: "GET",
        url: "{{url('/quan-ly/tai-khoan/doi-ten-hien-thi')}}/{{csrf_token()}}/" + $('#txtDisplayUserName').val(),
        success: function (data) {
            if (data.status === 1) {
                $('.displayUserName').html(data.msg);
                $('#modal-name').iziModal('close');
            } else if (data.status === 0) {
                $('.msg-change-display-username-error').html(data.msg);
                $('.notify-change-display-username-error').removeClass('display-none');
            }
        }
    });
}
function updateChangePassword() {
    $.ajax({
        type: "GET",
        url: "{{url('/quan-ly/tai-khoan/doi-mat-khau')}}/{{csrf_token()}}/" + $('#oldPassword').val() + "/" + $('#newPassword').val(),
        success: function (data) {
            console.log(data);
            if (data.status === 1) {
                $('.notify-change-password-error').addClass('display-none');
                $('.notify-change-password-success').removeClass('display-none');
            } else if (data.status === 0) {
                $('.notify-change-password-success').addClass('display-none');
                $('.msg-change-password-error').html(data.msg);
                $('.notify-change-password-error').removeClass('display-none');
            }
        }
    });
}
function validForm() {
    $('.renew-password').removeClass('has-error');
    $('.msg_renewpassword_error').html('');
    if ($('#newPassword').val() === $('#renewPassword').val()) {
        updateChangePassword();
    } else {
        $('.renew-password').addClass('has-error');
        $('.msg_renewpassword_error').html('Xác nhận mật khẩu không khớp');
    }
}

function autoUploadFile() {
    var file_data = $('#selectFileAvatar').prop('files')[0];
    var form_data = new FormData();
    form_data.append('avatar', file_data);
    $.ajax({
        url: '{{url("quan-ly/tai-khoan/upload-avatar")}}', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (php_script_response) {
            $('#imgDragDrop').addClass('display-none');
            $('#btnReUploadAvatar').removeClass('display-none');
            $('#imgAfterUpload').attr('src', php_script_response);
            $('.boxAvatar').removeClass('display-none');
        }
    });
}
function updateChangeAvatar() {
    $.ajax({
        type: "GET",
        url: "{{url('/quan-ly/tai-khoan/doi-avatar')}}/{{csrf_token()}}",
        success: function (data) {
            console.log(data);
            if (data.status === 1) {
                $('.avatar').attr('src', data.msg);
                $('#modal-avatar').iziModal('close');
            } else if (data.status === 0) {

            }
        }
    });
}