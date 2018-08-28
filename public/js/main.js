$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();  
    $('a.click-loading').click(function(){
      $('.npv-progress').css('display','block');
      $('.npv-progress-bar').animate({width:'30%'});      
      $('.npv-progress-bar').animate({width:'95%'});
    });
    
    $('table td').bind('contextmenu', function(){return false;});
    $('.btn-lock-account').click(function(){        
        var token = $('#comment').attr('aria-token');
        $.ajax({
            type: 'get',           
            url: $('meta[name="url"').attr('content')+'/quan-ly/tai-khoan/lock/comment/',
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
        var token = $('#comment').attr('aria-token');
        $.ajax({
            type: 'get',           
            url: $('meta[name="url"').attr('content')+'/delete-comment/',
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
});
window.onload = function(){
    $('.npv-page-loading').remove();  
};
function showToast(type, content, title, close){switch(type){case 'success': toastr.options.closeButton = close; toastr.success(content, title); break;case 'error': toastr.options.closeButton = close; toastr.error(content, title); break;}}(function ($){"use strict";var input = $('.validate-input .input100');$('.validate-form').on('submit',function(){var check = true;for(var i=0; i<input.length; i++) {if(validate(input[i]) == false){showValidate(input[i]);check=false;}}return check;});$('.validate-form .input100').each(function(){$(this).focus(function(){hideValidate(this);});});function validate (input) {if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {return false;}}else {if($(input).val().trim() == ''){return false;}}}function showValidate(input) {var thisAlert = $(input).parent();$(thisAlert).addClass('alert-validate');}function hideValidate(input) {var thisAlert = $(input).parent();$(thisAlert).removeClass('alert-validate');}})(jQuery);function viewTimes(link){$.ajax({url:link,dataType:'text',type:'GET',success:function(data){}});}

function sendComment(pid, token){
    if($('#input-comment').val().trim().length > 0){
        $.ajax({
            type: "GET",
            url: $('meta[name="url"').attr('content')+'/add-comment/',
            data: {'token': token, 'pid':pid, 'content':$('#input-comment').val()},
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
        url: $('meta[name="url"').attr('content')+'/comment?pid='+pid+'&page='+page,
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
        url: $('meta[name="url"').attr('content')+'/reply-comment/',
        data: {'cid':cid, 'content':content, 'page':page},        
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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