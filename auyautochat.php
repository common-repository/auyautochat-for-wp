<?php
/*
Plugin Name: Autochat Automatic Conversation
Plugin URI: https://autochat.uy/free-whatsapp-plugin-wp/
Description: Autochat - Automatic chat conversation 24x7! The easiest way to stay in touch with your customers and get more leads!
Version: 1.1.9
Author: Autochat
Author URI: https://autochat.uy
License: GPLv2 or later
Text Domain: auyautochat-for-wp
Domain Path: /languages/
*/

define('AUYCHT_DIR', plugin_dir_url( __FILE__ ));

include_once dirname( __FILE__ ) . '/includes/options.php';

function auycht_add_scripts() {
	
	global $wp_query;
	
	global $post;
	
	$clientId = get_option('auycht_client_id');
	$active = true;

	if($clientId <> ""){
		$active = auycht_clientIsActive($clientId);
	}
	
	if(get_option('auycht_on_off') == "true" and $active and get_option('auycht_terms') == "true"){
		
		wp_enqueue_script( 'auycht_autochat', AUYCHT_DIR . 'assets/js/config_widget.js', array ( 'jquery' ), 1.1, true);
		
		wp_enqueue_script( 'auycht_widget', AUYCHT_DIR . 'assets/js/widget.js', array ( 'jquery' ), 1.1, true);

		$settings = auycht_get_settings();
		
		wp_localize_script( 'auycht_autochat', 'settings', $settings );
		
		wp_register_style('auycht_stylescss', AUYCHT_DIR . 'assets/css/styles.css');
		wp_enqueue_style('auycht_stylescss');
	}
	
	if(get_query_var('chatframe')){
		
		wp_register_script('auycht_chat_js', AUYCHT_DIR . 'assets/js/chat.js');
		wp_enqueue_script('auycht_chat_js');
		
	}
	
}
add_action( 'wp_enqueue_scripts', 'auycht_add_scripts' );

function auycht_color_picker(){

	wp_enqueue_style( 'wp-color-picker' );

    wp_enqueue_script( 'auycht_color-picker', AUYCHT_DIR . 'assets/js/color-picker.js', array( 'wp-color-picker' ), false, true );
	
}
add_action( 'admin_enqueue_scripts', 'auycht_color_picker' );

function auycht_admin_style($tpw_hook) {
	
	if($tpw_hook == "toplevel_page_auy_autochat"){
		wp_register_style('auy_autochat_panel_style', AUYCHT_DIR . 'assets/css/admin.css', __FILE__);
		wp_enqueue_style('auy_autochat_panel_style');
		
		wp_register_style('auy_autochat_bootstrapp_style', AUYCHT_DIR . 'assets/css/bootstrap.min.css', __FILE__);
		wp_enqueue_style('auy_autochat_bootstrapp_style');
		
		/*wp_register_style('auy_autochat_bootstrapp_style-toggle', AUYCHT_DIR . 'assets/css/bootstrap-toggle.min.css', __FILE__);
		wp_enqueue_style('auy_autochat_bootstrapp_style-toggle');
		
		wp_enqueue_script( 'auy_autochat_bootstrapp_js-toggle', AUYCHT_DIR . 'assets/js/bootstrap-toggle.min.js' );*/
		
	}
  
}
add_action('admin_enqueue_scripts', 'auycht_admin_style');


function auycht_register_menu_page(){
    add_menu_page('Autochat', __('Auy Autochat', "auyautochat-for-wp"), 'manage_options', 'auy_autochat', 'auycht_OptionsPanel', AUYCHT_DIR . 'assets/img/autocht_ic.png', 6);
}
add_action( 'admin_menu', 'auycht_register_menu_page' );

function auycht_add_language(){
	load_plugin_textdomain('auyautochat-for-wp',FALSE, basename( dirname( __FILE__ ) ) . '/languages/');
}
add_action('plugins_loaded', 'auycht_add_language');

function auycht_clientIsActive($clientId){
	
	$params = array(
		'clientId' => $clientId,
	);
	
	$response = auycht_requestToApi("https://admin.autochat.uy/admin/apis/clienteActivo.php", $params);
	
	return (int) $response;
}

function auycht_getLeftEmails(){
	
	$params = array(
		"domain"	=> get_site_url(),
	);
	
	$response = auycht_requestToApi("https://admin.autochat.uy/admin/apis/cantEmails.php", $params);
	
	return (int) $response;
}

function auycht_requestToApi($url, $params){
	
	$args = array(
		'body' => $params,
		'timeout' => '5',
		'redirection' => '5',
		'httpversion' => '1.0',
		'blocking' => true,
		'headers' => array(),
		'cookies' => array()
	);
	
	$response = wp_remote_post( $url, $args );

    if ($response instanceof WP_Error) {
        return 'error';
    } else if (isset($response['response'])) {
        if($response['response']['code']== 200){
            return $response['body'];
        }
    } else {
        return 'respuesta incorrecta';
    }

}

function auycht_admin_notice() {
	
	$qty = auycht_getLeftEmails();
	$showNotice = false;
	$showBuyLicense = false;
	
	$msg = __("Auy Autochat conversations remaining:", "auyautochat-for-wp");
	
	if($qty >= 1 and $qty <= 10){
		
		$noticeClass = "warning";
		$showNotice = true;
		$showBuyLicense = true;
		
	}elseif($qty == 0){
	
		$noticeClass = "error";
		$showNotice = true;
		$showBuyLicense = true;
	}
	
	if(get_option('auycht_client_id') == ""){
		$noticeClass = "warning";
		$showNotice = true;
		
		$msg = __("Auy Autochat is not configured", "auyautochat-for-wp");
		$qty = ""; 
	}
	
	
	if($showNotice){
		
		?>
		<div class="auy_notice notice notice-<?php echo esc_attr($noticeClass); ?> is-dismissible">
			<p><?php echo esc_attr($msg)." "; ?><b><?php echo esc_attr($qty); ?></b><u><a target="_blank" href="https://autochat.uy/free-automatic-conversation-chat-plugin/">
				
				<?php 
					if($showBuyLicense){
						_e("Buy License", "auyautochat-for-wp");
					}
				?>
				</a></u>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'auycht_admin_notice' );


add_action('query_vars','auycht_set_query_var');
function auycht_set_query_var($vars) {
    array_push($vars, 'chatframe'); // ref url redirected to in add rewrite rule

    return $vars;
}

add_action('init', 'auycht_add_rewrite_rule');
function auycht_add_rewrite_rule(){
    add_rewrite_rule('^chatframe$','index.php?chatframe=1','top');

    //flush the rewrite rules, should be in a plugin activation hook, i.e only run once...

    flush_rewrite_rules();  
}

add_filter('template_include', 'auycht_include_template');
function auycht_include_template($template){

    if(get_query_var('chatframe')){
        
        $new_template = plugin_dir_path( __FILE__ ) . 'chatframe.php';
        if(file_exists($new_template)){
            $template = $new_template;
        } 
        
    }    

    return $template;    

}


