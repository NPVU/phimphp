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
                                <th scope="col" class="text-center" style="width: 15%">Số tập</th>
                                <th scope="col" class="text-left" style="width: 15%">Tag</th>                                                                
                                <th scope="col" class="text-center" style="width: 20%">Lượt xem</th>                                
                                <th scope="col" class="text-center" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $rowIndex = 0;                                
                            ?>
                            @foreach ($listPhim as $row)
                            <tr id="row{{$row->phim_id}}" onclick="preAddTapPhim({{$row->phim_id}}, '{{$row->phim_ten}}', {{$row->phim_sotap}}, {{$row->tap}})" style="cursor:pointer;">
                                <td class="text-center">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>                                
                                <td>{{$row->phim_ten}}</td>
                                <td class="text-center">{{$row->tap}}/{{$row->phim_sotap}}</td> 
                                <td>{{$row->phim_tag}}</td>                                                              
                                <td class="text-center">{{$row->phim_luotxem}}</td>
<!--                                <td class="text-center">
                                    <?php 
//                                        $date = date_create($row->phim_ngaycapnhat);
//                                        echo date_format($date, 'd-m-Y');
                                        ?>
                                </td>-->
                                <td class="text-center">                                      
                                    <div class="list-action-icon">
                                        <span onclick="preAddTapPhim({{$row->phim_id}}, '{{$row->phim_ten}}', {{$row->phim_sotap}}, {{$row->tap}})" data-toggle="tooltip" title="Thêm tập">
                                            <i class="fa fa fa-plus-circle text-light-blue"></i>
                                        </span>
                                        <span data-toggle="tooltip" title="Chỉnh sửa phim">
                                            <a href="{{url('quan-ly/phim/chinh-sua')}}/{{csrf_token()}}/{{$row->phim_id}}"><i class="fa fa-edit text-light-blue"></i></a>
                                        </span> 
                                        <span onclick="preDelPhim({{$row->phim_id}}, '{{$row->phim_ten}}')" data-toggle="tooltip" title="Xóa phim">
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
    <div id="modal-del-phim" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/phim/xoa')}}">
            {{csrf_field()}}
            <input type="hidden" id="del_phim_id" name="del_phim_id" value="" />
            <input type="hidden" id="del_phim_ten" name="del_phim_ten" value="" />
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-center">
                        Bạn có đồng ý xóa phim 
                        <strong style="color: lightseagreen;font-size: 1.5em;" class="del_phim_ten"></strong>
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
    <div id="modal-add-tapphim" data-izimodal-transitionin="fadeInDown">
        <form id="fromAddTapPhim">
            <input type="hidden" id="add_phim_id" name="add_phim_id" value="" />
            <input type="hidden" id="add_phim_maxtap" value="" />
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-center">
                        <div class="form-group">                        
                            <strong style="color: lightseagreen;font-size: 1.5em;" id="add_phim_ten"></strong>                                            
                        </div>
                     </div>
                    <div class="col-md-4">                    
                        <div class="form-group add_tapphim_taphienthi">
                            <label>Tập hiển thị</label>
                            <input type="text" id="add_tapphim_taphienthi" name="add_tapphim_taphienthi" class="form-control required" value="" placeholder=""/>
                            <span class="help-block add_tapphim_taphienthi_error"></span>
                        </div>
                        <div class="form-group add_tapphim_tap">
                            <label>Tập</label>
                            <input type="number" id="add_tapphim_tap" name="add_tapphim_tap" class="form-control required" value="" placeholder=""/>
                            <span class="help-block add_tapphim_tap_error"></span>
                        </div>
                        <div class="form-group add_tapphim_ten">
                            <label>Tên tập phim</label>
                            <input type="text" id="add_tapphim_ten" name="add_tapphim_ten" class="form-control" value="" placeholder=""/>
                            <span class="help-block add_tapphim_ten_error"></span>
                        </div>
                        <div class="form-group add_tapphim_luotxem">
                            <label>Lượt xem</label>
                            <input type="number" id="add_tapphim_luotxem" name="add_tapphim_luotxem" class="form-control" value="0" placeholder=""/>
                            <span class="help-block add_tapphim_luotxem_error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Link Localhost</label>
                            <div class="input-group">                        
                                <input type="text" name="localhostLink" value="" placeholder="Nhập link localhost ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkLocalhostLink" class="btn btn-success">Kiểm tra</button>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label>Link Google Photos</label>
                            <div class="input-group">                        
                                <input type="text" name="googleLink" value="" placeholder="Nhập link google photos ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkGoogleLink" class="btn btn-success">Kiểm tra</button>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label>Link Youtube</label>
                            <div class="input-group">                        
                                <input type="text" name="youtubeLink" value="" placeholder="Nhập link youtube ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkYoutubeLink" class="btn btn-success">Kiểm tra</button>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label>Link Openload</label>
                            <div class="input-group">                        
                                <input type="text" name="openloadLink" value="" placeholder="Nhập link openload ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkOpenloadLink" class="btn btn-success">Kiểm tra</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <video id="videoCheck" src="" width="100%"></video>
                    </div>

                    <div class="col-md-12 text-center" style="margin-top:20px">                        
                        <button type="button" name="btn" value="addTapPhim" class="btn btn-danger" onclick="addTapPhim()">Cập nhật</button>                    
                        <button type="button" class="btn btn-default" data-izimodal-close="">Đóng</button>
                    </div>
                </div>        
            </div>
        </form>        
    </div>
    <script>        
        function preDelPhim(id, ten){
            $('#del_phim_id').val(id);
            $('#del_phim_ten').val(ten);
            $('.del_phim_ten').html(ten);            
            $('#modal-del-phim').iziModal('open');
        }
        $('#modal-del-phim').iziModal({
            overlayClose: false,
            width: 500,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-check',
            iconColor: 'white'
        });
        $('#modal-del-phim').iziModal('setTitle', 'Xác nhận');
        $('#modal-del-phim').iziModal('setTop', 100);
        
        function preAddTapPhim(id, ten, maxtap, tap){
            $('#add_phim_id').val(id);
            $('#add_phim_maxtap').val(maxtap);
            $('#add_phim_ten').html(ten);
            resetFormAddTapPhim();                   
            $('#add_tapphim_tap').val(parseInt(tap)+1);
            $('#modal-add-tapphim').iziModal('open');
        }
        function resetFormAddTapPhim(){
            $('#add_tapphim_ten').val('');
            $('#add_tapphim_taphienthi').val('');            
            $('#localhostLink').val('');
            $('#googleLink').val('');
            $('#youtubeLink').val('');
            $('#openloadLink').val('');
            $('#videoCheck').attr('src', '');
        }
        $('#modal-add-tapphim').iziModal({
            overlayClose: false,
            width: '80%',
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-plus-circle',
            iconColor: 'white',
            onClosing: function (modal) {
                window.location.href = "{{url('quan-ly/phim')}}";
            }
        });
        $('#modal-add-tapphim').iziModal('setTitle', 'Thêm tập phim');
        $('#modal-add-tapphim').iziModal('setTop', 50);
        
        function addTapPhim(){
            var valid = true;
            var taphienthi = $('#add_tapphim_taphienthi').val();
            var tap = $('#add_tapphim_tap').val();
            var tentap = $('#add_tapphim_ten').val();
            
            if(taphienthi.trim() === "" || taphienthi.trim().length > 50){
                $('.add_tapphim_taphienthi').addClass('has-error');
                $('.add_tapphim_taphienthi_error').html('Tập hiển thị có tối đa 50 ký tự');
                valid = false;
            } else {
                $('.add_tapphim_taphienthi').removeClass('has-error');
                $('.add_tapphim_taphienthi_error').html('');
            }
            if(parseInt(tap) == 0 || parseInt(tap) > $('#add_phim_maxtap').val()){
                $('.add_tapphim_tap').addClass('has-error');
                $('.add_tapphim_tap_error').html('Tập hợp lệ trong khoảng 1 - '+$('#add_phim_maxtap').val());
                valid = false;
            } else {
                $('.add_tapphim_tap').removeClass('has-error');
                $('.add_tapphim_tap_error').html('');
            }            
            if(tentap.trim() !== "" && tentap.trim().length > 250){
                $('.add_tapphim_ten').addClass('has-error');
                $('.add_tapphim_ten_error').html('Tên tập có tối đa 250 ký tự');
                valid = false;
            } else {
                $('.add_tapphim_ten').removeClass('has-error');
                $('.add_tapphim_ten_error').html('');
            }           
            if(!valid){
                return false;
            }
            var url = "{{url('quan-ly/phim/them-tap-phim/')}}"; // the script where you handle the form input.
            $.ajax({
                   type: "POST",
                   url: url,
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                   data: $("#fromAddTapPhim").serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                       if(data.status === 0){                           
                           $('.add_tapphim_tap').addClass('has-error');
                           $('.add_tapphim_tap_error').html(data.msg);
                       } else if(data.status === 1) {
                           $('.add_tapphim_tap').removeClass('has-error');
                           $('.add_tapphim_tap_error').html(''); 
                           resetFormAddTapPhim();
                           $('#add_tapphim_tap').val(parseInt(tap)+1);
                           showToast('success', 'Đã thêm tập '+tap+' thành công', 'Cập nhật thành công', true);
                       }
                   }
                 });
        }
    </script>
</section>