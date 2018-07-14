<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="{{ app()->getLocale() }}">
    <link href="{{ asset('css/video-player.css') }}" rel="stylesheet" type="text/css" />
    <body>        
        <button onclick="getTicket()" title="xem video">view video</button>           
        <div id="modal-captcha" class="display-none" data-izimodal-transitionin="fadeInUp">            
            <div class="modal-body">                
                <div>
                    <img id="captcha" src="" alt="captcha" title="Mã xác nhận" width="25%"/> 
                    <i id="iconLoadingCaptcha" class="fa fa-sync-alt fa-spin display-none" title="Loading..."></i>                                                   
                    <label id="messageErrorCaptcha" class="text-danger display-none">Mã xác nhận không đúng, vui lòng nhập lại !</label>
                </div>
                <div class="input-group">
                    <input type="text" id="txtCaptcha" class="form-control" placeholder="Nhập mã xác nhận" aria-label="Nhập mã xác nhận" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary fa fa-2x fa-redo-alt"                                
                                title="Làm mới mã xác nhận" onclick="getTicket()"/>                                                    
                        <button type="button" class="btn btn-outline-secondary fa fa-2x fa-check-circle btn-api-video" title="Xác nhận" onclick="getVideo()"/>                                                                         
                    </div>
                </div>                         
            </div>
        </div>
        <div id="modal-video" class="display-none" data-izimodal-transitionin="fadeInDown">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                    <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8">
                        @include('plugin.video')
                    </div>
                </div>
            </div>
        </div> 
        
    </body>       
    <script>                        
         $('#modal-captcha').iziModal({
             overlayClose:false,
             onOpening: function(modal){
                 modal.startLoading();                 
             },
             onOpened: function(modal){
                 modal.stopLoading();                 
             }
         });
         $('#modal-captcha').iziModal('setTitle', 'Nhập captcha để xem video');
         $('#modal-captcha').iziModal('setTop', 100);                  
         
         $('#modal-video').iziModal({
             fullscreen: true,
             overlayClose:false,
             onOpening: function(modal){
                 modal.startLoading();                  
             },
             onOpened: function(modal){
                 modal.stopLoading();
             },
             onClosing: function(modal){
                 document.getElementById('video-player').pause();
             }
         });
         $('#modal-video').iziModal('setTitle', 'Xem video trực tuyến');
         $('#modal-video').iziModal('setFullscreen', true);           
    </script>
    <script type="text/javascript" src="{{ asset('js/openload-plugin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/video-player.js') }}"></script>
    
</html>
