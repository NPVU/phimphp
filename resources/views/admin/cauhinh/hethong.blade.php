<section class="content-header">
    <h1>
        CẤU HÌNH HỆ THỐNG
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/quan-ly/cau-hinh') }}"> Cấu hình</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/cau-hinh/he-thong') }}">Hệ thống</a></li>
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
                    <form method="POST">
                        {{csrf_field()}}
                        <div class="col-md-4">
                            <div class="input-group">                                                        
                                <input type="text" class="form-control" value="File rác trong thư mục tạm ({{$count}})" disabled="true">
                                <div class="input-group-btn">
                                    <button type="submit" name="btn" value="delFileTemp" class="btn btn-danger">Xóa</button>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" value="Reset lượt xem tuần + tháng" disabled="true">
                                <div class="input-group-btn">
                                    <button type="submit" name="btn" value="resetView" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                              
            </div>            
        </div>        
    </div>    
</section>