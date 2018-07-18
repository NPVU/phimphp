<section class="content-header">
    <h1>
        THÊM PHIM
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="{{ url('/quan-ly/phim') }}"> Phim</a></li>
        <li class="active"><a href="{{ url('/quan-ly/phim/them') }}">Thêm</a></li>
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
                            <div class="col-md-12 box-body-title">
                                ảnh bìa
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo isset($add_phim_image_error)?'has-error':''; ?>">
                                    <input type="hidden" name="add_phim_image" id="add_phim_image" />
                                    <input type="file" class="form-control display-none" id="selectFileImage" onchange="autoUploadImage()" />
                                    <img src="{{asset('public/img/themes/jquery-file-upload-scripts.png')}}"
                                         onclick="$('#selectFileImage').click()" 
                                         class="img-select-file npv-add-image" id="imgPhimDragDrop"/> 
                                    <span class="help-block"><?php echo isset($add_phim_image_error)?$add_phim_image_error:''; ?></span>
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 box-body-title">
                                Thông tin phim
                            </div>
                            
                            <div class="form-group <?php echo isset($add_phim_ten_error)?'has-error':''; ?>">
                                <label class="control-label" for="add_phim_ten">Tên phim</label>
                                <input type="text" id="add_phim_ten" name="add_phim_ten" 
                                       class="form-control required" value="<?php echo isset($_POST['add_phim_ten']) ? $_POST['add_phim_ten'] : '' ?>"
                                       placeholder="VD: Naruto"/>
                                <span class="help-block"><?php echo isset($add_phim_ten_error)?$add_phim_ten_error:''; ?></span>
                            </div>                            
                            
                            <div class="form-group <?php echo isset($add_phim_sotap_error)?'has-error':''; ?>">
                                <label>Số tập</label>
                                <input type="number" name="add_phim_sotap" class="form-control required" 
                                       value="<?php echo isset($_POST['add_phim_sotap']) ? $_POST['add_phim_sotap'] : '' ?>"
                                       placeholder="VD: 24"/>
                                <span class="help-block"><?php echo isset($add_phim_sotap_error)?$add_phim_sotap_error:''; ?></span>
                            </div>
                            
                            <div class="form-group <?php echo isset($add_phim_nam_error)?'has-error':''; ?>">
                                <label>Năm phát hành</label>
                                <input type="number" name="add_phim_nam" class="form-control required" 
                                       value="<?php echo isset($_POST['add_phim_nam']) ? $_POST['add_phim_nam'] : '' ?>"
                                       placeholder="VD: 2018"/>
                                <span class="help-block"><?php echo isset($add_phim_nam_error)?$add_phim_nam_error:''; ?></span>
                            </div>
                            
                            <div class="form-group <?php echo isset($add_phim_tenkhac_error)?'has-error':''; ?>">
                                <label class="control-label" for="add_phim_tenkhac">Tên phụ (tên khác)</label>
                                <input type="text" id="add_phim_tenkhac" name="add_phim_tenkhac" 
                                       class="form-control" value="<?php echo isset($_POST['add_phim_tenkhac']) ? $_POST['add_phim_tenkhac'] : '' ?>"
                                       placeholder="VD: Naruto (Phần 1)"/>
                                <span class="help-block"><?php echo isset($add_phim_tenkhac_error)?$add_phim_tenkhac_error:''; ?></span>
                            </div>
                            
                            <div class="form-group <?php echo isset($add_phim_gioithieu_error)?'has-error':''; ?>">
                                <label>Giới thiệu</label>
                                <textarea name="add_phim_gioithieu" class="form-control" rows="5">
                                    <?php echo isset($_POST['add_phim_gioithieu']) ? $_POST['add_phim_gioithieu'] : '' ?>
                                </textarea>     
                                <span class="help-block"><?php echo isset($add_phim_gioithieu_error)?$add_phim_gioithieu_error:''; ?></span>
                            </div>                            
                            
                            <div class="form-group <?php echo isset($add_phim_tag_error)?'has-error':''; ?>">
                                <label>Tag</label>
                                <input type="text" name="add_phim_tag" class="form-control" 
                                       value="<?php echo isset($_POST['add_phim_tag']) ? $_POST['add_phim_tag'] : '' ?>"
                                       placeholder="VD: Naruto, Ninja, Cửu vĩ hồ"/>
                                <span class="help-block"><?php echo isset($add_phim_tag_error)?$add_phim_tag_error:''; ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 box-body-title">
                                Thông tin liên quan
                            </div>
                            <div class="form-group">
                                
                            </div>                            
                            <div class="form-group <?php echo isset($add_phim_theloai_error)?'has-error':''; ?>">
                                <label>Thể loại</label>
                                    @foreach ($listTheLoai as $row)
                                        <br/>
                                        <label>
                                            <input type="checkbox" class="flat-red" checked>
                                        </label>                                
                                        <label>                                    
                                            {{$row->theloai_ten}}
                                        </label>
                                    @endforeach
                                <span class="help-block"><?php echo isset($add_phim_theloai_error)?$add_phim_theloai_error:''; ?></span>
                            </div>
                             
                        </div>
                        
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger" name="btn" value="add">Thêm</button>
                        </div>
                    </form>
                </div>                              
            </div>            
        </div>        
    </div>
    <script>
        $( document ).ready(function() {
            $('#imgPhimDragDrop').on(
                'dragover',
                function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            );
            $('#imgPhimDragDrop').on(
                'dragenter',
                function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            );
            $('#imgPhimDragDrop').on(
                'drop',
                function(e){
                    if(e.originalEvent.dataTransfer){
                        if(e.originalEvent.dataTransfer.files.length) {
                            e.preventDefault();
                            e.stopPropagation();
                            /*UPLOAD FILES HERE*/
                            uploadDragDropImagePhim(e.originalEvent.dataTransfer.files);
                        }   
                    }
                }
            );        
        });
        
        function autoUploadImage() {
            sendImagePhim($('#selectFileImage').prop('files')[0]);
        }
        function uploadDragDropImagePhim(files){    
            console.log(files[0]);
            sendImagePhim(files[0]);
        }
        function sendImagePhim(dataFile){
            var file_data = dataFile;
            var form_data = new FormData();
            form_data.append('image', file_data);
            $.ajax({
                    url: '{{url("quan-ly/phim/upload-image")}}', // point to server-side PHP script 
                    dataType: 'text', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (php_script_response) {
                        console.log(php_script_response);
                        var urlImage = '{{url("/")}}/'+php_script_response;
                        $('#imgPhimDragDrop').attr('src', urlImage);
                        $('#add_phim_image').val(urlImage);
                    }
            });
        }
    </script>
</section>