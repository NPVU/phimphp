<section class="content-header">
    <h1>
        DANH SÁCH TẬP - {{$phim[0]->phim_ten}}
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
                    <h3 class="box-title"></h3>
                    <div style="float:right">
                        @if(sizeof($list) < $phim[0]->phim_sotap)
                        <button type="button" class="btn btn-danger" 
                                onclick="preAddTapPhim()">
                            Thêm tập
                        </button>
                        @endif
                        <a href="{{ session('backURLAdmin') }}" class="btn btn-warning">
                            <i class="fa fa-backward"></i> Trở về
                        </a>
                    </div>
                </div>                
                <div class="box-body text-center">
                    <table class="table table-hover" style="font-size:1em;">                           
                            <thead>
                                <tr class="bg-primary">                                                                
                                    <th scope="col" class="text-center" style="width: 10%">Tập số</th>
                                    <th scope="col" class="text-center" style="width: 10%">Tập hiển thị</th>
                                    <th scope="col" class="text-left" style="width: 25%">Tên tập</th>
                                    <th scope="col" class="text-center" style="width: 10%">Chất lượng</th>
                                    <th scope="col" class="text-left" style="width: 10%">VS/TM</th>
                                    <th scope="col" class="text-center" style="width: 10%">Lượt xem</th>                                                                
                                    <th scope="col" class="text-left" style="width: 10%">Host</th>
                                    <th scope="col" class="text-center" style="width: 15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $row)
                                <tr>
                                    <td class="text-center">{{$row->tap_tapso}}</td>
                                    <td class="text-center">{{$row->tap_tapsohienthi}}</td>
                                    <td>{{$row->tap_ten==null?'N/A':$row->tap_ten}}</td>
                                    <td class="text-center">
                                        @if($row->tap_chatluong == 1)
                                        360p
                                        @elseif($row->tap_chatluong == 2)
                                        480p
                                        @elseif($row->tap_chatluong == 3)
                                        720p
                                        @elseif($row->tap_chatluong == 4)
                                        1080p
                                        @endif
                                    </td>
                                    <td>{{$row->tap_thuyetminh == 0?'VS':'TM'}}</td>
                                    <td class="text-center">{{$row->tap_luotxem}}</td>
                                    <td class="text-left">
                                    @if($row->tap_googlelink != '')
                                       Google
                                    @endif
                                    @if($row->tap_openloadlink != '')
                                        ,Openload
                                    @endif
                                    @if($row->tap_youtubelink != '')
                                        ,Youtube
                                    @endif
                                    @if($row->tap_facebooklink != '')
                                        ,Facebook
                                    @endif
                                    </td>
                                    <td class="text-center">                                      
                                        <div class="list-action-icon">                                        
                                            <span onclick="preEditTap({{$row->tap_id}}, '{{$row->tap_tapsohienthi}}')" data-toggle="tooltip" title="Sửa tập">
                                                <i class="fa fa-edit text-light-blue"></i>
                                            </span>
                                            <span onclick="preDelTap({{$row->tap_id}}, '{{$row->tap_tapsohienthi}}')" data-toggle="tooltip" title="Xóa tập">
                                                <i class="fa fa-close text-light-red"></i>
                                            </span>                                                             
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                   
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" style="background:lightgrey; margin-top:20px">
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3"><b>G</b>: Server Google</div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3"><b>O</b>: Server Openload</div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3"><b>Y</b>: Server Youtube</div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3"><b>F</b>: Server Facebook</div>
                    </div>
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
                        <div class="form-group chatluong">
                            <label>Chất lượng</label>
                            <select name="chatluong" id="chatluong" class="form-control">
                                <option value="1">360p</option>
                                <option value="2">480p</option>
                                <option value="3">720p</option>
                                <option value="4">1080p</option>
                                <option value="5">2K</option>
                                <option value="6">4K</option>
                            </select>                                                        
                        </div>
                        <div class="form-group tapphim_luotxem">
                            <label>Lượt xem</label>
                            <input type="number" id="tapphim_luotxem" name="tapphim_luotxem" class="form-control" value="" placeholder=""/>
                            <span class="help-block tapphim_luotxem_error"></span>
                        </div>
                        <div class="form-group">                            
                            <input type="checkbox" name="thongbao" class="flat-red" value="true" />
                            <label>Thông báo</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group facebooklink">
                            <label>ID Facebook</label>
                            <div class="input-group">                        
                                <input type="text" id="facebookLink" name="facebookLink" value="" placeholder="Nhập ID Facebook ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkFacebookLink" class="btn btn-success" onclick="checkVideo('Facebook')">
                                        <span class="btnCheckFacebookLink">Kiểm tra</span>
                                        <i class="fa iconCheckFacebookLink"></i>
                                    </button>
                                </div>
                            </div> 
                            <span class="help-block facebook_link_error"></span>
                        </div>                        
                        <div class="form-group youtube_link">
                            <label>Embed 1</label>
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
                            <label>Embed 2</label>
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
                        <div class="form-group google2_link">
                            <label>Link Google Photos 2</label>
                            <div class="input-group">                        
                                <input type="text" id="google2Link" name="google2Link" value="" placeholder="Nhập link google photos 2 ..." class="form-control" />
                                <div class="input-group-btn">
                                    <button type="button" name="btn" value="checkGoogle2Link" class="btn btn-success" onclick="checkVideo('Google2')">
                                        <span class="btnCheckGoogle2Link">Kiểm tra</span>
                                        <i class="fa iconCheckGoogle2Link"></i>
                                    </button>
                                </div>
                            </div>  
                            <span class="help-block google2_link_error"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label>Kiểm tra link</label>
                        </div>
                        <video id="videoCheck" src="" width="100%" controls="true"></video>
                    </div>

                    <div class="col-md-12 text-center" style="margin-top:20px">                        
                        <button type="button" name="btn" class="btn btn-primary" onclick="return next();">Lưu và tiếp tục</button>
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
    <div id="modal-add-tap" data-izimodal-transitionin="fadeInDown">
        <form method="POST" action="{{url('quan-ly/phim/danh-sach-tap/add')}}">
            {{csrf_field()}}
            <input type="hidden" name="phim_id" value="{{$phim[0]->phim_id}}" />
            <input type="hidden" id="phim_sotap" value="{{$phim[0]->phim_sotap}}" />            
            <div class="modal-body">        
                <div class="row">          
                    <div class="col-md-12 text-center">
                        <div class="form-group">                        
                            <strong style="color: lightseagreen;font-size: 1.5em;">{{$phim[0]->phim_ten}} ({{$phim[0]->phim_sotap}} tập)</strong>                                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group add_tapphim_tap">
                            <label>Tập</label>
                            <input type="number" id="add_tapphim_tap" name="add_tapphim_tap" class="form-control required" value="0" placeholder=""/>
                            <span class="help-block add_tapphim_tap_error"></span>
                        </div>
                        <div class="form-group add_tapphim_taphienthi">
                            <label>Tập hiển thị</label>
                            <input type="text" id="add_tapphim_taphienthi" name="add_tapphim_taphienthi" class="form-control required" value="" placeholder=""/>
                            <span class="help-block add_tapphim_taphienthi_error"></span>
                        </div> 
                    </div>
                    <div class="col-md-12 text-center" style="margin-top:20px">
                        <button type="submit"onclick="return validFormAddTap();" name="btn" value="del" class="btn btn-danger">Cập nhật</button>
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
                
                $('#videoCheck').attr('src', '');
            },
            onOpened: function(modal){
                
            },
            onClosing: function(modal){               
                $('title').html('Danh Sách Tập - {{$phim[0]->phim_ten}}');                
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
        $('#modal-add-tap').iziModal({
            title:'Thêm tập',
            top:100,
            overlayClose: false,
            width: 500,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-plus',
            iconColor: 'white'
        });
        function preEditTap(tap, taphienthi){
            $('title').html('Chỉnh Sửa '+taphienthi+ ' - {{$phim[0]->phim_ten}}');            
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
                           $('#chatluong').val(data.content.tap_chatluong);
                           $('#facebookLink').val(data.content.tap_facebooklink);
                           $('#googleLink').val(data.content.tap_googlelink);
                           $('#google2Link').val(data.content.tap_googlelink2);
                           $('#youtubeLink').val(data.content.tap_youtubelink);
                           $('#openloadLink').val(data.content.tap_openloadlink);
                       }
                   }
                 });            
        }
        function preAddTapPhim(){
            $('#modal-add-tap').iziModal('open');
        }
        function validFormAddTap(){
            var tap = $('#add_tapphim_tap').val();
            var taphienthi = $('#add_tapphim_taphienthi').val();
            var valid = true;
            if(parseInt(tap) == 0 || parseInt(tap) > $('#add_phim_maxtap').val()){
                $('.add_tapphim_tap').addClass('has-error');
                $('.add_tapphim_tap_error').html('Tập hợp lệ trong khoảng 1 - '+$('#phim_sotap').val());
                valid = false;
            } else {
                $('.add_tapphim_tap').removeClass('has-error');
                $('.add_tapphim_tap_error').html('');
            }  
            if(taphienthi.trim() === "" || taphienthi.trim().length > 50){
                $('.add_tapphim_taphienthi').addClass('has-error');
                $('.add_tapphim_taphienthi_error').html('Tập hiển thị có tối đa 50 ký tự');
                valid = false;
            } else {
                $('.add_tapphim_taphienthi').removeClass('has-error');
                $('.add_tapphim_taphienthi_error').html('');
            }
            if(!valid){
                return false;
            }
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
            }else if(clas === 'Google2'){
                var url = "{{url('services/google/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            } else if(clas === 'Openload'){
                var url = "{{url('services/openload/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            } else if(clas === 'Youtube'){
                var url = "{{url('services/youtube/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
            } else {
                var url = "{{url('services/facebook/')}}"+"/?url="+link+"&token="+$('meta[name="csrf-token"]').attr('content');
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
            if($('#tapphim_luotxem').val() === ""){
                $('#tapphim_luotxem').val(0);
            }
            return true;
        }
        function next(){
            var taphienthi = $('#tapphim_taphienthi').val();            
            if(taphienthi.trim() === "" || taphienthi.trim().length > 50){
                $('.tapphim_taphienthi').addClass('has-error');
                $('.tapphim_taphienthi_error').html('Tập hiển thị có tối đa 50 ký tự');
                return false;
            } else {
                $('.tapphim_taphienthi').removeClass('has-error');
                $('.tapphim_taphienthi_error').html('');
            }
            if($('#tapphim_luotxem').val() === ""){
                $('#tapphim_luotxem').val(0);
            }
            var url = "{{url('quan-ly/phim/danh-sach-tap/')}}/{{$phim[0]->phim_id}}/"+$('meta[name="csrf-token"]').attr('content')+"/next";
            $.ajax({
                type: "POST",
                url: url,
                data: $("#fromEditTapPhim").serialize(),
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: function(data){
                    console.log(data);
                    showToast('success', '', 'Cập nhật thành công', true);
                    $('title').html('Chỉnh Sửa '+data[0].tap_tapsohienthi+' - {{$phim[0]->phim_ten}}');
                    $('button > span').html('Kiểm tra');
                    $('button > i').removeClass('fa-check');
                    $('button > i').removeClass('fa-close');
                    $('#videoCheck').attr('src', '');
                    $('.tapphim_tap').val(data[0].tap_tapso);
                    $('#tapphim_taphienthi').val(data[0].tap_tapsohienthi);
                    $('#tapphim_ten').val(data[0].tap_ten);
                    $('#tapphim_luotxem').val(data[0].tap_luotxem);
                    $('#chatluong').val(data[0].tap_chatluong);
                    $('#facebookLink').val(data[0].tap_facebooklink);
                    $('#googleLink').val(data[0].tap_googlelink);
                    $('#google2Link').val(data[0].tap_googlelink2);
                    $('#youtubeLink').val(data[0].tap_youtubelink);
                    $('#openloadLink').val(data[0].tap_openloadlink);
                }
            })
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