/*VanillaToasts*/
!function(t,e){try{"object"==typeof exports?module.exports=e():t.VanillaToasts=e()}catch(t){console.log("Isomorphic compatibility is not supported at this time for VanillaToasts.")}}(this,function(){"complete"===document.readyState?e():window.addEventListener("DOMContentLoaded",e),VanillaToasts={create:function(){console.error(["DOM has not finished loading.","\tInvoke create method when DOMs readyState is complete"].join("\n"))},setTimeout:function(){console.error(["DOM has not finished loading.","\tInvoke create method when DOMs readyState is complete"].join("\n"))},toasts:{}};var t=0;function e(){var e=document.createElement("div");e.id="vanillatoasts-container",document.body.appendChild(e),$("#vanillatoasts-container").css("z-index",999999),VanillaToasts.create=function(e){var a=document.createElement("div");if(a.id=++t,a.id="toast-"+a.id,a.className="vanillatoasts-toast",e.title){var n=document.createElement("h4");n.className="vanillatoasts-title",n.innerHTML=e.title,a.appendChild(n)}if(e.text){var o=document.createElement("p");o.className="vanillatoasts-text",o.innerHTML=e.text,a.appendChild(o)}if(e.icon){var i=document.createElement("img");i.src=e.icon,i.className="vanillatoasts-icon",a.appendChild(i)}function s(){document.getElementById("vanillatoasts-container").removeChild(a),delete VanillaToasts.toasts[a.id]}return"function"==typeof e.callback&&a.addEventListener("click",e.callback),a.hide=function(){a.className+=" vanillatoasts-fadeOut",a.addEventListener("animationend",s,!1)},e.timeout&&setTimeout(a.hide,e.timeout),e.type&&(a.className+=" vanillatoasts-"+e.type),a.addEventListener("click",a.hide),document.getElementById("vanillatoasts-container").appendChild(a),VanillaToasts.toasts[a.id]=a,a},VanillaToasts.setTimeout=function(t,e){VanillaToasts.toasts[t]&&setTimeout(VanillaToasts.toasts[t].hide,e)}}return VanillaToasts});
var $videoKey = "dWwDdbLI0ul1clbtlw+4/UHPxlYmLoE9Ii9QEw==";
$(window).load(function() {
    
});
$(document).ready(function(){
      
    $(document).ajaxSend(function(e, xhr, opt){
        openLoading();
    });
    $(document).ajaxStop(function(){
        closeLoading();
    });
    $('span[title]').qtip({
        position: {
                my: 'bottom center',
                at: 'top center'
            }
    });
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        
    } else {
        $('button[title], img[title]').qtip({
            position: {
                    my: 'top center',
                    at: 'bottom center'
                }
        });        
    }
    $(document).click(function(event) {
        var target = $(event.target);
        if (!target.parents().andSelf().is('.result-search')            
            ) {
                $('.result-search > ul > a ').hide(1000, function(){
                    $('.result-search > ul > a ').remove();
                });
                $('.result-search').html('');
            }
    });
    $('.btn-lock-account').click(function(){        
        var token = $('#comment').attr('aria-token');
        $.ajax({
            type: 'get',           
            url: $('meta[name="url"]').attr('content')+'/quan-ly/tai-khoan/lock/comment/',
            data: {'_token':token,'cid':$('#action-comment').attr('cid')},        
            headers: {
                'X-CSRF-TOKEN': token
            },
            success: function (data) {
                $('#action-comment').iziModal('close');
                $("#comment").load(location.href+" #comment>*","");
            }
        });
    });
    $('.btn-delete-comment').click(function(){        
        var token = $('#current-token').val();
        $.ajax({
            type: 'get',           
            url: $('meta[name="url"]').attr('content')+'/delete-comment/',
            data: {'_token':token,'cid':$('#action-comment').attr('cid')},        
            headers: {
                'X-CSRF-TOKEN': token
            },
            success: function (data) {
                $('#action-comment').iziModal('close');
                $("#comment").load(location.href+" #comment>*","");
            }
        });
    });
    $('.btn-report-comment').click(function(){        
        var token = $('#current-token').val();
        var reportContent = $('#input-report-comment').val();
        if(reportContent.trim().length >= 10){        
            $('.help-report-comment').css('color','gray');
            $.ajax({
                type: 'get',           
                url: $('meta[name="url"]').attr('content')+'/report-comment/',
                data: {'_token':token,'cid':$('#report-comment').attr('cid'), 'content': reportContent},        
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (data) {
                    $('.report-result').removeClass('display-none');
                    $('.report-body').addClass('display-none');
                    $('.content-report-result').html(data);
                    }
            });
        } else {
            $('.help-report-comment').css('color','red');
        }
    });
    $('.btn-report-error').click(function(){        
        var token = $('#current-token').val();
        var content = $('#input-report-error').val();
        var email = $('#input-report-email').val();
        if(content.trim().length < 6){
            $('.help-block-report-error').html('Vui lòng mô tả lỗi ít nhất 6 ký tự');
            $('.help-block-report-error').css('color','#b92c28');
        } else {
            $('.help-block-report-error').html('');
            $.ajax({
                type: 'get',           
                url: $('meta[name="url"]').attr('content')+'/report-error/',
                data: {'_token':token,'pid':$('meta[name="pid"]').attr('content'), 't':$('meta[name="tid"]').attr('content'), 'content':content, 'email':email},        
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (data) {
                    $('#modal-report-error').iziModal('close');
                    showToast('success','Cảm ơn bạn đã ủng hộ website','Báo lỗi thành công',true);
                }
            });
        }        
    });
    $('.btn-follow-phim').click(function(){        
        setTimeout(function(){console.log(123)},10000);
        var token = $('#current-token').val();
        var follow = $('.btn-follow-phim').attr('follow');
        if(follow == 0){           
            $.ajax({
                type: 'get',           
                url: $('meta[name="url"]').attr('content')+'/follow-phim/',
                data: {'_token':token,'pid':$('meta[name="pid"]').attr('content')},        
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (data) {                
                    if(data == '-1'){
                        $('#user-login').iziModal('open');
                    } else {
                        $('.btn-follow-phim').attr('follow', 1);                        
                        $('.btn-follow-phim').attr('title', 'Bỏ theo dõi');
                        $('.btn-follow-phim > i > span').html('Đã theo dõi');
                        $('.btn-follow-phim > i > sup').html(data);
                        $('.btn-follow-phim > i').removeClass('fa-bell-slash');
                        $('.btn-follow-phim > i').addClass('fa-bell');  
                        showToast('success','Chúc bạn xem phim vui vẻ','Đã thêm vào danh sách theo dõi',true);                        
                    }             
                }
            });
        } else {
            $.ajax({
                type: 'get',           
                url: $('meta[name="url"]').attr('content')+'/unfollow-phim/',
                data: {'_token':token,'pid':$('meta[name="pid"]').attr('content')},        
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function (data) {               
                    $('.btn-follow-phim').attr('follow', 0);  
                    $('.btn-follow-phim').attr('title', 'Theo dõi'); 
                    $('.btn-follow-phim > i > span').html('Chưa Theo dõi');
                    $('.btn-follow-phim > i > sup').html(data);
                    $('.btn-follow-phim > i').removeClass('fa-bell');
                    $('.btn-follow-phim > i').addClass('fa-bell-slash');  
                    showToast('success','Chúc bạn xem phim vui vẻ','Đã bỏ theo dõi',true);                    
                }
            });
        }                
    });    
    $('.btn-auto-next').click(function(){
        var auto = $('.btn-auto-next').attr('aria-auto').trim();                
        $.ajax({
            type: "GET",
            url: $('meta[name="url"]').attr('content')+'/auto-next/',
            data: {'value': auto},
            success: function (data) {           
                if(auto==1){
                    $('.btn-auto-next').attr('aria-auto', 0);
                    $('.btn-auto-next').attr('title', 'Bật Auto chuyển tập');
                    $('.text-auto-next').html(' Tắt');
                    $('.icon-auto-next').addClass('fa-ban');
                    $('.icon-auto-next').removeClass('fa-check-circle');
                }else{
                    $('.btn-auto-next').attr('aria-auto', 1);
                    $('.btn-auto-next').attr('title', 'Tắt Auto chuyển tập');
                    $('.text-auto-next').html(' Bật');
                    $('.icon-auto-next').addClass('fa-check-circle');
                    $('.icon-auto-next').removeClass('fa-ban');
                }
                
            }
        });     
    });
    $('.btn-search').click(function(){
       if($('.input-search').val().trim().length < 3){
           showToast('info', '', 'Từ khóa tìm kiếm phải có ít nhất 3 ký tự', true);
       }
    });
    var searchTimeout;
    $('.input-search').keyup(function(){    
        clearTimeout(searchTimeout);    
        var tukhoa = this.value.trim();        
        if(tukhoa.length < 3){
            $('.result-search').css('display','none');
            $('.result-search').html('');                   
        }else{            
            $('.result-search').css('display','block'); 
            searchTimeout = setTimeout(function(){
                $.ajax({
                    type: "GET",
                    url: $('meta[name="url"]').attr('content')+'/tim-kiem?tukhoa='+tukhoa,                
                    success: function (data) {                    
                        $('.result-search').html(data);
                        $('.lazy').lazy();                
                    }
                });   
            }, 300);                              
        }
    })
});
window.onload = function(){
    $('.npv-page-loading').remove();  
};
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
function showToast(type, content, title, close){switch(type){
        case 'info': toastr.options.closeButton = close; toastr.info(content, title); break;
        case 'success': toastr.options.closeButton = close; toastr.success(content, title); break;
        case 'error': toastr.options.closeButton = close; toastr.error(content, title); break;
    }}(function ($){"use strict";var input = $('.validate-input .input100');$('.validate-form').on('submit',function(){var check = true;for(var i=0; i<input.length; i++) {if(validate(input[i]) == false){showValidate(input[i]);check=false;}}return check;});$('.validate-form .input100').each(function(){$(this).focus(function(){hideValidate(this);});});function validate (input) {if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {return false;}}else {if($(input).val().trim() == ''){return false;}}}function showValidate(input) {var thisAlert = $(input).parent();$(thisAlert).addClass('alert-validate');}function hideValidate(input) {var thisAlert = $(input).parent();$(thisAlert).removeClass('alert-validate');}})(jQuery);
        function viewTimes(tapid){           
            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", $('meta[name="url"]').attr('content')+'/adview?id='+tapid, true);
            xhttp.send();
            /*$.ajax({
                type: 'post',           
                url: $('meta[name="url"]').attr('content')+'/adview',
                data: {'id':tapid },               
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {                
                }
            });*/                     
        }
function danhGia(value) { 
    var str =  $('.rate').attr('aria-value');
    if(str.search($('meta[name="pid"]').attr('content')+',') == -1 && $('.rate').attr('voted') != 1){
        $.ajax({
            url: $('meta[name="url"]').attr('content')+'/danh-gia?pid='+$('meta[name="pid"]').attr('content')+'&star=' + value+'&token='+$('meta[name="csrf-token"').attr('content'),
            dataType: 'text',
            type: 'get',
            success: function (data) { 
                var json = JSON.parse(data);                 
                if(json.status === 1){                
                    $('.rate').attr('data-rate-value',json.star);
                    $('.rate').attr('voted',1);
                    $('.rate-select-layer').css('width', 20*json.star+'%');
                    $('.vote-times').html('('+json.times+' lượt)');
                    showToast('success','Chúc bạn xem phim vui vẻ','Đánh giá thành công',true);
                }                       
            }
        });
    }else{
        showToast('info','','Bạn đã đánh giá phim này rồi!',true);
    }    
}
function sendComment(pid, token){
    if($('#input-comment').val().trim().length > 0){
        $.ajax({
            type: "GET",
            url: $('meta[name="url"]').attr('content')+'/add-comment/',
            data: {'token': token, 'pid':$('meta[name="pid"]').attr('content'), 'content':$('#input-comment').val()},
            success: function (data) {
                if (data !== 0 && data !== -1) {
                    $('.list-comment').html('');
                    var newPage = document.createElement('tbody');
                    newPage.className = 'comment-page-1';
                    $('.list-comment').append(newPage);
                    $('.comment-page-1').html(data);
                    newPage2 = document.createElement('tbody');
                    newPage2.className = 'comment-page-2';
                    $('.list-comment').append(newPage2);
                    $('.xtc').attr('aria-page', 2);
                    $('#input-comment').val('');
                }
            }
        });
    }
}   

function xtc(pid){
    var page = $('.xtc').attr('aria-page');
    $.ajax({
        url: $('meta[name="url"]').attr('content')+'/comment?pid='+$('meta[name="pid"]').attr('content')+'&page='+page,
        dataType: 'text',                    
        type: 'get',                    
        success: function (data) {                
        $('.comment-page-'+page).html(data);
        var nextPage = parseInt(page)+1;
        $('.xtc').attr('aria-page', nextPage);
        var newPage = document.createElement('tbody');
        newPage.className = 'comment-page-'+nextPage;
        $('.list-comment').append(newPage);
        }
    });
}
function openReply(i){
    $('.reply-'+i).css('display','inline-table');
    $('.icon-reply-'+i).css('display','none');
    $('.reply-'+i+' > .input-reply').focus();
}
function cancelReply(i){
    $('.reply-'+i).css('display','none');
    $('.icon-reply-'+i).css('display','unset');
}
function replyComment(cid){    
    var content = $('.reply-'+cid+' > .input-reply').val();
    var page = $('.xtc').attr('aria-page');
    $.ajax({
        type: 'get',
        url: $('meta[name="url"]').attr('content')+'/reply-comment/',
        data: {'cid':cid, 'content':content, 'page':page},        
        headers: {
            'X-CSRF-TOKEN': $('#current-token').val()
        },
        success: function (data) {
            if (data !== 0 && data !== -1) {
                $('.list-comment').html('');
                var newPage = document.createElement('tbody');
                newPage.className = 'comment-page-1';
                $('.list-comment').append(newPage);
                $('.comment-page-1').html(data);
                newPage2 = document.createElement('tbody');
                newPage2.className = 'comment-page-2';
                $('.list-comment').append(newPage2);
                $('.xtc').attr('aria-page', page);                
            }
        }
    });
}
function openContextMenu(cid){    
    $('#action-comment').iziModal('open');
    $('#action-comment').attr('cid', cid);
    $('.action-comment-avatar').attr('src',$('.avatar.'+cid).attr('src'));
    $('.action-comment-username').html($('.username-comment.'+cid).html());
    $('.action-comment-content').html($('.content-comment.'+cid).html());    
}
function openReport(cid){    
    $('#report-comment').iziModal('open');
    $('#report-comment').attr('cid', cid);
    $('.report-comment-avatar').attr('src',$('.avatar.'+cid).attr('src'));
    $('.report-comment-username').html($('.username-comment.'+cid).html());
    $('.report-comment-content').html($('.content-comment.'+cid).html());    
}
function xt(){
    var page = $('.xttm').attr('aria-page');
        $.ajax({
            type: "GET",
            url: $('meta[name="url"]').attr('content')+'/tap-moi?page='+page, 
                success: function (data) {                
                        $('.tapmoi-page-' + page).html(data);
                        var nextPage = parseInt(page) + 1;
                        $('.xttm').attr('aria-page', nextPage);
                        var newPage = document.createElement('span');
                        newPage.className = 'tapmoi-page-' + nextPage;
                        $('.listTapMoi').append(newPage);
                        $('.lazy').lazy();
                        refreshTippy();
                }
        });
}
function xtmv(){
    var page = $('.xtmv').attr('aria-page');
        $.ajax({
            type: "GET",
            url: $('meta[name="url"]').attr('content')+'/movie-moi?page='+page,          
                success: function (data) {                
                        $('.moviemoi-page-' + page).html(data);
                        var nextPage = parseInt(page) + 1;
                        $('.xtmv').attr('aria-page', nextPage);
                        var newPage = document.createElement('span');
                        newPage.className = 'moviemoi-page-' + nextPage;
                        $('.listMovieMoi').append(newPage);
                        $('.lazy').lazy();
                        refreshTippy();
                }
        });
}
function refreshTippy(){
    $('.phim-tip-content').removeClass('display-none');
    tippy('a.ttip', {
        arrow: true,
        theme: 'mytheme',
        placement: 'right',
        content(reference) {
          return document.getElementById(reference.getAttribute('data-template'))
        }
     })
}
function confirmAge(pid){
    $.ajax({
    url: $('meta[name="url"]').attr('content') + '/confirm-age?pid=' + $('meta[name="pid"]').attr('content'),
        dataType: 'text',
        type: 'get',
        success: function (data) {
                
        }
    });
}
function loadServer(event, server, tapid, dataid){
    if($(event).find('button').hasClass('btn-active')){
            return false;
    }
    $('.btn-download').addClass('display-none');
    if(server == 1){                    
        var sourcesTemp = '';
        $.ajax({
            type: 'post',           
            url: $('meta[name="url"]').attr('content')+'/load',
            data: {'id':tapid },        
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {                
                sourcesTemp = data['360p'];
                jwplayer('my-player').setup({
                    width: "100%",
                    height: "100%",
                    sources: [
                            {file: data['360p'],label:'360p','type':'mp4'},                                          
                            {file: data['720p'],label:'720p','type':'mp4','default': 'true'},                                                      
                        ],
                    autostart: true,image: "","skin" : {"url":$('meta[name="url"]').attr('content')+"/css/jwplayer-skin.min.css","name": "glow",},
                }); 
                jwplayer('my-player').load();  
                jwplayer('my-player').on('error', function() { 
                    jwplayer('my-player').setup({
                        width: "100%",
                        height: "100%",
                        sources: [
                                {file:sourcesTemp,label:'360p','type':'mp4','default': 'true'},                                                                
                            ],
                            autostart: true,image: "","skin" : {"url":$('meta[name="url"]').attr('content')+"/css/jwplayer-skin.min.css","name": "glow",},
                    });
                    jwplayer('my-player').load();
                }); 
            }
        });
        $('.btn-download').removeClass('display-none');
    }
    if(server == 2){
        var sourcesTemp = '';
        $.ajax({
            type: 'post',           
            url: $('meta[name="url"]').attr('content')+'/load-video-2',
            data: {'id':tapid },        
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {                
                sourcesTemp = data['360p'];
                jwplayer('my-player').setup({
                    width: "100%",
                    height: "100%",
                    sources: [
                            {file: data['360p'],label:'360p','type':'mp4'},                                          
                            {file: data['720p'],label:'720p','type':'mp4','default': 'true'},                                                      
                        ],
                    autostart: true,image: "","skin" : {"url":$('meta[name="url"]').attr('content')+"/css/jwplayer-skin.min.css","name": "glow",},
                }); 
                jwplayer('my-player').load();  
                jwplayer('my-player').on('error', function() { 
                    jwplayer('my-player').setup({
                        width: "100%",
                        height: "100%",
                        sources: [
                                {file:sourcesTemp,label:'360p','type':'mp4','default': 'true'},                                                                
                            ],
                            autostart: true,image: "","skin" : {"url":$('meta[name="url"]').attr('content')+"/css/jwplayer-skin.min.css","name": "glow",},
                    });
                    jwplayer('my-player').load();
                }); 
            }
        });
        $('.btn-download').removeClass('display-none');
    }
    if(server == 3){
        $('#my-player').html('<iframe src="'+dataid+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen width="100%" height="100%"></iframe>');                         
    }
    if(server == 4){
        $('#my-player').html('<iframe id="frame-youtube" class="npv-youtube" src="'+dataid+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen width="100%" height="100%"></iframe>');                         
    }    
    $('.btn-server').removeClass('btn-active');
    $(event).find('button').addClass('btn-active');
}
function openLoading(){
    $('#loading').fadeIn();
}
function closeLoading(){
    $('#loading').fadeOut();
}
function openWindowLoading(){
    $('#loadingWindow').fadeIn();
}
function closeWindowLoading(){
    $('#loadingWindow').fadeOut();
}        
    function submitYeuCau(){ 
        var name = $('.request-name').val();
        $('.input-invalid').addClass('display-none');
        if(name){
            $.ajax({
                type: 'post',           
                url: $('meta[name="url"]').attr('content')+'/post-yeu-cau',
                data: $("#frm-request").serialize(),               
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {  
                    $('#modal-request').iziModal('startLoading');
                    $('#frm-request').addClass('display-none');
                    $('.btn-request-submit').addClass('display-none');
                    $('#rs-request').removeClass('display-none');
                    $('.btn-request-continue').removeClass('display-none');
                    $('#modal-request').iziModal('stopLoading');
                }
            }); 
        }else{
            $('.input-invalid').removeClass('display-none');
        }                                   
    }
    function nextYeuCau(){
      $('#modal-request').iziModal('startLoading');
      $('#frm-request').removeClass('display-none');
      $('.btn-request-submit').removeClass('display-none');
      $('#rs-request').addClass('display-none');
      $('.btn-request-continue').addClass('display-none');
      $('#frm-request').get(0).reset();
      $('#modal-request').iziModal('stopLoading');
    }
    
    function submitError(){ 
        var content = $('.error-content').val();
        $('.input-invalid').addClass('display-none');
        if(content){
            $.ajax({
                type: 'post',           
                url: $('meta[name="url"]').attr('content')+'/post-error',
                data: $("#frm-error").serialize(),               
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {  
                    $('#modal-error').iziModal('startLoading');
                    $('#frm-error').addClass('display-none');
                    $('.btn-error-submit').addClass('display-none');
                    $('#rs-error').removeClass('display-none');
                    $('.btn-error-continue').removeClass('display-none');
                    $('#modal-error').iziModal('stopLoading');
                }
            }); 
        }else{
            $('.input-invalid').removeClass('display-none');
        }                                   
    }
    function nextError(){
      $('#modal-error').iziModal('startLoading');
      $('#frm-error').removeClass('display-none');
      $('.btn-error-submit').removeClass('display-none');
      $('#rs-error').addClass('display-none');
      $('.btn-error-continue').addClass('display-none');
      $('#frm-error').get(0).reset();
      $('#modal-error').iziModal('stopLoading');
    }
    
    function submitFeedback(){ 
        var content = $('.feedback-content').val();
        $('.input-invalid').addClass('display-none');
        if(content){
            $.ajax({
                type: 'post',           
                url: $('meta[name="url"]').attr('content')+'/post-feedback',
                data: $("#frm-feedback").serialize(),               
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {  
                    $('#modal-feedback').iziModal('startLoading');
                    $('#frm-feedback').addClass('display-none');
                    $('.btn-feedback-submit').addClass('display-none');
                    $('#rs-feedback').removeClass('display-none');
                    $('.btn-feedback-continue').removeClass('display-none');
                    $('#modal-feedback').iziModal('stopLoading');
                }
            }); 
        }else{
            $('.input-invalid').removeClass('display-none');
        }                                   
    }
    function nextFeedback(){
      $('#modal-feedback').iziModal('startLoading');
      $('#frm-feedback').removeClass('display-none');
      $('.btn-feedback-submit').removeClass('display-none');
      $('#rs-feedback').addClass('display-none');
      $('.btn-feedback-continue').addClass('display-none');
      $('#frm-feedback').get(0).reset();
      $('#modal-feedback').iziModal('stopLoading');
    }
    function download(){
        var url = $('video').attr('src');
        window.open("https://123link.co/st?api=a50a96b4fab46696202e02ee3f0d54cc0fc26abd&url="+url, "_blank");
    } 