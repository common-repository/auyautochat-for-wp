var autochatWidget = {
	frameEndpoint: settings.pluginUrl,
	introMessage: settings.introMessage,
	chatServer : settings.conversationUrl, 
	title: settings.title, 
	mainColor: settings.mainColor,
	bubbleBackground: settings.bubbleBackground,
	bubbleAvatarUrl: settings.bubbleAvatarUrl,
	placeholderText: settings.placeholderText,
	displayMessageTime: settings.displayMessageTime,
	desktopHeight: parseInt(settings.desktopHeight),
	desktopWidth: parseInt(settings.desktopWidth),
	headerTextColor: settings.headerTextColor,
	userId: settings.userId,
	client: settings.clientId,
	convFinish: settings.convFinish,
}; 

if(jQuery(window).width() > 1023){
	setTimeout( function(){ 
		
		var auy_open = null;
		var auy_nameEQ = "auy_open=";
		var auy_ca = document.cookie.split(';');
		
		for(var i=2;i < auy_ca.length;i++) {
			var c = auy_ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(auy_nameEQ) == 0) auy_open = c.substring(auy_nameEQ.length,c.length);
		}
		
		if(auy_open == null){
			auChatWidget.open();
		}
		

	}  , 8000 );
}else{
	setTimeout( function(){ 
		jQuery('#autochatWidgetRoot div:first-child div:first-child div').append( "<span class='numb' style='color: white;background: red;font-size: 10px;padding: 0px 6px;border-radius: 50%;font-family: Arial;position: absolute;z-index: 100000;right: 0px;top: -5px;text-align: center;line-height: 18px;'>1</span>"); 
		jQuery('#autochatWidgetRoot > div:first-child > div:first-child > div:first-child').append( '<div class="mobile-alert" style="position: absolute;display: inline-block;width: auto;font-size: 13px;right: 15px;background: linear-gradient(to bottom,rgba(247,247,247,1) 0,rgba(255,255,255,1) 100%);border-radius: 8px;border: 1px solid #ddd;box-shadow: 2px 4px 16px 0 rgba(0,0,0,.3);color: #777;margin-bottom: 10px;margin-right: 10px;overflow: hidden;padding: 17px;white-space: nowrap;font-family: Arial;z-index: -1;top:-46px">'+autochatWidget.introMessage); 
		
	}  , 8000 );
	
}

	
function WpbLoadConversation(conv){
	
	autochatWidget.chatServer = "";
	
	if(conv != null){
		jQuery.each(conv, function(key, val){
			
			if(key != 0){
				if(jQuery(this)[0] == "visitor"){
					auChatWidget.say(jQuery(this)[1]);
				}
				
				if(jQuery(this)[0] == "chatbot"){
					auChatWidget.sayAsBot(jQuery(this)[1]);
				}
			}
			
			
			
		});
		
		
	}
	
	setTimeout( function(){ 
		autochatWidget.chatServer = settings.conversationUrl;
		var d = new Date();
		d.setTime(d.getTime() + 30*60*1000);
		var expires = "expires="+ d.toUTCString();
		document.cookie = "auy_loading=false;" + expires + ";path=/";
	}  , 500 );
	
}


function sendMessage(msj){
	auChatWidget.say(msj);
}












