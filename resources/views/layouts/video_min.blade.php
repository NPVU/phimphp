@if(strcmp($_GET['s'], md5('google'))==0)<video id="my-player" class="video-js"> <source src="" id="google360p" type="video/mp4"/> <source src="" id="google720p" type="video/mp4"/> <source src="" id="google1080p" type="video/mp4"/> <p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video </a> </p></video>@elseif(strcmp($_GET['s'], md5('openload'))==0)<video id="my-player" class="video-js" src="" controls="true" autoplay="true"> <p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video </a> </p></video><div id="modal-captcha" data-izimodal-transitionin="fadeInUp"> <div class="modal-body" style="padding-bottom: 20px"> <div> <img id="captcha" src="" alt="captcha" title="Mã xác nhận" width="25%"/> <i id="iconLoadingCaptcha" class="fa fa-sync-alt fa-spin display-none" title="Loading..."></i> <label id="messageErrorCaptcha" class="text-danger display-none">Mã xác nhận không đúng, vui lòng nhập lại !</label> </div><div style="width:90%;"> <div class="input-group"> <input type="text" id="txtCaptcha" class="form-control" placeholder="Nhập mã xác nhận" aria-label="Nhập mã xác nhận" aria-describedby="basic-addon2"> <div class="input-group-btn"> <button type="button" class="btn btn-primary btn-outline-secondary" title="Làm mới mã xác nhận" onclick="getTicket()"> <span class="fa fa-x fa-redo-alt"></span> </button> <button type="button" class="btn btn-primary btn-outline-secondary"title="Xác nhận" onclick="getVideo()"> <span class="fa fa-x fa-check-circle btn-api-video" ></span> </button> </div></div></div></div></div><script>$('#modal-captcha').iziModal({title: 'Nhập captcha để xem video', overlayClose:false, headerColor: '#263238', icon: 'fa fa-shield-alt', onOpening: function(modal){modal.startLoading();}, onOpened: function(modal){modal.stopLoading();}}); </script>@elseif(strcmp($_GET['s'], md5('youtube'))==0) @if(!empty($tap[0]->tap_youtubelink)) <iframe class="npv-youtube" src="{{$tap[0]->tap_youtubelink}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="border: 1px solid white" width="100%" height="380"></iframe> @else <script>window.location.href=$('meta[name="url"]').attr('content')+'/xem-phim/'+"{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($phim[0]->phim_ten))))}}/?pid="+getParameterByName('pid','')+"&t="+getParameterByName('t','')+"&s={{md5('google')}}"; </script> @endif @else<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px;"> <h4 style="color:red">Vui lòng không tự ý sửa đường dẫn trên trình duyệt</h4></div>@endif 