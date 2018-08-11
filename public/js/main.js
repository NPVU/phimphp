$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();  
    $('a.click-loading').click(function(){
      $('.npv-progress').css('display','block');
      $('.npv-progress-bar').animate({width:'30%'});      
      $('.npv-progress-bar').animate({width:'95%'});
    });
});
window.onload = function(){
    $('.npv-page-loading').remove();  
};
function showToast(type, content, title, close){switch(type){case 'success': toastr.options.closeButton = close; toastr.success(content, title); break;case 'error': toastr.options.closeButton = close; toastr.error(content, title); break;}}(function ($){"use strict";var input = $('.validate-input .input100');$('.validate-form').on('submit',function(){var check = true;for(var i=0; i<input.length; i++) {if(validate(input[i]) == false){showValidate(input[i]);check=false;}}return check;});$('.validate-form .input100').each(function(){$(this).focus(function(){hideValidate(this);});});function validate (input) {if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {return false;}}else {if($(input).val().trim() == ''){return false;}}}function showValidate(input) {var thisAlert = $(input).parent();$(thisAlert).addClass('alert-validate');}function hideValidate(input) {var thisAlert = $(input).parent();$(thisAlert).removeClass('alert-validate');}})(jQuery);function viewTimes(link){$.ajax({url:link,dataType:'text',type:'GET',success:function(data){$('.npv-view-times').html(data+' lượt xem');$('.npv-modal-view-times').html(parseInt($('.npv-modal-view-times').html())+1);;}});}        