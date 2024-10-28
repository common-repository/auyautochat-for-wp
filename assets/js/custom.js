setInterval(function () {
	// check if last message is by visitor. If yes, show indicator
	if(jQuery( "ol.chat li:last-child" ).attr('class') ==='visitor')
	{
		jQuery( "ol.chat" ).append('<li class="indicator"><div class="loading-dots"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></li>');
	}
	else
	{
		// if last message is by bot and indicator is shown, then remove indicator from conversation
		if(jQuery( "ol.chat li:last-child" ).attr('class') ==='indicator' && jQuery("ol.chat li:nth-last-child(2)").attr('class') ==='chatbot')
		jQuery("ol.chat li .loading-dots").parent().remove();
	}
}, 10);