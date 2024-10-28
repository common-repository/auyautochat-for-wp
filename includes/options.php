<?php
/*$gmt = get_option('timezone_string');
if($gmt <> ""){
	date_default_timezone_set($gmt);
}*/

if ( is_admin() ){
	add_action( 'admin_init', 'auycht_register_mysettings' );
}
function auycht_OptionsPanel(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ), "auyautochat-for-wp" );
	}
	
	$introMessage 		= __('Hi. What can I do for you?', "auyautochat-for-wp");
	$title 				= __('Chat with us', "auyautochat-for-wp");
	$placeholderText 	= __('Write an answer ...', "auyautochat-for-wp");
	
	//Chatframe preview values
	if(esc_attr( get_option('auycht_title') ) <> ""){
		$ch_title = esc_attr( get_option('auycht_title') );
	}else{
		$ch_title = $title;
	}
	
	if(esc_attr( get_option('auycht_intro_message') ) <> ""){
		$ch_intro_message = esc_attr( get_option('auycht_intro_message') );
	}else{
		$ch_intro_message = $introMessage;
	}
	
	if(esc_attr( get_option('auycht_placeholder') ) <> ""){
		$ch_placeholder = esc_attr( get_option('auycht_placeholder') );
	}else{
		$ch_placeholder = $placeholderText;
	}
	
	?>
	<div class="wrap auy_autochat_options">
		
		<form class="auy_autochat_form" method="post" action="options.php"> 
			<div class="chatframe_preview">
				<h3><?php _e("Chatframe Preview", "auyautochat-for-wp"); ?></h3>
				<div class="title" style="<?php echo esc_attr("background: ".get_option('auycht_main_color'));?>">
					<div class="txt" style="<?php echo esc_attr("color: ".get_option('auycht_header_color'));?>"><?php echo esc_attr($ch_title); ?></div>
					<svg fill="#FFFFFF" height="15" viewBox="0 0 15 15" width="15" xmlns="http://www.w3.org/2000/svg"><line x1="1" y1="15" x2="15" y2="1" stroke="white" stroke-width="1"></line><line x1="1" y1="1" x2="15" y2="15" stroke="white" stroke-width="1"></line></svg>
				</div>
				<div class="body">
					<div class="msg">
						<div class="content">
							<span class="chname">
								<?php 
									echo esc_attr( get_option('auycht_chatbot_name') );
									if(esc_attr( get_option('auycht_chatbot_name') ) <> ""){
										echo esc_html(": ");
									}
								?>
							</span> <?php echo esc_html($ch_intro_message); ?>
						</div>
						<div class="time">
						<?php 
						if(get_option('auycht_message_time') == "true"){
							$ch_date = date("H:i");
							echo esc_html($ch_date);
						}
						?>
						</div>
					</div>
					
				</div>
				<div class="footer">
					<div class="logo">
						<img src="<?php echo esc_attr(AUYCHT_DIR. '/assets/img/logon.png'); ?>" style="width: 110px;">
					</div>
					<div class="input"><?php echo esc_html($ch_placeholder); ?></div>
					<img class="plane" src="<?php echo esc_attr(AUYCHT_DIR. '/assets/img/plane.png'); ?>">
				</div>
				<div class="bubble" style="<?php echo esc_attr("background: ".get_option('auycht_bubble_color'));?>">
					<img src="<?php echo esc_attr(AUYCHT_DIR. '/assets/img/icon-message.png') ?>">
				</div>
			</div>
			<?php settings_fields( 'auycht_opt' ); ?>
			<?php do_settings_sections( 'auycht_opt' ); ?>
			<?php wp_nonce_field( 'auycht_options_save', 'auycht_save' ); ?>
			<h1><?php _e("Autochat Conversation Options", "auyautochat-for-wp"); ?></h1>
			<button type="button" class="auycht_save_settings"><?php _e("Save settings", "auyautochat-for-wp"); ?></button>
			<div class="row">
				<div class="col-sm-2">
					<h3 class="title"><?php _e("Questions language", "auyautochat-for-wp"); ?> <div class="auy_autochat_tooltip">&#9432;
					  <span class="tooltiptext"><?php _e("Check also Wordpress Language in Settings.", "auyautochat-for-wp"); ?></span>
					</div></h3>
					
					<select name="auycht_lang">
						<option value="en" <?php if(get_option('auycht_lang') == "en"){echo esc_attr("selected");} ?>>English</option>
						<option value="es" <?php if(get_option('auycht_lang') == "es"){echo esc_attr("selected");} ?>>Spanish</option>
						<option value="pt" <?php if(get_option('auycht_lang') == "pt"){echo esc_attr("selected");} ?>>Portuguese</option>
						<option value="de" <?php if(get_option('auycht_lang') == "de"){echo esc_attr("selected");} ?>>German</option>
						<option value="fr" <?php if(get_option('auycht_lang') == "fr"){echo esc_attr("selected");} ?>>French</option>
						<option value="it" <?php if(get_option('auycht_lang') == "it"){echo esc_attr("selected");} ?>>Italian</option>
						<option value="id" <?php if(get_option('auycht_lang') == "id"){echo esc_attr("selected");} ?>>Indonesian</option>
						<option value="ms" <?php if(get_option('auycht_lang') == "ms"){echo esc_attr("selected");} ?>>Malay</option>
						<option value="pl" <?php if(get_option('auycht_lang') == "pl"){echo esc_attr("selected");} ?>>Polish</option>
						<option value="tr" <?php if(get_option('auycht_lang') == "tr"){echo esc_attr("selected");} ?>>Turkish</option>
						<option value="zh" <?php if(get_option('auycht_lang') == "zh"){echo esc_attr("selected");} ?>>Chinese</option>
						<option value="hi" <?php if(get_option('auycht_lang') == "hi"){echo esc_attr("selected");} ?>>Hindu</option>
						<option value="ja" <?php if(get_option('auycht_lang') == "ja"){echo esc_attr("selected");} ?>>Japanese</option>
					</select>
				</div>
				
				<div class="col-sm-2">
					<h3 class="title"><?php _e("On/off Autochat", "auyautochat-for-wp"); ?></h3>
					<input data-on="<img class='check' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/check.png') ?>'>"  data-off="<img class='delete' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/delete.png') ?>'>" data-size="small" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" name="auycht_on_off" value="true" <?php if(get_option('auycht_on_off') == "true"){echo esc_attr("checked");} ?>/>
				</div>	
				
			</div>
			<hr>
			
			<h2 class="title"><?php _e("Labels and Messages", "auyautochat-for-wp"); ?></h2>
			<div class="row">
			
				<div class="col-sm-2">
					<h3><?php _e("Title", "auyautochat-for-wp"); ?></h3>
					<input maxlength="30" placeholder="<?php echo esc_attr($title); ?>" type="text" name="auycht_title" value="<?php echo esc_attr( get_option('auycht_title') ); ?>" />
				</div>
	
				<div class="col-sm-2">
					<h3><?php _e("Placeholder", "auyautochat-for-wp"); ?></h3>
					<input maxlength="30" placeholder="<?php echo esc_attr($placeholderText); ?>" type="text" name="auycht_placeholder" value="<?php echo esc_attr( get_option('auycht_placeholder') ); ?>" />
				</div>
				<div class="col-sm-3">
					
				</div>
				<div class="col-sm-3">
					
				</div>
				
			</div>
			<div class="row">
				<div class="col-sm-4">
					</br>
					<h3><?php _e("Intro Message", "auyautochat-for-wp"); ?></h3>
					<textarea rows="6" cols="50" name="auycht_intro_message" placeholder="<?php echo esc_attr($introMessage); ?>"><?php echo esc_attr( get_option('auycht_intro_message') ); ?></textarea>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4">
					<h3><?php _e("Chatbot name", "auyautochat-for-wp"); ?></h3>
					<input maxlength="15" type="text" name="auycht_chatbot_name" value="<?php echo esc_attr( get_option('auycht_chatbot_name') ); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2">
					</br>
					<h3><?php _e("Show message time", "auyautochat-for-wp"); ?></h3>
					<input data-on="<img class='check' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/check.png') ?>'>"  data-off="<img class='delete' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/delete.png') ?>'>" data-size="small" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" name="auycht_message_time" value="true" <?php if(get_option('auycht_message_time') == "true"){echo esc_attr("checked");} ?>/>
				</div>
				
				<div class="col-sm-2">
					</br>
					<h3><?php _e("Don't ask call hour", "auyautochat-for-wp", "auyautochat-for-wp"); ?></h3>
					<input data-on="<img class='check' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/check.png') ?>'>"  data-off="<img class='delete' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/delete.png') ?>'>" data-size="small" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" name="auycht_conv_ask_hour" value="true" <?php if(get_option('auycht_conv_ask_hour') == "true"){echo esc_attr("checked");} ?>/>
				</div>
				
				<div class="col-sm">
					</br>
					<h3><?php _e("Force Email Validation", "auyautochat-for-wp"); ?> </h3>
					<input data-on="<img class='check' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/check.png') ?>'>"  data-off="<img class='delete' src='<?php  echo esc_attr(AUYCHT_DIR . 'assets/img/delete.png') ?>'>" data-size="small" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" type="checkbox" name="auycht_email_validation" value="true" <?php if(get_option('auycht_email_validation') == "true"){echo esc_attr("checked");} ?>/>
				</div>
			</div>
			
			<hr>
			<br>
			
			<h2 class="title"><?php _e("Width & Height", "auyautochat-for-wp"); ?></h2>
			<div class="row">
				<div class="col-sm-2">
					<h3><?php _e("Width", "auyautochat-for-wp"); ?> (px)</h3>
					<input type="number" name="auycht_width" value="<?php if(empty(get_option('auycht_width'))){ echo esc_attr("350"); } else {echo esc_attr( get_option('auycht_width') );} ?>" />
				</div>
				
				<div class="col-sm-2">
					<h3><?php _e("Height", "auyautochat-for-wp"); ?> (px)</h3>
					<input type="number" name="auycht_height" value="<?php if(empty(get_option('auycht_height'))){ echo esc_attr("450"); } else {echo esc_attr( get_option('auycht_height') );} ?>" />
				</div>
			</div>
			<hr>
			
			<h2 class="title"><?php _e("Colors", "auyautochat-for-wp"); ?></h2>
			<div class="row">
			
				<div class="col-sm-2">
					<h3><?php _e("Main color", "auyautochat-for-wp"); ?> </h3>
					<input type="text" name="auycht_main_color" class="tpautochat-color-field" value="<?php echo esc_attr( get_option('auycht_main_color') ); ?>" />
				</div>
				
				<div class="col-sm-2">
					<h3><?php _e("Bubble Background", "auyautochat-for-wp"); ?></h3>
					<input type="text" name="auycht_bubble_color" class="tpautochat-color-field" value="<?php echo esc_attr( get_option('auycht_bubble_color') ); ?>" />
				</div>
				
				<div class="col-sm-2">
					<h3><?php _e("Header text color", "auyautochat-for-wp"); ?> </h3>
					<input type="text" name="auycht_header_color" class="tpautochat-color-field" value="<?php echo esc_attr( get_option('auycht_header_color') ); ?>" />
				</div>
				
			</div>
			<hr>
			
			<h2 class="title"><?php _e("Email", "auyautochat-for-wp"); ?></h2>
			<div class="row">
				<div class="col-2">
					<h3><?php _e("To", "auyautochat-for-wp"); ?> *</h3>
					<input type="text" name="auycht_email_to" required value="<?php echo esc_attr( get_option('auycht_email_to') ); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-4">
					<h3><?php _e("Subject", "auyautochat-for-wp"); ?> *</h3>
					<input type="text" name="auycht_email_subject" value="<?php echo esc_attr( get_option('auycht_email_subject') ); ?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2">
					<h3><?php _e("Cc:", "auyautochat-for-wp"); ?></h3>
					<input type="text" name="auycht_email_cc" value="<?php echo esc_attr( get_option('auycht_email_cc') ); ?>" />
				</div>
				
				<div class="col-sm-2">
					<h3><?php _e("Bcc:", "auyautochat-for-wp"); ?></h3>
					<input type="text" name="auycht_email_bcc" value="<?php echo esc_attr( get_option('auycht_email_bcc') ); ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 terms_cont">
					<input type="checkbox" name="auycht_terms" <?php if(get_option('auycht_terms') == "true"){echo esc_attr("checked");}?> /> <label><b>*<?php _e("I accept the display of the Autochat Logo on my Auy Automatic Conversation Button.", "auyautochat-for-wp"); ?></b></label>
				</div>
			</div>
			
			<button type="button" class="auycht_save_settings"><?php _e("Save settings", "auyautochat-for-wp"); ?></button>
			<div class="result"></div>
			<script>
				jQuery(document).ready(function(){
					jQuery(".auycht_save_settings").on("click", function(){
						
						var auy_to 		= jQuery("input[name=auycht_email_to]").val();
						var auy_subject = jQuery("input[name=auycht_email_subject]").val();
						var auy_terms = jQuery("input[name='auycht_terms']").is(":checked");
						console.log(auy_terms);
						if(auy_to == "" || auy_subject == "" || auy_to == null || auy_subject == null || auy_terms == "false" || auy_terms == ""){
							jQuery(".result").addClass("no get");
							var msj = '<?php _e("There was an error in the settings configuration", "auyautochat-for-wp");?>'
							jQuery(".result").text(msj);
							
							if(auy_to == "" || auy_to == null){
								jQuery("input[name=auycht_email_to]").attr("style", "border: solid 1px red");
							}
							
							if(auy_subject == "" || auy_subject == null){
								jQuery("input[name=auycht_email_subject]").attr("style", "border: solid 1px red");
							}
							
							if(auy_terms == "" || auy_terms == null || auy_terms == "false"){
								jQuery(".terms_cont").attr("style", "border: solid 1px red");
							}
							
							setTimeout(function (){
								jQuery(".result").removeClass("no get");
								jQuery(".result").text("");
							}, 5000);
						}else{
							
							auycht_save_settings_call();
							auycht_save_server_settings();
							
						}
						
						
					});
					
					function auycht_save_settings_call(){
						var auycht_save	= jQuery("input[name='auycht_save']").val();
						var auycht_domain	= '<?php echo esc_url(get_site_url()); ?>';
						var auycht_intro_message = jQuery("textarea[name='auycht_intro_message']").val();
						var auycht_title = jQuery("input[name='auycht_title']").val();
						var auycht_placeholder = jQuery("input[name='auycht_placeholder']").val();
						var auycht_message_time = jQuery("input[name='auycht_message_time']").is(":checked");
						var auycht_width = jQuery("input[name='auycht_width']").val();
						var auycht_height = jQuery("input[name='auycht_height']").val();
						var auycht_main_color = jQuery("input[name='auycht_main_color']").val();
						var auycht_bubble_color = jQuery("input[name='auycht_bubble_color']").val();
						var auycht_header_color = jQuery("input[name='auycht_header_color']").val();
						var auycht_email_to = jQuery("input[name='auycht_email_to']").val();
						var auycht_email_subject = jQuery("input[name='auycht_email_subject']").val();
						var auycht_email_cc = jQuery("input[name='auycht_email_cc']").val();
						var auycht_email_bcc = jQuery("input[name='auycht_email_bcc']").val();
						var auycht_chatbot_name = jQuery("input[name='auycht_chatbot_name']").val();
						var auycht_conv_ask_hour = jQuery("input[name='auycht_conv_ask_hour']").is(":checked");
						var auycht_email_validation = jQuery("input[name='auycht_email_validation']").is(":checked");
						var auycht_lang = jQuery("select[name='auycht_lang'] option:selected").val();
						var auycht_on_off = jQuery("input[name='auycht_on_off']").is(":checked");
						var auycht_terms = jQuery("input[name='auycht_terms']").is(":checked");
						
						var params = {
							"auycht_save" 				: auycht_save,
							"auycht_domain" 			: auycht_domain,
							"auycht_intro_message" 		: auycht_intro_message,
							"auycht_title" 				: auycht_title,
							"auycht_placeholder" 		: auycht_placeholder,
							"auycht_message_time" 		: auycht_message_time,
							"auycht_width" 				: auycht_width,
							"auycht_height" 			: auycht_height,
							"auycht_main_color" 		: auycht_main_color,
							"auycht_bubble_color" 		: auycht_bubble_color,
							"auycht_header_color" 		: auycht_header_color,
							"auycht_email_to" 			: auycht_email_to,
							"auycht_email_subject" 		: auycht_email_subject,
							"auycht_email_cc" 			: auycht_email_cc,
							"auycht_email_bcc" 			: auycht_email_bcc,
							"auycht_chatbot_name" 		: auycht_chatbot_name,
							"auycht_conv_ask_hour" 		: auycht_conv_ask_hour,
							"auycht_email_validation" 	: auycht_email_validation,
							"auycht_lang" 				: auycht_lang,
							"auycht_on_off" 			: auycht_on_off,
							"auycht_terms" 				: auycht_terms,
							"action"						: "auycht_save_settings"
						};
						var url = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
						auycht_ajax_call(params, url,0);
						
					}
					
					function auycht_save_server_settings(){
						
						var auycht_domain	= '<?php echo esc_url(get_site_url()); ?>';
						var auycht_intro_message = jQuery("textarea[name='auycht_intro_message']").val();
						var auycht_message_time = jQuery("input[name='auycht_message_time']").is(":checked");
						var auycht_email_to = jQuery("input[name='auycht_email_to']").val();
						var auycht_email_subject = jQuery("input[name='auycht_email_subject']").val();
						var auycht_email_cc = jQuery("input[name='auycht_email_cc']").val();
						var auycht_email_bcc = jQuery("input[name='auycht_email_bcc']").val();
						var auycht_chatbot_name = jQuery("input[name='auycht_chatbot_name']").val();
						var auycht_conv_ask_hour = jQuery("input[name='auycht_conv_ask_hour']").is(":checked");
						var auycht_email_validation = jQuery("input[name='auycht_email_validation']").is(":checked");
						var auycht_lang = jQuery("select[name='auycht_lang'] option:selected").val();
						
						var params = {
							"domain" 			: auycht_domain,
							"language" 			: auycht_lang,
							"call_hour" 		: auycht_conv_ask_hour,
							"email_validation" 	: auycht_email_validation,
							"time" 				: auycht_message_time,
							"name" 				: auycht_chatbot_name,
							"intro_message" 	: auycht_intro_message,
							"to" 				: auycht_email_to,
							"subject" 			: auycht_email_subject,
							"cc" 				: auycht_email_cc,
							"bcc" 				: auycht_email_bcc,
						};
						
						var url = 'https://admin.autochat.uy/admin/apis/guardarChatbot.php';
						auycht_ajax_call(params, url, 1);
						
					}
					
					function auycht_ajax_call(params, url, server){
						
						jQuery.ajax({
							data:  params,
							url:   url,
							type:  'post',
							beforeSend: function () {
								jQuery(".result").html("Processing...");
							},
							success:  function (response) {
								jQuery(".result").html(response);
								if(server){
									params_server = {
										"cId" 	: response,
										"action" : "auycht_saveCid",
									}
									var url_server = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
									auycht_ajax_call(params_server, url_server, 0)
								}
								
								jQuery("input[name=auycht_email_to]").attr("style", "border: solid 1px #7e8993");
								jQuery("input[name=auycht_email_subject]").attr("style", "border: solid 1px #7e8993");
								
								jQuery(".result").addClass("yes get");
								
								var msj = '<?php _e("Changes saved successfully", "auyautochat-for-wp");?>'
								jQuery(".result").text(msj);
								
								setTimeout(function (){
									jQuery(".result").removeClass("yes get");
									jQuery(".result").text("");
								}, 5000);
								
							},
										
							error:  function (response) {
								jQuery(".result").html("error");
							}
						});
					}
					
					
					//Chatframe script
					var ch_title 		 = '<?php echo esc_attr($title); ?>';
					var ch_intro_message = '<?php echo esc_attr($introMessage); ?>';
					var ch_placeholder 	 = '<?php echo esc_attr($placeholderText); ?>';
					
					jQuery("input[name='auycht_title']").on("keyup", function(){
						
						if(jQuery(this).val() == ""){
							jQuery('.chatframe_preview .title .txt').html(ch_title);
						}else{
							jQuery('.chatframe_preview .title .txt').html(jQuery(this).val());
						}
						
					});
					
					jQuery("input[name='auycht_placeholder']").on("keyup", function(){
						
						if(jQuery(this).val() == ""){
							jQuery('.chatframe_preview .footer .input').html(ch_placeholder);
						}else{
							jQuery('.chatframe_preview .footer .input').html(jQuery(this).val());
						}
						
					});
					
					jQuery("input[name='auycht_chatbot_name']").on("keyup", function(){
						
						jQuery('.chatframe_preview .body .msg .chname').html(jQuery(this).val()+': ');
						if(jQuery(this).val() == ""){
							jQuery('.chatframe_preview .body .msg .chname').html("");
						}
						
					});
					
					jQuery("textarea[name='auycht_intro_message']").on("keyup", function(){
						
						if(jQuery(this).val() == ""){
							jQuery('.chatframe_preview .body .msg .content').html(ch_intro_message);
						}else{
							jQuery('.chatframe_preview .body .msg .content').html(jQuery(this).val());
						}
						
					});
					
					jQuery("input[name='auycht_message_time']").on("click", function(){
						if( jQuery(this).is(':checked') ){
							var dt = new Date();
							var time = dt.getHours() + ":" + dt.getMinutes();
							jQuery('.chatframe_preview .body .msg .time').html(time);
						}else{
							jQuery('.chatframe_preview .body .msg .time').html("");
						} 
						
					});
					
					
					
					
					setInterval(function(){ 
						var title_color = jQuery("input[name='auycht_main_color']").val();
						var title_text_color = jQuery("input[name='auycht_header_color']").val();
						var title_bubble_color = jQuery("input[name='auycht_bubble_color']").val();
						
						if(title_color != ""){
							jQuery(".chatframe_preview .title").css("background", title_color);
						}else{
							jQuery(".chatframe_preview .title").css("background", "#74aa41");
						}
						
						if(title_text_color != ""){
							jQuery(".chatframe_preview .txt").css("color", title_text_color);
						}else{
							jQuery(".chatframe_preview .txt").css("color", "white");
						}
						
						if(title_bubble_color != ""){
							jQuery(".chatframe_preview .bubble").css("background", title_bubble_color);
						}else{
							jQuery(".chatframe_preview .bubble").css("background", "#74aa41");
						}
						
					}, 10);
					
					
				});
			</script>

		</form>
	</div>
		
	<?php
}

function auycht_register_mysettings() { 
	
	register_setting( 'auycht_opt', 'auycht_intro_message');
	register_setting( 'auycht_opt', 'auycht_title' );
	register_setting( 'auycht_opt', 'auycht_placeholder' );
	register_setting( 'auycht_opt', 'auycht_message_time' );
	register_setting( 'auycht_opt', 'auycht_width' );
	register_setting( 'auycht_opt', 'auycht_height' );
	register_setting( 'auycht_opt', 'auycht_main_color' );
	register_setting( 'auycht_opt', 'auycht_bubble_color' );
	register_setting( 'auycht_opt', 'auycht_header_color' );
	register_setting( 'auycht_opt', 'auycht_email_to' );
	register_setting( 'auycht_opt', 'auycht_email_subject' );
	register_setting( 'auycht_opt', 'auycht_email_cc' );
	register_setting( 'auycht_opt', 'auycht_email_bcc' );
	register_setting( 'auycht_opt', 'auycht_chatbot_name');
	register_setting( 'auycht_opt', 'auycht_conv_ask_hour');
	register_setting( 'auycht_opt', 'auycht_email_validation');
	register_setting( 'auycht_opt', 'auycht_lang');
	register_setting( 'auycht_opt', 'auycht_on_off');
	register_setting( 'auycht_opt', 'auycht_terms');
}

function auycht_get_settings(){
	
	$introMessage 		= __('Hi. What can I do for you?', "auyautochat-for-wp");
	$title 				= __('Chat with us', "auyautochat-for-wp");
	$placeholderText 	= __('Write an answer ...', "auyautochat-for-wp");
	
	if(empty(get_option('auycht_lang'))){
		$lang = 'en'; 
	}else{
		$lang = get_option('auycht_lang'); 
	}
	
	if(get_option('auycht_intro_message') <> ""){
		$introMessage = get_option('auycht_intro_message');
	}else{
		switch ($lang) {
			case "en":
					$introMessage = 'Hi. What can I do for you?';
			break;
			case "es":
					$introMessage = 'Hola, en qué puedo ayudarte?';
			break;
			case "pt":
					$introMessage = 'Oi. O que posso fazer para você?';
			break;
			case "de":
					$introMessage = 'Hallo. Was kann ich für Dich tun?';
			break;
			case "fr":
					$introMessage = 'Salut. Que puis-je faire pour vous?';
			break;
			case "it":
					$introMessage = 'Ciao. Cosa posso fare per lei?';
			break;
			case "id":
					$introMessage = 'Hai. Apa yang bisa saya lakukan untuk Anda?';
			break;
			case "ms":
					$introMessage = 'Hi. Apa yang boleh saya lakukan untuk anda?';
			break;
			case "pl":
					$introMessage = 'Cześć. Co mogę dla ciebie zrobić?';
			break;
			case "zh":
					$introMessage = '你好 我能為你做什麼？';
			break;
			case "hi":
					$introMessage = 'नमस्ते। मै आप के लिये क्य कर सक्त हु?';
			break;
			case "ja":
					$introMessage = 'こんにちは。 どういうご用件ですか？';
			break;
		}
	}

	$chatbotName = get_option('auycht_chatbot_name');
	if(!empty($chatbotName)){
		$introMessage = '<span class="chname">'.$chatbotName.'</span>' . ': '. $introMessage;
	}

	if(get_option('auycht_title') <> ""){
		$title = get_option('auycht_title');
	}

	if(get_option('auycht_placeholder') <> ""){
		$placeholderText = get_option('auycht_placeholder');
	}
	
	if(empty(get_option('auycht_message_time'))){
		$displayMessageTime = false;
	}else{
		$displayMessageTime = get_option('auycht_message_time');
		if($displayMessageTime == "true"){
			$displayMessageTime = true;
		}else{
			$displayMessageTime = false;
		}
		
	}

	if(empty(get_option('auycht_height'))){
		$desktopHeight = 300;
	}else{
		$desktopHeight = (int)get_option('auycht_height');
	}

	if(empty(get_option('auycht_width'))){
		$desktopWidth = 370;
	}else{
		$desktopWidth = (int)get_option('auycht_width');
	}
	
	if(empty(get_option('auycht_main_color'))){
		$mainColor = '#74aa41';
	}else{
		$mainColor = get_option('auycht_main_color');
	}
	
	if(empty(get_option('auycht_bubble_color'))){
		$bubbleBackground = '#74aa41';
	}else{
		$bubbleBackground = get_option('auycht_bubble_color');
	}

	if(empty(get_option('auycht_header_color'))){
		$headerTextColor = '#FFF';
	}else{
		$headerTextColor = get_option('auycht_header_color'); 
	}
	
	if(isset($_COOKIE['auy_conv_id'])){
		$userId = sanitize_text_field($_COOKIE['auy_conv_id']);
	}else{
		setcookie('auy_conv', "", time() - 3600, "/");
		setcookie('auy_loading',"", time() - 3600, "/");
		$userId = md5(microtime().rand());
		setcookie('auy_conv_id',  $userId, time() + 25*60, "/");
	}
	
	if(empty(get_option('auycht_client_id'))){
		$clientId = '0';
	}else{
		$clientId = get_option('auycht_client_id'); 
	}
	
	global $wp_query;
	
	$postPermalink = post_permalink($wp_query->post->ID, true);
	$domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	

	if ( get_option('permalink_structure') ) { 
		$pluginUrl = get_site_url().'/chatframe/';
	}else{
		$pluginUrl = get_site_url().'/?chatframe=1/';
	}
	
	$settings = array( 
		'pluginUrl' 			=> $pluginUrl,
		'conversationUrl' 		=> "https://admin.autochat.uy/conversation.php?domain=$domain&from=$postPermalink&lang=$lang",
		'introMessage' 			=> $introMessage,
		'title' 				=> $title,
		'placeholderText' 		=> $placeholderText,
		'displayMessageTime' 	=> $displayMessageTime,
		'desktopHeight' 		=> $desktopHeight,
		'desktopWidth' 			=> $desktopWidth,
		'mainColor' 			=> $mainColor,
		'bubbleBackground' 		=> $bubbleBackground,
		'headerTextColor' 		=> $headerTextColor,
		'userId' 				=> $userId,
		'clientId' 				=> $clientId,
		'bubbleAvatarUrl' 		=> AUYCHT_DIR. 'assets/img/icon-message.png',
		'convFinish'			=> "Conversación finalizada",
	);
	

	return $settings;
}

function auycht_save_settings(){
	
	if ( !current_user_can( 'manage_options' ) )  {
		return;
	}
	
	$save 		= sanitize_text_field($_POST['auycht_save']);
	$nonce_name   = isset( $save ) ? $save : '';
	$nonce_action = 'auycht_options_save';
	
	// Check if nonce is set.
    if ( ! isset( $nonce_name ) ) {
		return;
	}

	// Check if nonce is valid.
	if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
		return;
	}
	
	$intro_message 		= sanitize_text_field($_POST['auycht_intro_message']);
	$title 				= sanitize_text_field($_POST['auycht_title']);
	$placeholder 		= sanitize_text_field($_POST['auycht_placeholder']);
	$message_time 		= sanitize_text_field($_POST['auycht_message_time']);
	$width 				= sanitize_text_field($_POST['auycht_width']);
	$height 			= sanitize_text_field($_POST['auycht_height']);
	$main_color			= sanitize_hex_color($_POST['auycht_main_color']);
	$bubble_color 		= sanitize_hex_color($_POST['auycht_bubble_color']);
	$header_color 		= sanitize_hex_color($_POST['auycht_header_color']);
	$email_to 			= sanitize_email($_POST['auycht_email_to']);
	$email_subject 		= sanitize_text_field($_POST['auycht_email_subject']);
	$email_cc 			= sanitize_email($_POST['auycht_email_cc']);
	$email_bcc 			= sanitize_email($_POST['auycht_email_bcc']);
	$chatbot_name 		= sanitize_text_field($_POST['auycht_chatbot_name']);
	$conv_ask_hour 		= sanitize_text_field($_POST['auycht_conv_ask_hour']);
	$email_validation 	= sanitize_text_field($_POST['auycht_email_validation']);
	$lang 				= sanitize_text_field($_POST['auycht_lang']);
	$on_off 			= sanitize_text_field($_POST['auycht_on_off']);
	$terms 				= sanitize_text_field($_POST['auycht_terms']);
	
	update_option( "auycht_intro_message", $intro_message);
	update_option( "auycht_title", $title);
	update_option( "auycht_placeholder", $placeholder);
	update_option( "auycht_message_time", $message_time);
	update_option( "auycht_width", $width);
	update_option( "auycht_height", $height);
	update_option( "auycht_main_color", $main_color);
	update_option( "auycht_bubble_color", $bubble_color);
	update_option( "auycht_header_color", $header_color);
	update_option( "auycht_email_to", $email_to);
	update_option( "auycht_email_subject", $email_subject);
	update_option( "auycht_email_cc", $email_cc);
	update_option( "auycht_email_bcc", $email_bcc);
	update_option( "auycht_chatbot_name", $chatbot_name);
	update_option( "auycht_conv_ask_hour", $conv_ask_hour);
	update_option( "auycht_email_validation", $email_validation);
	update_option( "auycht_lang", $lang);
	update_option( "auycht_on_off", $on_off);
	update_option( "auycht_terms", $terms);
	
	wp_reset_postdata();
	die();
}
add_action('wp_ajax_auycht_save_settings', 'auycht_save_settings');
add_action('wp_ajax_nopriv_auycht_save_settings', 'auycht_save_settings');


function auycht_saveCid(){
	
	$client_id	= sanitize_text_field($_POST["cId"]);
	update_option( "auycht_client_id", $client_id);
	
	wp_reset_postdata();
	die();
}
add_action('wp_ajax_auycht_saveCid', 'auycht_saveCid');
add_action('wp_ajax_nopriv_auycht_saveCid', 'auycht_saveCid');

?>