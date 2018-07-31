/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#modal-avatar').iziModal({
    overlayClose: false,
    width: 500,
    headerColor: 'rgb(56, 98, 111)',
    icon: 'fa fa-image',
    iconColor: 'white',
    zindex:10000,
    onOpening: function (modal) {
        $('#imgDragDrop').removeClass('display-none');
        $('#btnReUploadAvatar').addClass('display-none');
        $('.box-avatar').addClass('display-none');
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
    icon: 'fa fa-user',
    iconColor: 'white',    
    onClosing: function (modal) {
        $('.notify-change-display-username-error').addClass('display-none');
        $('#txtDisplayUserName').val($('.displayUserName').html());
    }
});
$('#modal-name').iziModal('setTitle', 'Thay đổi tên hiển thị');
$('#modal-name').iziModal('setTop', 100);

$('#modal-password').iziModal({
    overlayClose: false,
    headerColor: 'rgb(56, 98, 111)',
    icon: 'fa fa-key',
    iconColor: 'white',    
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
