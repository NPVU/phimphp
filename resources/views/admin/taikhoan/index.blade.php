<style>
    .row-super-admin{
        background-color: #f35959;
        color: white;
        opacity: 0.9;
    }
    .row-admin {
        background-color: #d2cc19;
        color: white;
        opacity: 0.9;
    }
    .row-super-admin:hover {
        background-color: #f35959 !important;
        opacity: 1;
    }
    .row-admin:hover {
        background-color: #d2cc19 !important;
        opacity: 1;
    }
</style>
<section class="content-header">
    <h1>
        QUẢN LÝ TÀI KHOẢN
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/tai-khoan') }}">Quản lý tài khoản</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách tài khoản</h3>                                                                          
                </div>                
                <div class="box-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                        <div class="box-btn-header" style="float:right;">
                            <form method="GET">
                            <div class="form-search-addon">
                                <div class="input-group">
                                    <input type="search" name="tukhoa" value="<?php echo isset($_GET['tukhoa'])?$_GET['tukhoa']:''; ?>" placeholder="Nhập từ khóa cần tìm ..." class="form-control" />
                                    <span class="input-group-addon" style="cursor: pointer" onclick="$('#btn-search-taikhoan').click();"><i class="fa fa-search"></i></span>
                                    <span class="input-group-addon" style="cursor: pointer" onclick="window.location.href = '{{url('/quan-ly/tai-khoan')}}';"><i class="fa fa-refresh"></i></span>
                                    <button type="submit" id="btn-search-taikhoan" class="display-none"></button>
                                </div>         
                            </div>
                            </form>
                        </div>     
                    </div>                
                    <table class="table table-hover">
                        <caption>
                            <span>Tổng: {{$count}}</span>
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 5%">#</th>                                
                                <th scope="col" class="text-left" style="width: 25%">Email</th>
                                <th scope="col" class="text-left" style="width: 25%">Tên hiển thị</th>
                                <th scope="col" class="text-center" style="width: 10%">Ngày tạo</th>                                
                                <th scope="col" class="text-center" style="width: 10%">Trạng thái</th>
                                <th scope="col" class="text-center" style="width: 15%"></th>
                            </tr>
                        </thead>
                        <tbody id="body-table">
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listUser as $row)
                            <tr id="row{{$row->id}}" class="{{$row->role_code!=null?$row->role_code==RoleUtils::getRoleSuperAdmin()?'row-super-admin':'row-admin':''}}">
                                <td class="text-center" style="cursor:pointer;">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>                                
                                <td>
                                    {{$row->email}}
                                </td>
                                <td>
                                    {{$row->name}}
                                </td>                                                                                                                             
                                <td class="text-center">
                                    <?php 
                                        $date = date_create($row->created_at);
                                        echo date_format($date, 'd-m-Y');
                                    ?>
                                </td>                                
                                <td class="text-center">
                                    <?php echo $row->active==1?'Hoạt động':'Bị khóa';?>
                                </td>
                                <td class="text-center">
                                    @if($row->role_code != RoleUtils::getRoleSuperAdmin())
                                    <div class="list-action-icon"> 
                                        <span data-toggle="tooltip" title="Quyền truy cập" onclick="preActionRole({{$row->id}}, '{{$row->email}}')">
                                            <i class="fa fa-user-secret text-light-blue"></i>
                                        </span>
                                        <span data-toggle="tooltip" title="Xem tất cả bình luận của tài khoản này" onclick="showAllComment({{$row->id}})">
                                            <i class="fa fa-comments text-light-blue"></i>
                                        </span>
                                        @if ($row->active==1)
                                        <span data-toggle="tooltip" title="Khóa" onclick="preLock({{$row->id}}, '{{$row->email}}')">
                                            <i class="fa fa-lock text-light-red"></i>
                                        </span>
                                        @else
                                        <span data-toggle="tooltip" title="Mở khóa" onclick="unlock({{$row->id}}, '{{$row->email}}')">
                                            <i class="fa fa-unlock text-light-blue"></i>
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <?php if($rowIndex == 0) :?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    Không tìm thấy dữ liệu
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <td colspan="7">
                                    {{ $listUser->appends(['tukhoa' => Request::get('tukhoa')])->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>                              
            </div>            
        </div>        
    </div>    
    <div id="modal-verify" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/tai-khoan/lock')}}">
            {{csrf_field()}}
            <input type="hidden" id="verify_user_id" name="user_id" value="" />
            <input type="hidden" id="verify_email" name="email" value="" />            
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-center">
                        Bạn có đồng ý khóa tài khoản 
                        <strong style="color: lightseagreen;font-size: 1em;" class="verify_email"></strong>
                        không ?
                    </div>
                    <div class="col-md-12">
                        <div class="form-group reason">
                            <label class="control-label" for="reason">Lý do</label>
                            <input type="text" id="reason" name="reason" 
                                   class="form-control required" value=""
                                   placeholder="Nhập lý do khóa account"/>
                            <span class="help-block reason-error"></span>
                        </div>                        
                    </div>
                    <div class="col-md-12 text-center" style="margin-top:20px">
                        <button type="submit" class="btn btn-danger" onclick="return checkReason();">Đồng ý</button>
                        <button type="button" class="btn btn-default" data-izimodal-close="">Hủy bỏ</button>
                    </div>
                </div>        
            </div>
        </form>        
    </div>
    <form id="formUnlock" method="POST" action="{{url('quan-ly/tai-khoan/unlock')}}" style="display: none">
        {{csrf_field()}}
        <input type="hidden" id="unlock_user_id" name="user_id" value="" />
        <input type="hidden" id="unlock_email" name="email" value="" />                        
    </form>
    <div id="modal-role" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/tai-khoan/role')}}">
            {{csrf_field()}}
            <input type="hidden" id="role_user_id" name="user_id" value="" />
            <input type="hidden" id="role_email" name="email" value="" />            
            <div class="modal-body">        
                <div class="row" id="body-role">                
                    <div class="col-md-12 text-center">
                        @foreach ($listRole as $row)
                        @if($row->role_code != RoleUtils::getRoleSuperAdmin())
                        <div class="input-group margin-bottom">                                                        
                            <input type="text" class="form-control input-role-{{$row->role_code}}" value="{{$row->role_name}}" disabled="true">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary role-{{$row->role_code}}" onclick="actionRole({{$row->role_code}});">
                                    Thêm
                                </button>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    <div class="col-md-12 text-center" style="margin-top:20px">                        
                        <button type="button" class="btn btn-default" data-izimodal-close="">Đóng</button>
                    </div>
                </div>        
            </div>
        </form>        
    </div>
    <div id="modal-all-comment" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/tai-khoan/delete-comment')}}">
            {{csrf_field()}}
            <input type="hidden" id="cid" name="cid" value="" />                    
            <div class="modal-body" style="padding: 20px">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        Dang xay dung
                        <table class="table no-border" style="margin-bottom:0px">
                            <tr>
                                <td style="width:120px;" class="text-center">
                                    <img class="action-comment-avatar avatar img-circle" src="" width="100%" />
                                </td>
                                <td class="text-left">
                                    <div class="action-comment-username" style="font-weight: 700"></div>
                                    <div class="action-comment-content content-comment"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">                                                
                        <button class="btn btn-default" data-izimodal-close="">Đóng</button>
                    </div>
                </div>
            </div>
        </form>        
    </div>
    <script>        
        $('#modal-verify').iziModal({
            title: 'Xác nhận',
            top: 100,
            overlayClose: false,
            width: 600,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-check',
            iconColor: 'white'
        });
        
        function preLock(userid, email){
            $('#verify_user_id').val(userid);
            $('#verify_email').val(email);
            $('.verify_email').html(email);
            $('#reason').val('');
            $('#modal-verify').iziModal('open');
        }
        
        function checkReason(){
            var reason = $('#reason').val();
            if(reason.trim().length < 3){
                $('.reason').addClass('has-error');
                $('.reason-error').html('Lý do phải có ít nhất 3 ký tự');
                return false;
            } else {
                $('.reason').removeClass('has-error');
                $('.reason-error').html('');
            }
        }
        
        function unlock(userid, email){
            $('#unlock_user_id').val(userid);
            $('#unlock_email').val(email);
            $('#formUnlock').submit();
        }
        
        $('#modal-role').iziModal({
            title: 'Quyền truy cập',
            top: 100,
            overlayClose: false,
            width: 600,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-file-certificate',
            iconColor: 'white',
            onClosing: function (modal) {
                $("#body-role").load(location.href+" #body-role>*","");
                $("#body-table").load(location.href+" #body-table>*","");
            }
        });
        $('#modal-all-comment').iziModal({
            title: 'Tất cả bình luận',
            top: 100,
            overlayClose: false,
            width: 600,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-comments',
            iconColor: 'white'
        });
        
        function preActionRole(userid, email){            
            $('#role_user_id').val(userid);
            $('#role_email').val(email);    
            var form_data = new FormData();
            form_data.append('user_id', userid);
            $.ajax({
                    url: '{{url("quan-ly/tai-khoan/get-role")}}',
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
                        var json = JSON.parse(data);
                        console.log(json);  
                        for(var i = 0; i < json.length; i++){
                            $('.input-role-'+json[i].role_code).css('border-color', 'rgb(54, 127, 169)');
                            $('.input-role-'+json[i].role_code).css('background-color', 'rgb(54, 127, 169)');
                            $('.input-role-'+json[i].role_code).css('color', 'white');
                            $('.role-'+json[i].role_code).removeClass('btn-primary');
                            $('.role-'+json[i].role_code).addClass('btn-danger');
                            $('.role-'+json[i].role_code).html('Xóa');
                        }
                    }
            });
            $('#modal-role').iziModal('open');
        }
        function actionRole(role){
            var userid = $('#role_user_id').val();
            var action = $('.role-'+role).html();
            var form_data = new FormData();
            form_data.append('user_id', userid);
            form_data.append('role_code', role);
            form_data.append('action', action);
            $.ajax({
                    url: '{{url("quan-ly/tai-khoan/add-remove-role")}}',
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
                        console.log(data);
                        if(data === 'added'){
                            $('.input-role-'+role).css('border-color', 'rgb(54, 127, 169)');
                            $('.input-role-'+role).css('background-color', 'rgb(54, 127, 169)');
                            $('.input-role-'+role).css('color', 'white');
                            $('.role-'+role).removeClass('btn-primary');
                            $('.role-'+role).addClass('btn-danger');
                            $('.role-'+role).html('Xóa'); 
                        } else {
                            $('.input-role-'+role).css('border-color', '#d2d6de');
                            $('.input-role-'+role).css('background-color', '#eee');
                            $('.input-role-'+role).css('color', '#555');
                            $('.role-'+role).removeClass('btn-danger');
                            $('.role-'+role).addClass('btn-primary');                            
                            $('.role-'+role).html('Thêm'); 
                        }
                    }
            });
        }
        function showAllComment(uid){
            $('#modal-all-comment').iziModal('open');
        }
    </script>
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Report bình luận</h3>
                    <div class="box-btn-header" style="float:right;">                        
                    </div>                   
                                        
                </div>                
                <div class="box-body">                    
                    <table class="table table-hover">
                        <caption>
                            <span>Tổng: {{$countReport[0]->tong}}</span>
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 5%">#</th>                                
                                <th scope="col" class="text-left" style="width: 20%">Email bị report</th>
                                <th scope="col" class="text-left" style="width: 20%">Phim</th>
                                <th scope="col" class="text-left" style="width: 25%">Nội dung report</th>                                
                                <th scope="col" class="text-center" style="width: 20%">Ngày report</th>                                
                                <th scope="col" class="text-center" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listReport as $row)
                            <tr>
                                <td class="text-center" style="cursor:pointer;">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                    <input type="hidden" class="avatar-{{$row->cr_id}}" value="{{$row->avatar}}" />
                                    <input type="hidden" class="content-{{$row->cr_id}}" value="{{$row->binhluan_noidung}}" />
                                    <input type="hidden" class="name-{{$row->cr_id}}" value="{{$row->name}}" />
                                    <input type="hidden" class="email-{{$row->cr_id}}" value="{{$row->email}}" />
                                    <input type="hidden" class="cid-{{$row->cr_id}}" value="{{$row->binhluan_id}}" />
                                </td>                                
                                <td>
                                    {{$row->email}}
                                </td>                                
                                <td>
                                    {{$row->phim_ten}}
                                </td> 
                                <td>
                                    {{$row->cr_content}}
                                </td>                                                                                                                             
                                <td class="text-center">
                                    <?php 
                                        $date = date_create($row->cr_ngaycapnhat);
                                        echo date_format($date, 'H:i:s d-m-Y');
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="list-action-icon"> 
                                        <span data-toggle="tooltip" title="Xem bình luận bị report" onclick="preDeleteComment({{$row->cr_id}})">
                                            <i class="fa fa-comment text-light-blue"></i>
                                        </span>                                        
                                        <span data-toggle="tooltip" title="Xóa report" onclick="preDeleteReport({{$row->cr_id}}, '{{$row->cr_content}}')">
                                            <i class="fa fa-close text-light-red"></i>
                                        </span>
                                    </div>
                                </td>                                                                                     
                            </tr>
                            @endforeach
                            <?php if($rowIndex == 0) :?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    Không tìm thấy dữ liệu
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>                        
                    </table>
                </div>                              
            </div>            
        </div>        
    </div>    
    <div id="modal-verify-report" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/tai-khoan/delete-report')}}">
            {{csrf_field()}}
            <input type="hidden" id="verify_cr_id" name="cr_id" value="" />                    
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        Bạn có đồng ý xóa report này không?
                    </div>                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <pre id="verify_cr_content"></pre>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:20px">
                        <button type="submit" class="btn btn-danger">Đồng ý</button>
                        <button type="button" class="btn btn-default" data-izimodal-close="">Hủy bỏ</button>
                    </div>
                </div>        
            </div>
        </form>        
    </div>
    <div id="modal-comment" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/tai-khoan/delete-comment')}}">
            {{csrf_field()}}
            <input type="hidden" id="cid" name="cid" value="" />                    
            <div class="modal-body" style="padding: 20px">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table no-border" style="margin-bottom:0px">
                            <tr>
                                <td style="width:120px;" class="text-center">
                                    <img class="action-comment-avatar avatar img-circle" src="" width="100%" />
                                </td>
                                <td class="text-left">
                                    <div class="action-comment-username" style="font-weight: 700"></div>
                                    <div class="action-comment-content content-comment"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">                        
                        <button class="btn btn-danger">Xóa bình luận</button>
                        <button class="btn btn-default" data-izimodal-close="">Đóng</button>
                    </div>
                </div>
            </div>
        </form>        
    </div>       
    <script>        
        $('#modal-verify-report').iziModal({
            title: 'Xác nhận',
            top: 100,
            overlayClose: false,
            width: 600,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-check',
            iconColor: 'white'
        });
        $('#modal-comment').iziModal({
            title: 'Bình luận',
            top: 100,
            overlayClose: false,
            width: 600,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-comment',
            iconColor: 'white'
        });        
        
        function preDeleteReport(crid, crcontent){
            $('#verify_cr_id').val(crid);
            $('#verify_cr_content').html(crcontent);           
            $('#modal-verify-report').iziModal('open');
        }               
        function preDeleteComment(crid){
            $('.action-comment-avatar').attr('src','{{asset('/')}}'+$('.avatar-'+crid).val());
            $('.action-comment-username').html($('.name-'+crid).val());
            $('.action-comment-content').html($('.content-'+crid).val());
            $('#cid').val($('.cid-'+crid).val());
            $('#modal-comment').iziModal('open');
        }          
    </script>     
</section>