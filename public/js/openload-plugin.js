var key         = "bvLaLh9-";
var login       = "d6e334799f9a673d";
var ticket      = "";
var captcha_url = "";
var website     = "{{url('/')}}"; 
var fileID      = "";
function getLinkOpenload(f){
    fileID = f;
    getTicket();
}
function getTicket(){    
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", $('meta[name="url"]').attr('content')+"/api/openload/ticket/" + fileID + "/" + login + "/" + key, false);
    xhttp.send();
    var response = JSON.parse(xhttp.responseText);    
    /*console.log(response);*/
    if(response.result.captcha_url === false){
    ticket = response.result.ticket;
        getVideo();
    } else if((captcha_url !== response.result.captcha_url)){            
        captcha_url = response.result.captcha_url;            
        ticket = response.result.ticket;           
    } 
}

function getVideo(){
    var txtCaptcha = $("#txtCaptcha").val();
    if(!txtCaptcha){
        /*console.log("txtCaptcha is null");*/
        txtCaptcha = "null";
    }
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", $('meta[name="url"]').attr('content')+"/api/openload/video/" + fileID + "/" + ticket + "/" + txtCaptcha, false);
    xhttp.send();
    var response = JSON.parse(xhttp.responseText);
    /*console.log(response);*/
    if(response.status === 200){
        $('#my-player').attr('src', response.result.url);
    } else {
        return false;
    }  
}
function refreshCaptcha(){
    $("#btnRefreshCaptcha").click();
}