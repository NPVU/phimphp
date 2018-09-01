<section class="content-header">
    <h1>
        DANH MỤC THỂ LOẠI
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{ url('/quan-ly/danh-muc/') }}">Quản lý danh mục</a></li>
        <li class="active"><a href="{{ url('/quan-ly/danh-muc/the-loai') }}">Thể loại</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>                               
                </div>                
                <div class="box-body">     
                    <div class="box-btn-header" style="float:right;">
                        <form method="POST">
                            <div class="form-add-addon">
                                <div class="input-group">
                                    {{csrf_field()}}
                                    <input type="text" id="add_theloai_ten" name="add_theloai_ten" value="{{old('add_theloai_ten')}}" placeholder="Nhập tên thể loại ..." class="form-control" />
                                    <span class="input-group-btn">
                                        <button type="submit" name="btn" value="add" class="btn btn-danger" onclick="return validFormTheLoai();">Thêm</button> 
                                    </span>
                                </div>         
                            </div>
                        </form>
                    </div>
                    <div class="box-btn-header" style="float:right;">
                        <form method="GET">
                        <div class="form-search-addon">
                            <div class="input-group">
                                <input type="search" name="theloai" value="<?php echo isset($_GET['theloai'])?$_GET['theloai']:''; ?>" placeholder="Nhập từ khóa cần tìm ..." class="form-control" />
                                <span class="input-group-addon" style="cursor: pointer" onclick="$('#btn-search-the-loai').click();"><i class="fa fa-search"></i></span>
                                <span class="input-group-addon" style="cursor: pointer" onclick="window.location.href = '{{url('/quan-ly/danh-muc/the-loai')}}';"><i class="fa fa-refresh"></i></span>
                                <button type="submit" id="btn-search-the-loai" class="display-none"></button>
                            </div>         
                        </div>
                        </form>
                    </div>                        
                    <table class="table table-hover">
                        <caption>
                            <span>Tổng: <?php echo count($listTheLoai); ?></span>
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 5%">#</th>
                                <th scope="col" class="text-left" style="width: 75%">Tên thể loại</th>                                
                                <th scope="col" class="text-center" style="width: 20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listTheLoai as $row)
                            <tr>
                                <td class="text-center">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>
                                <td>{{$row->theloai_ten}}</td>                                
                                <td class="text-center">                                      
                                    <div class="list-action-icon">                                        
                                        <span onclick="preUpdTheLoai({{$row->theloai_id}},'{{$row->theloai_ten}}')">
                                            <i class="fa fa-edit text-light-blue"></i>
                                        </span> 
                                        <span onclick="preDelTheLoai({{$row->theloai_id}},'{{$row->theloai_ten}}')">
                                            <i class="fa fa-close text-light-red"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <?php if($rowIndex == 0) :?>
                            <tr>
                                <td colspan="3" class="text-center">
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
    <div id="modal-del-theloai" data-izimodal-transitionin="fadeInDown">
        <form method="POST">
            {{csrf_field()}}
            <input type="hidden" id="del_theloai_id" name="del_theloai_id" value="" />
            <input type="hidden" id="del_theloai_ten" name="del_theloai_ten" value="" />
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-center">
                        Bạn có đồng ý xóa thể loại 
                        <strong style="color: lightseagreen;font-size: 1.5em;" class="del_theloai_ten"></strong>
                        không ?
                    </div>

                    <div class="col-md-12 text-center" style="margin-top:20px">
                        <button type="submit" name="btn" value="del" class="btn btn-danger">Đồng ý</button>
                        <button type="button" class="btn btn-default" data-izimodal-close="">Hủy bỏ</button>
                    </div>
                </div>        
            </div>
        </form>
    </div>
    <div id="modal-upd-theloai" data-izimodal-transitionin="fadeInDown">
        <form method="POST">
            {{csrf_field()}}
            <input type="hidden" id="upd_theloai_id" name="upd_theloai_id" value="" />
            <input type="hidden" id="upd_theloai_ten_old" name="upd_theloai_ten_old" value="" />
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-left">
                        <label>Nhập tên mới cho thể loại 
                        <strong style="color: lightseagreen;font-size: 1.5em;" class="upd_theloai_ten_old"></strong>
                        </label>
                        <input type="text" class="form-control" id="upd_theloai_ten_new" name="upd_theloai_ten_new" />
                    </div>

                    <div class="col-md-12 text-center" style="margin-top:20px">
                        <button type="submit" name="btn" value="upd" class="btn btn-danger">Cập nhật</button>
                        <button type="button" class="btn btn-default" data-izimodal-close="">Hủy bỏ</button>
                    </div>
                </div>        
            </div>
        </form>
    </div>
    <script>
        $('#modal-del-theloai').iziModal({
            overlayClose: false,
            width: 500,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-check',
            iconColor: 'white'
        });
        $('#modal-del-theloai').iziModal('setTitle', 'Xác nhận');
        $('#modal-del-theloai').iziModal('setTop', 100);
        
        $('#modal-upd-theloai').iziModal({
            overlayClose: false,
            width: 500,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-exchange',
            iconColor: 'white'
        });
        $('#modal-upd-theloai').iziModal('setTitle', 'Thay đổi tên thể loại');
        $('#modal-upd-theloai').iziModal('setTop', 100);
        
        function validFormTheLoai(){
            var str = $('#add_theloai_ten').val();
            if(str.trim()){
                return true;
            } else {
                $('#add_theloai_ten').val('');
                showToast('error', '', 'Vui lòng nhập tên thể loại !', true);
                return false;
            }
        }       
        function preDelTheLoai(id, ten){
            $('#del_theloai_id').val(id);
            $('#del_theloai_ten').val(ten);
            $('.del_theloai_ten').html(ten);            
            $('#modal-del-theloai').iziModal('open');
        }
        function preUpdTheLoai(id, ten){
            $('#upd_theloai_id').val(id);
            $('#upd_theloai_ten_old').val(ten);
            $('#upd_theloai_ten_new').val(ten);
            $('.upd_theloai_ten_old').html(ten);            
            $('#modal-upd-theloai').iziModal('open');
            $('#upd_theloai_ten_new').focus();
        }        
    </script>
</section>