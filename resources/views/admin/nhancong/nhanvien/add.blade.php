<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thêm nhân viên</h3>
                </div>
                <form role="form" method="POST" action="{{url('/quan-ly/nhan-cong/nhan-vien/them-moi')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group <?php echo empty($msg_error_hoten)?'':'has-error'; ?>">
                                <label for="txtHoTen">Họ tên</label>
                                <input type="text" class="form-control required" id="txtHoTen" name="hoten" value="{{ $hoten }}" placeholder="Nhập vào họ tên"/>
                                <span class="help-block">{{$msg_error_hoten}}</span>
                            </div>
                            <div class="form-group <?php echo empty($msg_error_cmnd)?'':'has-error'; ?>">
                                <label for="numberCMND">Số chứng mình nhân dân</label>
                                <input type="number" class="form-control required" id="numberCMND" name="cmnd" value="{{ $cmnd }}" placeholder="Nhập vào Số CMND"/>
                                <span class="help-block">{{$msg_error_cmnd}}</span>
                            </div>
                            <div class="form-group <?php echo empty($msg_error_ngaysinh)?'':'has-error'; ?>">
                                <label for="dateNgaySinh">Ngày sinh</label>
                                <input type="date" class="form-control required" id="dateNgaySinh" name="ngaysinh" value="{{ $ngaysinh }}" />
                                
                                <span class="help-block">{{$msg_error_ngaysinh}}</span>
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label> <br/>
                                <input type="radio" class="form-check-inline" name="gioitinh" value="1" <?php echo $gioitinh==1?'checked':''; ?> /> Nam
                                <input type="radio" class="form-check-inline" name="gioitinh" value="0" <?php echo $gioitinh==0?'checked':''; ?> /> Nữ                                    
                            </div>
                                                        
                             <div class="form-group">
                                <label for="txtDiaChi">Địa chỉ</label>                                
                                <textarea class="form-control" id ="txtDiaChi" name="diachi" >{{ $diachi }}</textarea>                                
                            </div>                            
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="numberSoDienThoai">Số điện thoại</label>
                                <input type="number" class="form-control" id="numberSoDienThoai" name="sodienthoai" value="{{ $sodienthoai }}" placeholder="Nhập vào Số điện thoại"/>
                            </div>
                            <div class="form-group">
                                <label for="txtEmail">Email</label>
                                <input type="text" class="form-control" id="txtEmail" name="email" value="{{ $email }}" placeholder="Nhập vào Email"/>
                            </div>
                            <div class="form-group">
                                <label for="dateBatDauLam">Ngày bắt đầu làm</label>
                                <input type="date" class="form-control" id="dateBatDauLam" name="ngaybatdaulam" value="{{ $ngaybatdaulam }}" />
                            </div>
                            <div class="form-group">
                                <label for="fileHinhAnh">Hình ảnh</label>
                                <input type="file" class="form-control" id="fileHinhAnh" name="hinhanh" />
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-danger" name="btnCapNhat">Cập nhật</button>
                        <a href="{{url('/quan-ly/nhan-cong/nhan-vien/')}}" class="btn btn-default" name="btnTroVe">Trở về</a>
                    </div>
                </form>
            </div>            
        </div>        
    </div>    
</section>