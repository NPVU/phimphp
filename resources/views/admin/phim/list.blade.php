<section class="content-header">
    <h1>
        {{$phim[0]->phim_ten}}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li> 
        <li><a href="{{ url('/quan-ly/phim') }}"> Quản lý phim</a></li>
        <li class="active"><a href="{{ url('/quan-ly/phim/danh-sach-tap/') }}/{{$phim[0]->phim_id}}/{{$token}}">Danh sách tập</a></li>
    </ol>
</section>
<style>
    .btn {
        border-radius: 0px;
    }
</style>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách tập</h3>                                       
                </div>                
                <div class="box-body text-center">
                    @foreach ($list as $row)
                    <div class="col-sm-6 col-md-3 ">
                        <div class="input-group">                    
                            <span class="btn btn-primary " 
                                  style="width:100px;margin-bottom: 5px;"
                                  onclick="preEditTap({{$row->tap_id}})">
                                {{$row->tap_tapsohienthi}}
                            </span>
                            <span class="btn btn-danger " 
                                  style="width:50px;margin-bottom: 5px;"
                                  onclick="preDelTap({{$row->tap_id}}, '{{$row->tap_tapsohienthi}}')">
                                Xóa
                            </span>
                        </div>  
                    </div>
                    @endforeach
                </div>                              
            </div>            
        </div>        
    </div>    
    <div id="modal-edit-tapphim" data-izimodal-transitionin="fadeInDown">
        <form id="fromEditTapPhim" method="POST">  
            {{csrf_field()}}
            <input type="hidden" id="edit_phim_id" name="edit_phim_id" value="{{$phim[0]->phim_id}}" />
            <input type="hidden" id="edit_phim_maxtap" value="{{$phim[0]->phim_sotap}}" />
            <input type="hidden" class="tapphim_tap" name="tapphim_tap" value="" />
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-center">
                        <div class="form-group">                        
                            <strong style="color: lightseagreen;font-size: 1.5em;" id="edit_phim_ten">{{$phim[0]->phim_ten}}</strong>                                            
                        </div>
                     </div>
                    <div class="col-md-4">
                        <div class="form-group tapphim_tap">
                            <label>Tập</label>
                            <input type="number" class="form-control required tapphim_tap" value="" placeholder="" disabled="true"/>
                            <span class="help-block tapphim_tap_error"></span>
                        </div>
                        <div class="form-group tapphim_taphienthi">
                            <label>Tập hiển thị</label>
                            <input type="text" id="tapphim_taphienthi" name="tapphim_taphienthi" class="form-control required" value="" placeholder=""/>
                            <span class="help-block tapphim_taphienthi_error"></span>
                        </div>                        
                        <div class="form-group tapphim_ten">
                            <label>Tên tập phim</label>
                            <input type="text" id="tapphim_ten" name="tapphim_ten" class="form-control" value="" placeholder=""/>
                            <span class="help-block tapphim_ten_error"></span>
                        </div>
                        <div class="form-group tapphim_luotxem">
                            <label>Lượt xem</label>
                            <input type="number" id="tapphim_luotxem" name="tapphim_luotxem" class="form-control" value="" placeholder=""/>
                            <span class="help-block tapphim_luotxem_error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group localhost_link">
                            <label>Link Localhost</label>
                            <div class="input-group">                        
                                <input type="text" id="localhostLink" name="localhostLink" value="" placeholder="Nhập link localhost ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkLocalhostLink" class="btn btn-success" onclick="checkVideo('Localhost')">
                                        <span class="btnCheckLocalhostLink">Kiểm tra</span>
                                        <i class="fa iconCheckLocalhostLink"></i>
                                    </button>
                                </div>
                            </div> 
                            <span class="help-block localhost_link_error"></span>
                        </div>
                        <div class="form-group google_link">
                            <label>Link Google Photos</label>
                            <div class="input-group">                        
                                <input type="text" name="googleLink" id="googleLink" value="" placeholder="Nhập link google photos ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkGoogleLink" class="btn btn-success" onclick="checkVideo('Google')">
                                        <span class="btnCheckGoogleLink">Kiểm tra</span>
                                        <i class="fa iconCheckGoogleLink"></i>
                                    </button>                                    
                                </div>
                            </div> 
                            <span class="help-block google_link_error"></span>
                        </div>
                        <div class="form-group youtube_link">
                            <label>Link Youtube</label>
                            <div class="input-group">                        
                                <input type="text" id="youtubeLink" name="youtubeLink" value="" placeholder="Nhập link youtube ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkYoutubeLink" class="btn btn-success" onclick="checkVideo('Youtube')">
                                        <span class="btnCheckYoutubeLink">Kiểm tra</span>
                                        <i class="fa iconCheckYoutubeLink"></i>
                                    </button>
                                </div>
                            </div>  
                            <span class="help-block youtube_link_error"></span>
                        </div>
                        <div class="form-group openload_link">
                            <label>Link Openload</label>
                            <div class="input-group">                        
                                <input type="text" id="openloadLink" name="openloadLink" value="" placeholder="Nhập link openload ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkOpenloadLink" class="btn btn-success" onclick="checkVideo('Openload')">
                                        <span class="btnCheckOpenloadLink">Kiểm tra</span>
                                        <i class="fa iconCheckOpenloadLink"></i>
                                    </button>
                                </div>
                            </div>  
                            <span class="help-block openload_link_error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label>Kiểm tra link</label>
                        </div>
                        <video id="videoCheck" src="" width="100%" controls="true"></video>
                    </div>

                    <div class="col-md-12 text-center" style="margin-top:20px">                        
                        <button type="submit" name="btn" class="btn btn-danger" onclick="return vf();">Cập nhật</button>                    
                        <button type="button" class="btn btn-default" data-izimodal-close="">Đóng</button>
                    </div>
                </div>        
            </div>
        </form>        
    </div>
    <div id="modal-del-tap" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/phim/danh-sach-tap/delete')}}">
            {{csrf_field()}}
            <input type="hidden" name="phim_id" value="{{$phim[0]->phim_id}}" />
            <input type="hidden" id="del_tap_id" name="del_tap_id" value="" />
            <input type="hidden" id="del_tap_hienthi" name="del_tap_hienthi" value="" />
            <div class="modal-body">        
                <div class="row">                
                    <div class="col-md-12 text-center">
                        Bạn có đồng ý xóa tập 
                        <strong style="color: lightseagreen;font-size: 1.5em;" class="del_tap_hienthi"></strong>
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
    <script>
        $('#modal-edit-tapphim').iziModal({
            title:'Chỉnh sửa tập phim',
            top:0,
            overlayClose: false,            
            bodyOverflow: true,
            openFullscreen: true,
            zindex: 1040,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-plus-circle',
            iconColor: 'white',
            onOpening: function(modal){
                modal.startLoading();
            },
            onOpened: function(modal){
                modal.stopLoading();
            },
        });
        $('#modal-del-tap').iziModal({
            title:'Xác nhận',
            top:100,
            overlayClose: false,
            width: 500,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-check',
            iconColor: 'white'
        });
        function preEditTap(tap){
            $('#modal-edit-tapphim').iziModal('open');
            $('*').removeClass('has-error');
            $('.help-block').html('');
            $('.btn > i').removeClass('fa-check');
            $('.btn > i').removeClass('fa-close');
            var url = "{{url('services/get-info-tap/')}}/?tap="+tap+"&token="+$('meta[name="csrf-token"]').attr('content');            
            $.ajax({
                   type: "GET",
                   url: url,                   
                   success: function(data)
                   {
                       console.log(data);
                       if(data.status === 1){
                           $('.tapphim_tap').val(data.content.tap_tapso);
                           $('#tapphim_taphienthi').val(data.content.tap_tapsohienthi);
                           $('#tapphim_ten').val(data.content.tap_ten);
                           $('#tapphim_luotxem').val(data.content.tap_luotxem);
                           $('#localhostLink').val(data.content.tap_localhostlink);
                           $('#googleLink').val(data.content.tap_googlelink);
                           $('#youtubeLink').val(data.content.tap_youtubelink);
                           $('#openloadLink').val(data.content.tap_openloadlink);
                       }
                   }
                 });            
        }
        function preDelTap(tap, tenhienthi){
            $('#del_tap_id').val(tap);
            $('#del_tap_hienthi').val(tenhienthi);
            $('.del_tap_hienthi').html(tenhienthi);
            $('#modal-del-tap').iziModal('open');
        }
        function checkVideo(clas){
            var clasLower = clas.toLowerCase();
            console.log(clas);
            console.log(clasLower);
            var link = $('#'+clasLower+'Link').val();
            $('.iconCheck'+clas+'Link').removeClass('fa-check');
            $('.iconCheck'+clas+'Link').removeClass('fa-close');
            if(link.trim() === ""){
                $('.'+clasLower+'_link').addClass('has-error');
                $('.'+clasLower+'_link_error').html('Link kiểm tra không được bỏ trống');
                return false;
            } else {
                $('.'+clasLower+'_link').removeClass('has-error');
                $('.'+clasLower+'_link_error').html('');
            }
            $('.btnCheck'+clas.toString()+'Link').html('Kiểm tra ...');
            if(clas === 'Google'){
                var url = "{{url('services/google/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            } else if(clas === 'Openload'){
                var url = "{{url('services/openload/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            } else if(clas === 'Youtube'){
                var url = "{{url('services/youtube/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            } else {
                var url = "{{url('services/localhost/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            }
            $.ajax({
                type: "GET",
                url: url,
                success: function(data){
                    console.log(data);
                    if(data.status === 1){
                        $('#videoCheck').attr('src', data.content['360p']);
                        $('.btnCheck'+clas+'Link').html('Kiểm tra');                        
                        $('.iconCheck'+clas+'Link').addClass('fa-check');
                        $('.'+clasLower+'_link').removeClass('has-error');
                        $('.'+clasLower+'_link_error').html('');
                    }
                }
            }).fail(function() {
                console.log('Link '+clas+' không đúng');
                $('#videoCheck').attr('src', '');
                $('.'+clasLower+'_link').addClass('has-error');
                $('.'+clasLower+'_link_error').html('Link '+clas+' không đúng');
                $('.btnCheck'+clas+'Link').html('Kiểm tra');                
                $('.iconCheck'+clas+'Link').addClass('fa-close');
            });
        }
        function vf(){
            var taphienthi = $('#tapphim_taphienthi').val();            
            if(taphienthi.trim() === "" || taphienthi.trim().length > 50){
                $('.tapphim_taphienthi').addClass('has-error');
                $('.tapphim_taphienthi_error').html('Tập hiển thị có tối đa 50 ký tự');
                return false;
            } else {
                $('.tapphim_taphienthi').removeClass('has-error');
                $('.tapphim_taphienthi_error').html('');
            }
            return true;
        }
    </script>
</section>