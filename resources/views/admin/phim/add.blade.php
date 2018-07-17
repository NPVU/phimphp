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
                    <div class="col-md-4">
                        <div class="col-md-12">
                            <input type="file" name="add_phim_image" class="form-control display-none" id="selectFileImage" onchange="autoUploadImage()" />
                            <img src="{{asset('public/img/themes/jquery-file-upload-scripts.png')}}"
                                onclick="$('#selectFileImage').click()" 
                                class="img-select-file npv-add-image" id="imgPhimDragDrop"/>                            
                        </div>                        
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 box-body-title">
                            Thông tin phim
                        </div>
                        <div class="form-group">
                            <label>Tên phim</label>
                            <input type="text" name="add_phim_ten" class="form-control" value="<?php echo isset($_POST['add_phim_ten'])?$_POST['add_phim_ten']:'' ?>" />
                        </div>
                        
                        <div class="form-group">
                            <label>Số tập</label>
                            <input type="number" name="add_phim_sotap" class="form-control" value="<?php echo isset($_POST['add_phim_sotap'])?$_POST['add_phim_sotap']:'' ?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 box-body-title">
                            Thông tin liên quan
                        </div>                        
                    </div>
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
                        $('#imgPhimDragDrop').attr('src', '{{url("/")}}/'+php_script_response);                        
                    }
            });
        }
    </script>
</section>