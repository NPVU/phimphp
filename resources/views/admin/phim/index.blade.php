<section class="content-header">
    <h1>
        DANH SÁCH PHIM
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/phim') }}">Quản lý phim</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-btn-header" style="float:left;">
                        <form method="GET">
                        <div class="form-search-addon">
                            <div class="input-group">
                                <input type="search" name="phim" value="<?php echo isset($_GET['phim'])?$_GET['phim']:''; ?>" placeholder="Nhập từ khóa cần tìm ..." class="form-control" />
                                <span class="input-group-addon" style="cursor: pointer" onclick="$('#btn-search-phim').click();"><i class="fa fa-search"></i></span>
                                <span class="input-group-addon" style="cursor: pointer" onclick="window.location.href = '{{url('/quan-ly/phim')}}';"><i class="fa fa-refresh"></i></span>
                                <button type="submit" id="btn-search-phim" class="display-none"></button>
                            </div>         
                        </div>
                        </form>
                    </div>
                    <div class="box-btn-header" style="float:right;">
                        <a href="{{url('quan-ly/phim/them')}}" class="btn btn-danger">Thêm mới</a>
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
                                <th scope="col" class="text-left" style="width: 35%">Tên phim</th>
                                <th scope="col" class="text-left" style="width: 10%">Tag</th>
                                <th scope="col" class="text-center" style="width: 10%">Số tập</th>
                                <th scope="col" class="text-center" style="width: 5%">Năm</th>
                                <th scope="col" class="text-center" style="width: 10%">Lượt xem</th>
                                <th scope="col" class="text-center" style="width: 15%">Ngày cập nhật</th>
                                <th scope="col" class="text-center" style="width: 10%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listPhim as $row)
                            <tr id="row{{$row->phim_id}}">
                                <td class="text-center">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>                                
                                <td>{{$row->phim_ten}}</td>
                                <td>{{$row->phim_tag}}</td>
                                <td class="text-center">??/{{$row->phim_sotap}}</td>
                                <td class="text-center">{{$row->phim_nam}}</td>
                                <td class="text-center">{{$row->phim_luotxem}}</td>
                                <td class="text-center">
                                    <?php 
                                        $date = date_create($row->phim_ngaycapnhat);
                                        echo date_format($date, 'd-m-Y');
                                        ?>
                                </td>
                                <td class="text-center">                                      
                                    <div class="list-action-icon">                                        
                                        <span>
                                            <a href="{{url('quan-ly/phim/chinh-sua')}}/{{csrf_token()}}/{{$row->phim_id}}"><i class="fa fa-edit text-light-blue"></i></a>
                                        </span> 
                                        <span onclick="preDelPhim({{$row->phim_id}})">
                                            <i class="fa fa-close text-light-red"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <?php if($rowIndex == 0) :?>
                            <tr>
                                <td colspan="4" class="text-center">
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
        function preDelPhim(phimID) {
            $.ajax({
                type: "GET",
                url: "{{url('/quan-ly/phim/xoa')}}/{{csrf_token()}}/" + phimID,
                success: function (data) {
                    if (data.status === 1) {
                        $('#row'+phimID).addClass('display-none');
                        showToast("success", "", "Xóa thành công !", true);
                    }
                }
            });
        }
    </script>
</section>