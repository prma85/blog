<?php
#     /*
#     Plugin Name: Google Analytics & Webmaster Tools
#     Plugin URI: https://wordpress.org/plugins/ws-google-webmaster-tools/ 
#     Description: Easily Verify Google Analytics & Webmaster Tools for your Wordpress websites & blogs. 
#     Author: Web Shouter
#     Version: 2.1
#     Author URI: http://www.webshouter.net/               
#     */                                                                                                                                                                                                                  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
define('ws_blog_name',get_bloginfo('name'));                                                                                                             
define('ws_site_url',get_site_url());                                                                                                                                                              
define('ws_plugin_url',plugins_url( '/', __FILE__ ));
                                                   
if (!class_exists('WS_GOOGLE_WEBMASTER_TOOLS')) {    
	                                       
	class WS_GOOGLE_WEBMASTER_TOOLS {                                                         
		                                                                                               
		function __construct() {                
			              
			add_action('admin_menu', array($this, 'ws_menu'));            
			    
			add_action('wp_head', array($this, 'ws_add_webmaster_head'),2);             
			
			/* register activation hook */   
			register_activation_hook( __FILE__, array($this, 'ws_activate') );        
			         
			/* register deactivation hook */ 
			register_deactivation_hook( __FILE__, array($this, 'ws_deactivate') ); 

		}  

	function ws_menu() {
		
		add_options_page( 'Analytics & Webmaster Tools','WS Webmaster Tools','manage_options','ws-google-analytics-and-webmaster-tools', array( $this, 'ws_google_analytics_and_webmaster_tools_settings_page' ) );
		
		add_action( 'admin_init', array($this, 'ws_settings') );
		
	}
	/* register settings */
	function ws_settings() { 
	
		register_setting( 'ws-analytics-settings-group', 'ws_google_analytics_code');
		register_setting( 'ws-webmasters-settings-group', 'ws_google_webmaster_code');
		register_setting( 'ws-webmasters-settings-group', 'ws_bring_webmaster_code');
		register_setting( 'ws-webmasters-settings-group', 'ws_alexa_varify_code');
		
	}
	
	/* add default setting values on activation */
	function ws_activate() { 
	    add_option( 'ws_google_analytics_code', '', '', '' );
		add_option( 'ws_google_webmaster_code', '', '', '' );
		add_option( 'ws_bring_webmaster_code', '', '', '' );
		add_option( 'ws_alexa_varify_code', '', '', '' );
	}
	
	/* delete setting and values on deactivation */
	function ws_deactivate() { 
	    delete_option( 'ws_google_analytics_code');
		delete_option( 'ws_google_webmaster_code');
		delete_option( 'ws_bring_webmaster_code');
		delete_option( 'ws_alexa_varify_code');
	}

	function ws_add_webmaster_head(){
		
		$ws_code = '';
		
		$ws_code .= "\n\n".'<!-- WS Google Webmaster Tools v2.1 - https://wordpress.org/plugins/ws-google-webmaster-tools/ -->' . "\n";
		
		$ws_code .= '<!-- Website - http://www.webshouter.net/ -->' . "\n";
		
		if(get_option('ws_google_webmaster_code')){
		  $ws_code .= '<meta name="google-site-verification" content="'. get_option('ws_google_webmaster_code') .'" />'. "\n";
		}
		
		if(get_option('ws_bring_webmaster_code')){
		  $ws_code .= '<meta name="msvalidate.01" content="'. get_option('ws_bring_webmaster_code') .'" />'. "\n";
		}
		
		if(get_option('ws_alexa_varify_code')){
		  $ws_code .= '<meta name="alexaVerifyID" content="'. get_option('ws_alexa_varify_code') .'" />'. "\n";
		}
		
		if(get_option('ws_google_analytics_code')){
		 	
			$ws_gnl_code = get_option('ws_google_analytics_code');
			
			$ws_code .= $ws_gnl_code . "\n";
			 
		 }
		
		$ws_code .= '<!-- / WS Google Webmaster Tools plugin. -->'.  "\n\n";
		
		echo $ws_code;
		
	}
		
  function ws_google_analytics_and_webmaster_tools_settings_page(){
	 
 ?>

<div class='wrap'> 
	<h1><?php _e('WS Google Webmaster Tools', 'webshouter'); ?></h1>
	
	<p class="description"><?php _e('Google Analytics & Webmaster Tools provides reports and data that can help you understand how different pages on your website are appearing in search results.', 'webshouter'); ?></p>

	<?php include('includes/social-media.php'); ?>

	<?php
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'analytics_settings';
	if(isset($_GET['tab'])) $active_tab = $_GET['tab'];
	?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=ws-google-analytics-and-webmaster-tools&amp;tab=analytics_settings" class="nav-tab <?php echo $active_tab == 'analytics_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Analytics Settings', 'webshouter'); ?></a>
		<a href="?page=ws-google-analytics-and-webmaster-tools&amp;tab=webmaster_settings" class="nav-tab <?php echo $active_tab == 'webmaster_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Webmaster Tools', 'webshouter'); ?></a>
		<a href="?page=ws-google-analytics-and-webmaster-tools&amp;tab=donate_now" class="nav-tab <?php echo $active_tab == 'donate_now' ? 'nav-tab-active' : ''; ?>"><?php _e('Donate Now', 'webshouter'); ?></a>
	</h2>
	
		
		<?php if($active_tab == 'analytics_settings') { ?>
		
		 <form method="post" action="options.php">
		 	
		<?php settings_fields('ws-analytics-settings-group'); ?>
		<?php do_settings_sections('ws-analytics-settings-group'); ?>

		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				
			<h3><?php _e('Google Analytics', 'webshouter'); ?></h3>
			<div class="inside">
				<p><?php _e('In this area, paste your Google Analytics tracking code.', 'webshouter'); ?></p>
				
			<table class="form-table">
				
				<tr valign="top">
                	<td style="width:100%;" colspan="2"><textarea rows="14" cols="90" style="margin: 0px; width: 100%; margin-bottom: 10px;" id="ws_google_analytics_code" name="ws_google_analytics_code"><?php echo get_option('ws_google_analytics_code') ?></textarea></td>
                </tr>
                
                 <tr valign="top">
					  <td colspan="2">
						  <div class="ws_sep"></div>
					 </td>
				 </tr>
                
                <tr valign="top" align="left">
					<td class="frm_wp_heading"><?php submit_button(); ?></td>
				</tr>
				
			</table>
				
			</div>
			</div>
		</div>
		
		</form>
		<?php } ?>
		
		
		
		<?php if($active_tab == 'webmaster_settings') { ?>
		
		 <form method="post" action="options.php">

		<?php settings_fields('ws-webmasters-settings-group'); ?>
		<?php do_settings_sections('ws-webmasters-settings-group'); ?>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
			<h3><?php _e('Webmaster Tools Settings', 'webshouter'); ?></h3>
			<div class="inside">
				<p><?php _e('You can use the boxes below to verify with the different Webmaster Tools, if your site is already verified, you can just forget about these. Enter the verify meta values for:', 'webshouter'); ?></p>
				
			<table class="form-table">
			
				 <tr valign="top">
					  <th scope="row" style="width: 190px;"><label class="checkbox" for="ws_google_webmaster_code"><?php _e('Google Webmaster Tools', 'webshouter'); ?>:</label></th>
					  <td>
						  <input id="ws_google_webmaster_code" type="text" name="ws_google_webmaster_code" value="<?php echo get_option('ws_google_webmaster_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <th scope="row" style="width: 190px;"><label class="checkbox" for="ws_bring_webmaster_code"><?php _e('Bing Webmaster Tools', 'webshouter'); ?>:</label></th>
					  <td>
						  <input id="ws_bring_webmaster_code" type="text" name="ws_bring_webmaster_code" value="<?php echo get_option('ws_bring_webmaster_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <th scope="row" style="width: 190px;"><label class="checkbox" for="ws_alexa_varify_code"><?php _e('Alexa Verification ID', 'webshouter'); ?>:</label></th>
					  <td>
						  <input id="ws_alexa_varify_code" type="text" name="ws_alexa_varify_code" value="<?php echo get_option('ws_alexa_varify_code') ?>" size="50" />
					 </td>
				 </tr>
				 
				 <tr valign="top">
					  <td colspan="2">
						  <div class="ws_sep"></div>
					 </td>
				 </tr>
				 
				<tr valign="top" align="left">
					<td class="frm_wp_heading"><?php submit_button(); ?></td>
				</tr>
		
			</table>
				
			</div>
			</div>
		</div>
		</form>
		<?php } ?>
		
		
		<?php if($active_tab == 'donate_now') { ?>
			
			
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
			<h3><?php _e('Donate Now', 'ws-custom-login'); ?></h3>
				<div class="inside">
					
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="T59LYJEC5HAHC">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					
		        </div>
	        </div>
        </div>
			
		<?php } ?>
		
	</div>

	<?php
	
	 }

	}

}

if (class_exists('WS_GOOGLE_WEBMASTER_TOOLS')) {
	$WS_GOOGLE_WEBMASTER_TOOLS = new WS_GOOGLE_WEBMASTER_TOOLS();
}
?>