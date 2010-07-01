<?php
/*
	Plugin Name: FeedBurner Footer SlideUp
	Plugin URI: http://wordpress.org/extend/plugins/feedburner-footer-slideup/
	Description: Footer Slideup Form is one of the best ways to ask your user to subscribe to your list without any interruption or blocking and this plugin does exactly that. It adds an FeedBurner subscribe sliding form in the footer of your Wordpress blog. My personal preference is always <A HREF="http://www.codeitwell.com/feedburner-vs-aweber.html">AWeber over Feedburner</A> for RSS to email.
	Author: Shabbir Bhimani
	Version: 0.1
	Author URI: http://www.codeitwell.com/
 */
if ( ! defined( 'WP_CONTENT_URL' ) )
    define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
function fbfs_header_elements()
{
$plugin_abs_url = WP_PLUGIN_URL.'/feedburner-footer-slideup';
?>
<link rel="stylesheet" href="<?php echo $plugin_abs_url; ?>/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $plugin_abs_url; ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $plugin_abs_url; ?>/js/jquery-cookie.js"></script>
<script type="text/javascript" src="<?php echo $plugin_abs_url; ?>/js/jquery-libs.js"></script>
<?php
}

function fbfs_form()  {
$fbfs_fburi = get_option('fbfs_fburi');
if($fbfs_fburi =='') return;
?>
<div id="footerform">
	<div class="close">
		<div id="closefornow"> <a href="#" onclick="slidedown(); return false;">Close for now.</a></div>
	    <div id="dontshowanymore"><a href="#" onclick="slidedown(); return false;">Never show again.</a></div>
	</div>

	<div class="tagline"><?php $fbfs_tagline=get_option('fbfs_tagline'); echo $fbfs_tagline==''?'Subscribe By Email for Updates.':$fbfs_tagline; ?></div>

	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $fbfs_fburi ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
		<input type="text" name="email" class="formInputfooter formInputEmailfooter" value="Enter Your Email" size="20" />
		<input type="hidden" value="<?php echo $fbfs_fburi ?>" name="uri"/>
		<input type="hidden" name="loc" value="en_US"/>
		<input type="submit" name="submit" class="formInputSubmitfooter" value="Subscribe Now !!!">
	</form>
</div>
<?
}
add_action ( 'wp_footer', 'fbfs_form');
add_action ( 'wp_head', 'fbfs_header_elements');
add_action ( 'admin_menu', 'fbfs_plugin_menu');

function fbfs_plugin_menu() {

	add_options_page('My Plugin Options', 'FeedBurner Footer SlideUp', 'manage_options', 'fbfs', 'fbfs_plugin_options');
	add_action( 'admin_init', 'register_fbfs_settings' );
}

function register_fbfs_settings() {
	//register settings
	register_setting( 'fbfs-settings-group', 'fbfs_tagline' );
	register_setting( 'fbfs-settings-group', 'fbfs_fburi' );
}


function fbfs_plugin_options() {
?>
<div class="wrap">
<p>Footer Slideup Form is one of the best ways to ask your user to subscribe to your list without any interruption or blocking and this plugin does exactly that. It adds an FeedBurner subscribe sliding form in the footer of your Wordpress blog. My personal preference is always <A HREF="http://www.codeitwell.com/feedburner-vs-aweber.html">AWeber over Feedburner</A> for RSS to email.</p>
<p>If you would like to give AWeber a try it is only $1 for the first month and if you do not like it they would even refund your $1. <A HREF="http://www.codeitwell.com/go/aweber1">Click here</A> (Aff Link) to visit AWeber with $1 as coupon</p>
<p>For all your queries, help and support for plugin please post them in comments <A HREF="http://www.codeitwell.com/feedburner-footer-slideup/" target="_blank">at my blog</A>. I will be actively supporting the plugin.</p>
<form method="post" action="options.php">
<?php settings_fields( 'fbfs-settings-group' ); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Heading Tag Line (Optional)</th>
<td><input type="text" name="fbfs_tagline" style="width:400px;" value="<?php echo get_option('fbfs_tagline'); ?>" /></td>
</tr>
<tr valign="top">
<th scope="row">FeedBurner URI (Required)
<div style="font-weight:bold;color:red;padding-top:10px;">Activate Email subscription for your Feeds under the Publicize Section and get the email subscription form HTML code. Search for uri=SomeString and place the content of SomeString here.
</div></th>
<td>
<input type="text" name="fbfs_fburi" id="fbfs_fburi" style="width:400px;" value="<?php echo get_option('fbfs_fburi'); ?>" />
</td>
</tr>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="fbfs_tagline,fbfs_fburi" />
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?
}
?>
