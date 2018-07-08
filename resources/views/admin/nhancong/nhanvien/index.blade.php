<section class="content-header">
    <h1>
        DANH SÁCH NHÂN VIÊN
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('/quan-ly/nhan-cong/') }}">Quản lý nhân công</a></li>
        <li class="active">Quản lý nhân viên</li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-btn-header" style="float:right;">
                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/them-moi')}}" class="btn btn-danger">Thêm mới</a>
                    </div>                    
                </div>                
                <div class="box-body">
                    <form class="box-filter" method="POST" role="form" action="{{url('/quan-ly/nhan-cong/nhan-vien')}}">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label for="txtHoTenFilter">Họ tên</label>
                                <input type="text" class="form-control" id="txtHoTenFilter" name="hotenFilter" value="{{ $hotenFilter }}" placeholder="Nhập họ tên cần tìm"/>
                            </div>
                            <div class="col-md-4">
                                <label for="numberCMNDFilter">Số CMND</label>
                                <input type="number" class="form-control" id="numberCMNDFilter" name="cmndFilter" value="{{ $cmndFilter }}" placeholder="Nhập số CMND cần tìm"/>
                            </div>
                            <div class="col-md-4">
                                <label for="selectTinhTrangFilter">Tình trạng</label>
                                <select id="selectTinhTrangFilter" name="tinhtrangFilter" class="form-control">
                                    <option value="-1" <?php echo $tinhtrangFilter==-1?'selected':'' ?>>Tất cả</option>
                                    <option value="1" <?php echo $tinhtrangFilter==1?'selected':'' ?>>Hoạt động</option>
                                    <option value="0" <?php echo $tinhtrangFilter==0?'selected':'' ?>>Đã khóa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-center" style="margin-top:10px">
                            <button type="submit" name="btnFilter" value="btnFilter" class="btn btn-default fa fa-search"> Tìm</button>                            
                        </div>
                    </form>
                    <table class="table table-bordered table-hover">
                        <caption>
                            <span>Tổng: <?php echo count($nhanvien); ?> / {{$tongnhanvien}} (nhân viên)</span>
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 3%">#</th>
                                <th scope="col" class="text-center" style="width: 25%">Họ tên</th>
                                <th scope="col" class="text-center" style="width: 10%">Giới tính</th>
                                <th scope="col" class="text-center" style="width: 10%">Ngày sinh</th>
                                <th scope="col" class="text-center" style="width: 15%">Số CMND</th>
                                <th scope="col" class="text-center" style="width: 10%">SĐT</th>
                                <th scope="col" class="text-center" style="width: 12%">Tình trạng</th>
                                <th scope="col" class="text-center" style="width: 15%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;
                                if (isset($_GET['page'])) {
                                    $rowIndex = ($_GET['page']-1) * 10;
                                } 
                            ?>
                            @foreach ($nhanvien as $row)
                            <tr>
                                <td class="text-center">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>
                                <td>{{$row->nhanvien_hoten}}</td>
                                <td><?php echo $row->nhanvien_gioitinh == 1 ? 'Nam' : 'Nữ'; ?></td>
                                <td class="text-center"><?php echo date('d/m/Y', strtotime($row->nhanvien_ngaysinh)); ?></td>
                                <td class="text-center">{{$row->nhanvien_cmnd}}</td>
                                <td class="text-center">{{$row->nhanvien_sodienthoai}}</td>
                                <td class="text-center">
                                    <?php if ($row->nhanvien_tinhtrang == 1) : ?>
                                        Hoạt động
                                    <?php elseif ($row->nhanvien_tinhtrang == 0) : ?>
                                        Đã khóa
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">                                      
                                    <div class="list-action-icon">
                                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/thong-tin/')}}/{{csrf_token()}}/{{$row->nhanvien_id}}">
                                            <i class="fa fa-eye text-blue"></i>
                                        </a>
                                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/chinh-sua/')}}/{{csrf_token()}}/{{$row->nhanvien_id}}">
                                            <i class="fa fa-edit text-light-blue"></i>
                                        </a>
                                        <?php if($row->nhanvien_tinhtrang == 1) :?>
                                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/khoa/')}}/{{csrf_token()}}/{{$row->nhanvien_id}}">
                                            <i class="fa fa-lock text-red" onclick="selectRow({{$row->nhanvien_id}},'lockButton',true)"></i>
                                        </a>
                                        <?php elseif ($row->nhanvien_tinhtrang == 0) :?>
                                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/mo-khoa/')}}/{{csrf_token()}}/{{$row->nhanvien_id}}">
                                            <i class="fa fa-unlock text-success" onclick="selectRow({{$row->nhanvien_id}},'unlockButton',true)"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <?php if($rowIndex == 0) :?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    Không tìm thấy dữ liệu
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right">
                    <?php if($tongnhanvien != count($nhanvien)) :?>
                        {{$nhanvien->links()}}
                    <?php endif; ?>
                </div>                
            </div>            
        </div>        
    </div>    
</section>