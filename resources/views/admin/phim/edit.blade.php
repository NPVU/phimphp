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
                                ảnh icon
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo isset($edit_phim_image_error)?'has-error':''; ?>">
                                    <input type="hidden" name="edit_phim_id" value="{{$phim[0]->phim_id}}" />
                                    <input type="hidden" name="edit_phim_image" id="edit_phim_image" value="<?php echo isset($_POST['edit_phim_image'])?$_POST['edit_phim_image']:'' ?>" />
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
                                    <label class="control-label" for="edit_phim_image_link"><small>hoặc</small> Đường dẫn ảnh</label>
                                    <div class="input-group">
                                        <input type="text" id="edit_phim_image_link" name="edit_phim_image_link" 
                                               class="form-control" value="<?php echo isset($_POST['edit_phim_image_link']) ? $_POST['edit_phim_image_link'] : $phim[0]->phim_hinhanh ?>"
                                               placeholder="VD: http://imurg.org/naruto.png"/>
                                        <span class="help-block"><?php echo isset($edit_phim_image_link_error)?$edit_phim_image_link_error:''; ?></span>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success" onclick="loadIcon()">Load</button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-12 box-body-title">
                                ảnh nền
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo isset($phim_background_error)?'has-error':''; ?>">
                                    <input type="hidden" name="phim_background" id="phim_background" value="<?php echo isset($_POST['phim_background'])?$_POST['phim_background']:'' ?>" />
                                    <input type="file" class="form-control display-none" id="selectFileBackground" onchange="autoUploadBackground()" />
                                    <img src="<?php if(isset($_POST['phim_background']) && !empty($_POST['phim_background'])) :?>
                                         <?php echo $_POST['phim_background'] ?>
                                         <?php else :?>
                                         {{$phim[0]->phim_hinhnen}}
                                         <?php endif; ?>"
                                         onclick="$('#selectFileBackground').click()" 
                                         class="img-select-file npv-add-image" id="backgroundPhimDragDrop"/> 
                                    <span class="help-block"><?php echo isset($phim_background_error)?$phim_background_error:''; ?></span>
                                </div>
                                <div class="form-group <?php echo isset($phim_background_link_error)?'has-error':''; ?>">
                                    <label class="control-label" for="phim_background_link"><small>hoặc</small> Đường dẫn ảnh</label>
                                    <div class="input-group">
                                        <input type="text" id="phim_background_link" name="phim_background_link" 
                                               class="form-control" value="<?php echo isset($_POST['phim_background_link']) ? $_POST['phim_background_link'] : $phim[0]->phim_hinhnen ?>"
                                               placeholder="VD: http://imurg.org/naruto.png (Full HD)"/>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-success" onclick="loadBackground()">Load</button>
                                        </div>
                                    </div>
                                    <span class="help-block"><?php echo isset($phim_background_link_error)?$phim_background_link_error:''; ?></span>
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
                            
                            <div class="form-group <?php echo isset($edit_phim_nguon_error)?'has-error':''; ?>">
                                <label>Nguồn</label>
                                <input type="text" name="edit_phim_nguon" class="form-control" 
                                       value="<?php echo isset($_POST['edit_phim_nguon']) ? $_POST['edit_phim_nguon'] : $phim[0]->phim_nguon ?>"
                                       placeholder="VD: anime47, phimmoi, vuighe ...."/>
                                <span class="help-block"><?php echo isset($edit_phim_nguon_error)?$edit_phim_nguon_error:''; ?></span>
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
                            <a href="{{url('quan-ly/phim/')}}" class="btn btn-warning" ><i class="fa fa-backward"></i> Trở về</a>
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
                            uploadDragDropImagePhim(e.originalEvent.dataTransfer.files, 'icon');
                        }   
                    }
                }
            );        
        });
        $( document ).ready(function() {
            $('#backgroundPhimDragDrop').on(
                'dragover',
                function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            );
            $('#backgroundPhimDragDrop').on(
                'dragenter',
                function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            );
            $('#backgroundPhimDragDrop').on(
                'drop',
                function(e){
                    if(e.originalEvent.dataTransfer){
                        if(e.originalEvent.dataTransfer.files.length) {
                            e.preventDefault();
                            e.stopPropagation();
                            /*UPLOAD FILES HERE*/
                            uploadDragDropImagePhim(e.originalEvent.dataTransfer.files, 'background');
                        }   
                    }
                }
            );        
        });
        
        function autoUploadImage() {
            sendImagePhim($('#selectFileImage').prop('files')[0], 'icon');
        }
        function autoUploadBackground() {
            sendImagePhim($('#selectFileBackground').prop('files')[0], 'background');
        }
        
        function uploadDragDropImagePhim(files, type){    
            console.log(files[0]);
            sendImagePhim(files[0], type);
        }
        function sendImagePhim(dataFile, type){
            var file_data = dataFile;
            var form_data = new FormData();
            form_data.append('image', file_data);
            form_data.append('type', type);
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
                    success: function (data) {
                        console.log(data);
                        var urlImage = '{{url("/")}}/'+data;                        
                         if(type === 'icon'){
                            $('#imgPhimDragDrop').attr('src', urlImage);
                            $('#edit_phim_image').val(urlImage);
                        } else {
                            $('#backgroundPhimDragDrop').attr('src', urlImage);
                            $('#phim_background').val(urlImage);
                        }
                    }
            });
        }
        
        function loadIcon(){
            var url = $('#edit_phim_image_link').val();
            $('#imgPhimDragDrop').attr('src', url);            
        }
        
        function loadBackground(){
            var url = $('#phim_background_link').val();
            $('#backgroundPhimDragDrop').attr('src', url);            
        }
        
        $(function () {
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    </script>    
</section>