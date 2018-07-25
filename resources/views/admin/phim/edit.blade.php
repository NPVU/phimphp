<section class="content-header">
    <h1>
        CHỈNH SỬA PHIM
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="{{ url('/quan-ly/phim') }}"> Quản lý phim</a></li>
        <li class="active"><a href="{{ url('/quan-ly/phim/chinh-sua/') }}/{{$phim[0]->phim_id}}/{{$token}}">Chỉnh sửa</a></li>
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
                                <div class="form-group <?php echo isset($edit_phim_image_error)?'has-error':''; ?>">
                                    <input type="hidden" name="edit_phim_id" value="{{$phim[0]->phim_id}}" />
                                    <input type="hidden" name="edit_phim_image" id="edit_phim_image" value="<?php echo isset($_POST['edit_phim_image'])?$_POST['edit_phim_image']:$phim[0]->phim_hinhanh ?>" />
                                    <input type="file" class="form-control display-none" id="selectFileImage" onchange="autoUploadImage()" />
                                    <img src="<?php if(isset($_POST['edit_phim_image']) && !empty($_POST['edit_phim_image'])) :?>
                                         <?php echo $_POST['edit_phim_image'] ?>
                                         <?php else :?>
                                         {{$phim[0]->phim_hinhanh}}
                                         <?php endif; ?>"
                                         onclick="$('#selectFileImage').click()" 
                                         class="img-select-file npv-add-image" id="imgPhimDragDrop"/> 
                                    <span class="help-block"><?php echo isset($edit_phim_image_error)?$edit_phim_image_error:''; ?></span>
                                </div>
                                <div class="form-group <?php echo isset($edit_phim_image_link_error)?'has-error':''; ?>">
                                    <label class="control-label" for="edit_phim_image_link"><small>hoặc</small> Đường dẫn ảnh bìa</label>
                                    <input type="text" id="edit_phim_image_link" name="edit_phim_image_link" 
                                           class="form-control" value="<?php echo isset($_POST['edit_phim_image_link']) ? $_POST['edit_phim_image_link'] : $phim[0]->phim_hinhanh ?>"
                                           placeholder="VD: http://imurg.org/naruto.png"/>
                                    <span class="help-block"><?php echo isset($edit_phim_image_link_error)?$edit_phim_image_link_error:''; ?></span>
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 box-body-title">
                                Thông tin phim
                            </div>
                            
                            <div class="form-group <?php echo isset($edit_phim_ten_error)?'has-error':''; ?>">
                                <label class="control-label" for="edit_phim_ten">Tên phim</label>
                                <input type="text" id="edit_phim_ten" name="edit_phim_ten" 
                                       class="form-control required" value="<?php echo isset($_POST['edit_phim_ten']) ? $_POST['edit_phim_ten'] : $phim[0]->phim_ten ?>"
                                       placeholder="VD: Naruto"/>
                                <span class="help-block"><?php echo isset($edit_phim_ten_error)?$edit_phim_ten_error:''; ?></span>
                            </div>                            
                            
                            <div class="form-group <?php echo isset($edit_phim_sotap_error)?'has-error':''; ?>">
                                <label>Số tập</label>
                                <input type="number" name="edit_phim_sotap" class="form-control required" 
                                       value="<?php echo isset($_POST['edit_phim_sotap']) ? $_POST['edit_phim_sotap'] : $phim[0]->phim_sotap ?>"
                                       placeholder="VD: 24"/>
                                <span class="help-block"><?php echo isset($edit_phim_sotap_error)?$edit_phim_sotap_error:''; ?></span>
                            </div>
                            
                            <div class="form-group <?php echo isset($edit_phim_nam_error)?'has-error':''; ?>">
                                <label>Năm phát hành</label>
                                <input type="number" name="edit_phim_nam" class="form-control required" 
                                       value="<?php echo isset($_POST['edit_phim_nam']) ? $_POST['edit_phim_nam'] : $phim[0]->phim_nam ?>"
                                       placeholder="VD: 2018"/>
                                <span class="help-block"><?php echo isset($edit_phim_nam_error)?$edit_phim_nam_error:''; ?></span>
                            </div>
                            
                            <div class="form-group <?php echo isset($edit_phim_tenkhac_error)?'has-error':''; ?>">
                                <label class="control-label" for="edit_phim_tenkhac">Tên phụ (tên khác)</label>
                                <input type="text" id="edit_phim_tenkhac" name="edit_phim_tenkhac" 
                                       class="form-control" value="<?php echo isset($_POST['edit_phim_tenkhac']) ? $_POST['edit_phim_tenkhac'] : $phim[0]->phim_tenkhac ?>"
                                       placeholder="VD: Naruto (Phần 1)"/>
                                <span class="help-block"><?php echo isset($edit_phim_tenkhac_error)?$edit_phim_tenkhac_error:''; ?></span>
                            </div>
                            
                            <div class="form-group <?php echo isset($edit_phim_gioithieu_error)?'has-error':''; ?>">
                                <label>Giới thiệu</label>
                                <textarea name="edit_phim_gioithieu" class="form-control" rows="5">
                                    <?php echo isset($_POST['edit_phim_gioithieu']) ? $_POST['edit_phim_gioithieu'] : $phim[0]->phim_gioithieu ?>
                                </textarea>     
                                <span class="help-block"><?php echo isset($edit_phim_gioithieu_error)?$edit_phim_gioithieu_error:''; ?></span>
                            </div>                            
                            
                            <div class="form-group <?php echo isset($edit_phim_tag_error)?'has-error':''; ?>">
                                <label>Tag</label>
                                <input type="text" name="edit_phim_tag" class="form-control" 
                                       value="<?php echo isset($_POST['edit_phim_tag']) ? $_POST['edit_phim_tag'] : $phim[0]->phim_tag ?>"
                                       placeholder="VD: Naruto, Ninja, Cửu vĩ hồ"/>
                                <span class="help-block"><?php echo isset($edit_phim_tag_error)?$edit_phim_tag_error:''; ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 box-body-title">
                                Thông tin liên quan
                            </div>
                            <div class="form-group">
                                
                            </div>                            
                            <div class="form-group <?php echo isset($edit_phim_theloai_error)?'has-error':''; ?>">
                                <label>Thể loại</label>
                                    @foreach ($listTheLoai as $row)
                                        <br/>
                                        <label>
                                            <input type="checkbox" class="flat-red" 
                                                   name="edit_phim_theloai[]" value="{{$row->theloai_id}}"
                                                   <?php if(isset($_POST['edit_phim_theloai'])): ?>
                                                   <?php echo in_array($row->theloai_id, $_POST['edit_phim_theloai'])?'checked':''?>
                                                   <?php else: echo in_array($row->theloai_id, is_null($phim[0]->theloai_id)?'()':json_decode($phim[0]->theloai_id))?'checked':''?>
                                                   <?php endif; ?>
                                                   >
                                        </label>                                
                                        <label>                                    
                                            {{$row->theloai_ten}}
                                        </label>
                                    @endforeach
                                <span class="help-block"><?php echo isset($edit_phim_theloai_error)?$edit_phim_theloai_error:''; ?></span>
                            </div>
                             
                        </div>
                        
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger" name="btn" value="edit">Cập nhật</button>
                            <a href="{{url('quan-ly/phim/')}}" class="btn btn-warning" >Trở về</a>
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
                        $('#edit_phim_image').val(urlImage);
                    }
            });
        }
    </script>    
</section>