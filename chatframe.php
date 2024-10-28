<!doctype html>
<html class="htmlchatframe">
<head>
	<?php
	wp_head();
	?>
    <title>Autochat</title>
    <meta charset="UTF-8">
	<style >
		#autoChatRoot {
			background:#FFF;
		}
	</style>
</head>
<body>
<script>

var final = false;
setInterval(function () {
    
	// check if last message is by visitor. If yes, show indicator
	if(parent.document.body.clientWidth < 1024){
		jQuery('#autoChatRoot').attr('class', 'mobile');
	} else {
        jQuery('#autoChatRoot').removeAttr('class', 'mobile');
    }
	
	if(jQuery( "ol.chat li:last-child" ).attr('class') ==='visitor' && jQuery( "ol.chat li:last-child" ).attr('read') != 'read'){
		jQuery( "ol.chat li:last-child" ).attr('read', 'read');
		setTimeout(
			function() {
				jQuery('ol.chat').animate({scrollTop: jQuery('ol.chat')[0].scrollHeight}, 2000);
				jQuery( "ol.chat" ).append('<li class="indicator"><div class="loading-dots"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></li>');
			}, 2000);
		
	}else{
		// if last message is by bot and indicator is shown, then remove indicator from conversation
		if((jQuery( "ol.chat li:last-child" ).attr('class') ==='indicator' && jQuery("ol.chat li:nth-last-child(2)").attr('class') ==='chatbot') || 
			(jQuery( "ol.chat li:last-child" ).attr('class') ==='indicator' && jQuery("ol.chat li:nth-last-child(2)").attr('class') ==='indicator' && jQuery("ol.chat li:nth-last-child(3)").attr('class') ==='chatbot')){
			jQuery("ol.chat li .loading-dots").parent().remove();
		}
			
	}

}, 10);


var auy_cookie = auy_readCookie("auy_conv");

if(auy_cookie != null){

	auy_setCookie("auy_loading", "true", 30*60*1000);
	var auy_cookiesData = auy_readCookie("auy_conv");
	var auy_loadcookieData = JSON.parse(auy_cookiesData);
	
	setTimeout( function(auy_cookie_loading){ 
		parent.WpbLoadConversation(auy_loadcookieData);
		
	}  , 500 );
}

setTimeout( function(){ 
	jQuery("#messageArea").append('<div id="chatfoot" class="footer" style="display: block;height: 80px;text-align: center;"><div class="logo"><a target="_blank" href="https://autochat.uy"><img src="<?php echo esc_attr(AUYCHT_DIR . "assets/img/logon.png") ?>" style="width: 110px;"></a></div><img class="plane" src="<?php echo esc_attr(AUYCHT_DIR . "assets/img/plane.png") ?>"></div>');
	jQuery(".plane").on("click", function(){
		var msj = jQuery("#userText").val();
		if(msj != ""){
			parent.sendMessage(msj);
			jQuery("#userText").val("");
		}
		
	});
	
}  , 300 );

</script>
</body>
</html>