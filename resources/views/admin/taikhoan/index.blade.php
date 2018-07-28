<section class="content-header">
    <h1>
        DANH SÁCH TÀI KHOẢN
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/tai-khoan') }}">Quản lý tài khoản</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
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
                <div class="box-body">                    
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
                                <th scope="col" class="text-center" style="width: 15%">Ngày cập nhật</th>
                                <th scope="col" class="text-center" style="width: 15%">Trạng thái</th>
                                <th scope="col" class="text-center" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listUser as $row)
                            <tr id="row{{$row->id}}" >
                                <td class="text-center" style="cursor:pointer;">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>                                
                                <td style="cursor:pointer;">
                                    {{$row->email}}
                                </td>
                                <td style="cursor:pointer;">
                                    {{$row->name}}
                                </td>                                                                                                                             
                                <td class="text-center">
                                    <?php 
                                        $date = date_create($row->created_at);
                                        echo date_format($date, 'd-m-Y');
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        $date = date_create($row->updated_at);
                                        echo date_format($date, 'd-m-Y');
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                        echo $row->active==1?'Hoạt động':'Bị khóa';
                                    ?>
                                </td>
                                <td class="text-center">                                      
                                    <div class="list-action-icon">  
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

                    <div class="col-md-12 text-center" style="margin-top:20px">
                        <button type="submit" class="btn btn-danger">Đồng ý</button>
                        <button type="button" class="btn btn-default" data-izimodal-close="">Hủy bỏ</button>
                    </div>
                </div>        
            </div>
        </form>
        <form id="formUnlock" method="POST" action="{{url('quan-ly/tai-khoan/unlock')}}" style="display: none">
            {{csrf_field()}}
            <input type="hidden" id="unlock_user_id" name="user_id" value="" />
            <input type="hidden" id="unlock_email" name="email" value="" />                        
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
            $('#modal-verify').iziModal('open');
        }
        
        function unlock(userid, email){
            $('#unlock_user_id').val(userid);
            $('#unlock_email').val(email);
            $('#formUnlock').submit();
        }
    </script>
</section>