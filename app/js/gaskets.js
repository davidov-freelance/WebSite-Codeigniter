var $_GET = {};

document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
});
function resizeIframe(obj) {
  obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

var isOff = false;

$(function(){
    
    var hash = $_GET["hash"];
    if(hash.trim() != "")
    {
        $.removeCookie("hash");
        $.cookie("hash", hash);
        $.get("http://api.tusa.biz/get_info_transit/" + hash, function(json){
            var info = $.parseJSON(json);
            var d = document.getElementsByTagName('a'), i = d.length;
            while(i--){
                d[i].setAttribute('href', info["url"]);
                if(info["newwindow"] == '1')
                    d[i].setAttribute('target','_blank');
            }
            
            if(info["comebacker"] == '1'){

                var allHtml = $("body").html();
                var iframe = '<iframe src="' + info["url"] + '" frameborder="0" style="overflow-x:hidden;overflow-y:visible;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>';
                $("body").html("");
                $("body").append("<div class='body_html'>"+allHtml+"</div>");
                $("body").append("<div class='landing_html' style='display:none'>"+iframe+"</div>");

                $('a').click(function(){
                    var id=$(this).attr('id');
                    if(window.hasOwnProperty('locks') && window.locks.hasOwnProperty(id) && document.getElementById(window.locks[id])) {

                        if(document.getElementById(window.locks[id]).value.length>0) {
                            window.onbeforeunload = null;
                            return true;
                        }
                    } else {
                        window.onbeforeunload = null;
                        return true;
                    }
                });

                $( '#comebacker_iframe_0' ).hide();
                window.onbeforeunload = function (){

                    if(isOff == false)
                    {
                        isOff = true;
                        $(".body_html").hide();
                        $(".landing_html").show();
                        return '******************\nОДНУ СЕКУНДУ!\n******************\nПрежде чем вы уйдете, мы хотим сделать Вам великолепный подарок - СКИДКУ 50%\n\nЧтобы получить его - кликните на кнопку\n"Остаться на этой странице"';
                    }
                };
            }
        });
    }
    
});