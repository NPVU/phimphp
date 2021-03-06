<ul class="menu-left-item">
  <li>
    <a href="javascript:void(0)" class="spotify" data-izimodal-open="#modal-feedback"><span>Góp ý</span><b class="fa fa-envelope"></b></a>
  </li>
  <li>
    <a href="javascript:void(0)" class="soundcloud" data-izimodal-open="#modal-error"><span>Báo lỗi</span><b class="fa fa-exclamation-triangle"></b></a>
  </li>
  <li>
    <a href="javascript:void(0)" class="skype" data-izimodal-open="#modal-request"><span>Yêu cầu</span><b class="fa fa-upload"></b></a>
  </li>
  <!--<li>
    <a href="#" class="dribbble"><span></span><b class=""></b></a>
  </li>-->
</ul>

<div id="modal-request" class="modal-support" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form id="frm-request">
                    <div class="form-group">
                        <label>Tên phim</label>
                        <input type="text" name="name" class="required request-name form-control" required placeholder="Nhập tên phim..."/>
                        <div class="input-invalid display-none">Tên phim là bắt buộc</div>
                    </div>
                    <div class="form-group">
                        <label>URL ảnh (nếu có)</label>
                        <input type="text" name="link" class="form-control" placeholder="Nhập url ảnh..."/>
                    </div>
                    <div class="form-group">
                        <label>Email (nếu có)</label>
                        <input type="text" name="email" class="form-control" placeholder="Nhập email để nhận thông báo..."/>
                    </div>
                </form>
                <div id="rs-request" class="display-none text-center" style="color:green">
                    <span class="fa fa-2x fa-check-circle"></span>
                    <h5><b>Yêu cầu đã được ghi nhận</b></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-primary btn-request-submit" onclick="submitYeuCau();">Yêu cầu</button>
                <button class="btn btn-primary btn-request-continue display-none" onclick="nextYeuCau();">Tiếp tục</button>
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>

    </div>
</div>

<div id="modal-error" class="modal-support" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form id="frm-error">                    
                    <div class="form-group">
                        <label>Email (nếu có)</label>
                        <input type="email" name="email" class="form-control" placeholder="Nhập email để nhận phản hồi..."/>
                    </div>
                    <div class="form-group">
                        <label>URL lỗi</label>
                        <input type="text" name="url" class="form-control" placeholder="Nhập url bị lỗi..."/>
                    </div>                    
                    <div class="form-group">
                        <label>Mô tả lỗi</label>
                        <input type="text" class="required error-content form-control" required name="content" placeholder="Nhập mô tả lỗi..."/>                                        
                        <div class="input-invalid display-none">Mô tả lỗi là bắt buộc</div>
                    </div>                    
                </form>
                <div id="rs-error" class="display-none text-center" style="color:green">
                    <span class="fa fa-2x fa-check-circle"></span>
                    <h5><b>Lỗi đã được ghi nhận</b></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-warning btn-error-submit" onclick="submitError();">Báo lỗi</button>
                <button class="btn btn-primary btn-error-continue display-none" onclick="nextError();">Tiếp tục</button>
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>

    </div>
</div>

<div id="modal-feedback" class="modal-support" data-izimodal-transitionin="comingInDown">
    <div class="modal-body" style="padding: 20px">        
        <div class="row">                
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form id="frm-feedback">                                       
                    <div class="form-group">
                        <label>Nội dung góp ý</label>
                        <input type="text" class="required feedback-content form-control" required name="content" placeholder="Nhập nội dung góp ý"/>                                        
                        <div class="input-invalid display-none">Nội dung góp ý là bắt buộc</div>
                    </div>                    
                </form>
                <div id="rs-feedback" class="display-none text-center" style="color:green">
                    <span class="fa fa-2x fa-check-circle"></span>
                    <h5><b>Góp ý đã được ghi nhận</b></h5>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <button class="btn btn-success btn-feedback-submit" onclick="submitFeedback();">Góp ý</button>
                <button class="btn btn-primary btn-feedback-continue display-none" onclick="nextFeedback();">Tiếp tục</button>
                <button class="btn btn-default" data-izimodal-close="">Đóng</button>
            </div>
        </div>

    </div>
</div>

<script>
    $('#modal-request').iziModal({
    title: 'Yêu Cầu Phim',        
    overlayClose: true,                        
    openFullscreen:false,
    headerColor: '#263238',
    icon: 'fa fa-upload',
    iconColor: 'white',
    onOpening: function(){
            $('#frm-request').get(0).reset();
            $('.input-invalid').addClass('display-none');
        }
    });  
$('#modal-error').iziModal({
    title: 'Báo lỗi',        
    overlayClose: true,                        
    openFullscreen:false,
    headerColor: '#263238',
    icon: 'fa fa-exclamation-triangle',
    iconColor: 'white',
    onOpening: function(){
            $('#frm-error').get(0).reset();
            $('.input-invalid').addClass('display-none');
        }
    });  
$('#modal-feedback').iziModal({
    title: 'Góp ý',        
    overlayClose: true,                        
    openFullscreen:false,
    headerColor: '#263238',
    icon: 'fa fa-envelope',
    iconColor: 'white',
    onOpening: function(){
            $('#frm-feedback').get(0).reset();
            $('.input-invalid').addClass('display-none');
        }
    });
</script>

<style>

*,
*:before,
*:after {
  box-sizing: border-box;
}
.input-invalid{
  color:red;
  font-style:italic;
}
.menu-left-item {
  list-style: none;
  position: fixed;
  top: 50%;
  left: 0%;
  padding:0px;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  z-index: 9999;
  font-weight: 600;
}
.menu-left-item li a {
  display: block;
  margin-left: -2px;
  height: 50px;
  width: 60px;
  border-radius: 0 5px 5px 0;
  border: 2px solid #000;
  background: #FFF;
  margin-bottom: 1em;
  transition: all .4s ease;
  color: #2980b9;
  text-decoration: none;
  line-height: 50px;
  position: relative;
}
.menu-left-item li a:hover {
  cursor: pointer;
  width: 140px;
  color: #fff;
}
.menu-left-item li a:hover span {
  left: 0;
}
.menu-left-item li a span {
  padding: 0 30px 0 15px;
  position: absolute;
  left: -120px;
  transition: left .4s ease;
}
.menu-left-item li a b {
  position: absolute;
  top: 50%;
  right: 20px;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  font-size: 1.5em;
}
.menu-left-item li .spotify {
  background: rgba(39, 174, 96, 0.1);
  border-color: #27ae60;
  color: #27ae60;
}
.menu-left-item li .spotify:hover {
  background: #27ae60;
}
.menu-left-item li .soundcloud {
  background: rgba(230, 126, 34, 0.1);
  border-color: #e67e22;
  color: #e67e22;
}
.menu-left-item li .soundcloud:hover {
  background: #e67e22;
}
.menu-left-item li .skype {
  background: rgba(34, 167, 240, 0.1);
  border-color: #22A7F0;
  color: #22A7F0;
}
.menu-left-item li .skype:hover {
  background: #22a7f0;
}
.menu-left-item li .dribbble {
  background: rgba(210, 82, 127, 0.1);
  border-color: #D2527F;
  color: #D2527F;
}
.menu-left-item li .dribbble:hover {
  background: #d2527f;
}
.modal-support input, .modal-support textarea {
    border-radius: 0px;
}
.required {
    border-left: 2px solid red;
}

/* entypo */
[class*="entypo-"]:before {
  font-family: 'entypo', sans-serif;
}
[class*="fontawesome-"]:before {
  font-family: 'fontawesome', sans-serif;
}
@media (max-width: 767px) {
    .menu-left-item{
      display:none;
    }
}
</style>
