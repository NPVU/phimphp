<section class="content-header">
    <h1>
        DANH MỤC THỂ LOẠI
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
                    <div class="box-btn-header" style="float:left;">
                        <form method="POST">
                            <div class="form-add-addon">
                                <div class="input-group">
                                    {{csrf_field()}}
                                    <input type="text" id="add_theloai_ten" name="add_theloai_ten" value="{{old('add_theloai_ten')}}" placeholder="Nhập tên thể loại ..." class="form-control" />
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-danger" onclick="return validFormTheLoai();">Thêm</button> 
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
                                <button type="submit" id="btn-search-the-loai" class="display-none"></button>
                            </div>         
                        </div>
                        </form>
                    </div>                    
                </div>                
                <div class="box-body">                    
                    <table class="table table-hover">
                        <caption>
                            <span>Tổng: <?php echo count($listTheLoai); ?></span>
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 5%">#</th>
                                <th scope="col" class="text-left" style="width: 75%">Tên thể loại</th>                                
                                <th scope="col" class="text-center" style="width: 20%">Hành động</th>
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
                                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/chinh-sua/')}}/{{csrf_token()}}/">
                                            <i class="fa fa-edit text-light-blue"></i>
                                        </a>                                        
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
    <script>
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
    </script>
</section>