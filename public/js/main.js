function showToast(type, content, title, close){
    switch(type){
        case 'success': toastr.options.closeButton = close; toastr.success(content, title); break;
        case 'error': toastr.options.closeButton = close; toastr.error(content, title); break;
    }       
}