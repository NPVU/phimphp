<section class="content-header">
    <h1>
        HỖ TRỢ - BÁO LỖI
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/ho-tro/bao-loi') }}">Hỗ trợ - báo lỗi</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách lỗi</h3>                                                                          
                </div>                
                <div class="box-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                        <div class="box-btn-header" style="float:right;">
                            <form method="GET">
                            <div class="form-search-addon">
                                <div class="input-group">
                                    <input type="search" name="tukhoa" value="<?php echo isset($_GET['tukhoa'])?$_GET['tukhoa']:''; ?>" placeholder="Nhập từ khóa cần tìm ..." class="form-control" />
                                    <span class="input-group-addon" style="cursor: pointer" onclick="$('#btn-search-taikhoan').click();"><i class="fa fa-search"></i></span>
                                    <span class="input-group-addon" style="cursor: pointer" onclick="window.location.href = '{{url('/quan-ly/ho-tro/bao-loi')}}';"><i class="fa fa-refresh"></i></span>
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
                                <th scope="col" class="text-left" style="width: 15%">Phim</th>
                                <th scope="col" class="text-left" style="width: 10%">Tập</th>
                                <th scope="col" class="text-center" style="width: 20%">Nội dung</th>
                                <th scope="col" class="text-center" style="width: 25%">URL lỗi</th>                             
                                <th scope="col" class="text-center" style="width: 15%">Thời gian báo lỗi</th>
                                <th scope="col" class="text-center" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody id="body-table">
                            <?php 
                                if(isset($_GET['page'])){
                                    $rowIndex = ($_GET['page']-1)*10;
                                }else {
                                    $rowIndex = 0;
                                }
                                                             
                            ?>
                            @foreach ($listReport as $row)
                            <tr>
                                <td class="text-center" style="cursor:pointer;">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>                                
                                <td class="text-left">
                                    {{$row->phim_ten}}
                                </td>
                                <td class="text-left">
                                    {{$row->tap_tapsohienthi}}
                                </td>   
                                <td class="text-left">
                                    <?php echo $row->er_content ?>
                                </td>   
                                <td class="text-left">
                                    {{$row->er_url}}
                                </td>                                                                                                                        
                                <td class="text-center">
                                    <?php 
                                        $date = date_create($row->er_create_at);
                                        echo date_format($date, 'd-m-Y');
                                    ?>
                                </td>                                
                                <td class="text-center">
                                    <div class="list-action-icon">
                                        <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t='.$row->tap_tapso.'&s='.md5('google')}}" target="_blank">
                                            <span data-toggle="tooltip" title="Đi đến">
                                                <i class="fa fa-internet-explorer  text-light-blue"></i>
                                            </span>
                                        </a>
                                        <span data-toggle="tooltip" title="Xóa" onclick="preDeleteReport({{$row->er_id}}, '{{$row->er_content}}')">
                                            <i class="fa fa-close text-light-red"></i>
                                        </span>
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
                                    {{ $listReport->appends(['tukhoa' => Request::get('tukhoa')])->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>                              
            </div>            
        </div>        
    </div>  
    <div id="modal-verify-report" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/ho-tro/bao-loi/delete')}}">
            {{csrf_field()}}
            <input type="hidden" id="verify_cr_id" name="cr_id" value="" />                    
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        Bạn có đồng ý xóa lỗi này không?
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
        function preDeleteReport(erid, ercontent){
            $('#verify_cr_id').val(erid);
            $('#verify_cr_content').html(ercontent);           
            $('#modal-verify-report').iziModal('open');
        }  
    </script>  
</section>