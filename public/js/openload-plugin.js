var $key        = "bvLaLh9-";
var $login      = "d6e334799f9a673d";
var ticket      = "";
var captcha_url = "";
var $fileID     = "";
function getLinkOpenload(f){
    $fileID = f;
    getTicket();
}
function getTicket(){   
    $("#txtCaptcha").val('');
    $('#messageErrorCaptcha').addClass('display-none'); 
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", $('meta[name="url"]').attr('content')+"/api/openload/ticket/"+$fileID+"/"+$login+"/"+$key, false);
    xhttp.send();
    var response = JSON.parse(xhttp.responseText);    
    /*console.log(response);*/
    if(response.result.captcha_url === false){
        ticket = response.result.ticket;
        getVideo();
    } else if((captcha_url !== response.result.captcha_url)){        
        $('#modal-captcha').iziModal('open');        
        captcha_url = response.result.captcha_url;
        $("#captcha").attr("src", captcha_url);      
        ticket = response.result.ticket;
        $("#txtCaptcha").focus();
        $("#iconLoadingCaptcha").addClass("display-none");      
    } else {
        $("#iconLoadingCaptcha").removeClass("display-none");
        setTimeout(getTicket,1000);
    }
}

function getVideo(){
    $('#messageErrorCaptcha').addClass('display-none');
    var txtCaptcha = $("#txtCaptcha").val();
    if(!txtCaptcha){
        console.log("txtCaptcha is null");
        txtCaptcha = "null";
    }
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", $('meta[name="url"]').attr('content')+"/api/openload/video/" + $fileID + "/" + ticket + "/" + txtCaptcha, false);
    xhttp.send();
    var response = JSON.parse(xhttp.responseText);
    /*console.log(response);*/
    if(response.status === 200){
        $('#my-player').attr('src', response.result.url);
        var video = document.getElementById('my-player');
        video.play();
        $('#modal-captcha').iziModal('close');
    } else if(response.status === 403){
        $('#messageErrorCaptcha').removeClass('display-none');
    } else {
        return false;
    }  
}
function refreshCaptcha(){
    $("#btnRefreshCaptcha").click();
}