<section class="content-header">
    <h1>
        DANH SÁCH PHIM
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/phim') }}">Phim</a></li>
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
                </div>                
                <div class="box-body">                    
                    <table class="table table-hover">
                        <caption>
                            <span>Tổng: <?php echo count($listPhim); ?></span>
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 5%">#</th>
                                <th scope="col" class="text-left" style="width: 75%">Tên phim</th>                                
                                <th scope="col" class="text-center" style="width: 20%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listPhim as $row)
                            <tr>
                                <td class="text-center">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>
                                <td>{{$row->phim_ten}}</td>                                
                                <td class="text-center">                                      
                                    <div class="list-action-icon">                                        
                                        <span onclick="preUpdTheLoai({{$row->phim_id}},'{{$row->phim_ten}}')">
                                            <i class="fa fa-edit text-light-blue"></i>
                                        </span> 
                                        <span onclick="preDelTheLoai({{$row->phim_id}},'{{$row->phim_ten}}')">
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
</section>