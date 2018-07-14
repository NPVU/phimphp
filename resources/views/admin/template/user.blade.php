<div id="modal-avatar" data-izimodal-transitionin="fadeInDown">
    <div class="modal-body">        
        <div class="row">
            <div class="col-md-12 form-group notify-change-avatar-error has-error display-none">
                   <label class="control-label">
                       <i class="fa fa-times-circle-o"></i>
                       <span class="msg-change-avatar-error"></span>
                   </label>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                    
                <input type="file" name="avatar" class="form-control display-none" id="selectFileAvatar" onchange="autoUploadFile()"/>
                <div class="boxUpdateAvatar text-center">
                    <img src="{{asset('public/img/themes/jquery-file-upload-scripts.png')}}" width="80%"
                         onclick="$('#selectFileAvatar').click()" 
                         class="img-select-file" id="imgDragDrop" ondrop="onDropFile();" ondrag="true"/>
                    <div class="boxAvatar">
                        <img id="imgAfterUpload" class="img-circle" width="100px"/>
                    </div>                    
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px">
                <button type="button" class="btn btn-danger" onclick="updateChangeAvatar();">Cập nhật</button>
                <button type="button" class="btn btn-primary display-none" id="btnReUploadAvatar" onclick="$('#selectFileAvatar').click()"><i class="fa fa-refresh" ></i> Chọn lại</button>
            </div>
        </div>        
    </div>
</div>
<div id="modal-name" data-izimodal-transitionin="fadeInDown">
    <div class="modal-body">        
        <div class="row">
            <div class="col-md-12 form-group notify-change-display-username-error has-error display-none">
                   <label class="control-label">
                       <i class="fa fa-times-circle-o"></i>
                       <span class="msg-change-display-username-error"></span>
                   </label>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8">
                <input type="text" id="txtDisplayUserName" class="form-control" value="{{ Auth::user()->name }}" />
            </div>
            <div class="col-xs-2 col-sm-2 col-md-4 col-lg-4">
                <button type="button" class="btn btn-danger" onclick="updateDisplayUserName()">Cập nhật</button>
            </div>
        </div>        
    </div>
</div>
<div id="modal-password" data-izimodal-transitionin="fadeInDown">
    <div class="modal-body">        
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3"></div>
                <div class="col-md-6 form-group notify-change-password-success has-success display-none">
                   <label class="control-label">
                       <i class="fa fa-check"></i>
                       Thay đổi mật khẩu thành công !
                   </label>
                </div>
                <div class="col-md-6 form-group notify-change-password-error has-error display-none">
                   <label class="control-label">
                       <i class="fa fa-times-circle-o"></i>
                       <span class="msg-change-password-error"></span>
                   </label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label>Mật khẩu cũ</label>
                    <input type="password" id="oldPassword" class="form-control required" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label>Mật khẩu mới</label>
                    <input type="password" id="newPassword" class="form-control required" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3"></div>
                <div class="col-md-6 renew-password">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" id="renewPassword" class="form-control required" />
                    <span class="help-block msg_renewpassword_error"></span>
                </div>
            </div>
            <div class="col-md-12 text-center" style="margin-top:20px">
                <button type="button" class="btn btn-danger" onclick="validForm()">Đổi mật khẩu</button>
            </div>
        </div>        
    </div>
</div>
<script type="text/javascript" src="{{ asset('public/js/userModal.js') }}"></script>
<script>
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
</script>