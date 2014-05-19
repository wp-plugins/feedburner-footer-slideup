<?php
/*
	Plugin Name: FeedBurner Footer SlideUp
	Plugin URI: http://wordpress.org/extend/plugins/feedburner-footer-slideup/
	Description: Footer Slideup Form is one of the best ways to ask your user to subscribe to your list without any interruption or blocking and this plugin does exactly that. It adds an FeedBurner subscribe sliding form in the footer of your Wordpress blog.
	Author: Shabbir Bhimani
	Version: 1.10
	Author URI: http://imtips.co/feedburner-footer-slideup.html
 */
if ( ! defined( 'WP_CONTENT_URL' ) )
    define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
if ( ! defined( 'PLUGIN_ABS_URL' ) )
	define('PLUGIN_ABS_URL', WP_PLUGIN_URL . '/feedburner-footer-slideup');

function fbfs_js()
{
	if(!get_option('fbfs_no_jquery')) wp_enqueue_script( 'jquery' );

	wp_enqueue_script(
		'fbfs_cookie_script',
		PLUGIN_ABS_URL . '/js/jquery-cookie.js',
		array('jquery')
	);
	wp_enqueue_script(
		'fbfs_libs_script',
		PLUGIN_ABS_URL . '/js/jquery-libs.js',
		array('jquery')
	);
}

function fbfs_header_elements()
{
?>
<?php if(!get_option('fbfs_no_css')) : ?><link rel="stylesheet" href="<?php echo PLUGIN_ABS_URL; ?>/style.css" type="text/css" media="screen" /><?php endif ?>
<?php
}

function fbfs_form()  {
$fbfs_fburi = get_option('fbfs_fburi');
if($fbfs_fburi =='') return;
?>
<div id="footerform">
	<div class="close">
		<?php if(!get_option('fbfs_no_close')) : ?><div id="closefornow"> <a href="#" onclick="slidedown(); return false;">Close for now.</a></div> <?php endif ?>
	    <?php if(!get_option('fbfs_no_never_show')) : ?><div id="dontshowanymore"><a href="#" onclick="slidedown(); return false;">Never show again.</a></div><?php endif ?>
	</div>

	<div class="tagline"><?php $fbfs_tagline=get_option('fbfs_tagline'); echo $fbfs_tagline==''?'Subscribe By Email for Updates.':$fbfs_tagline; ?></div>
	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="slidedown();savePermCookie();window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $fbfs_fburi ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
		<input type="text" name="email" class="formInputfooter formInputEmailfooter" value="<?php $fbfs_def_email=get_option('fbfs_def_email'); echo $fbfs_def_email==''?'Enter Your Email':$fbfs_def_email; ?>" size="20" />
		<input type="hidden" value="<?php echo $fbfs_fburi ?>" name="uri"/>
		<input type="hidden" name="loc" value="en_US"/>
		<input type="submit" name="submit" class="formInputSubmitfooter" value="<?php $fbfs_def_submit=get_option('fbfs_def_submit'); if($fbfs_def_submit=='-')echo'';else if($fbfs_def_submit=='')echo 'Subscribe Now !!!' ; else echo $fbfs_def_submit;?>">
	</form>
</div>
<?php
}
add_action ( 'wp_enqueue_scripts', 'fbfs_js');
add_action ( 'wp_footer', 'fbfs_form');
add_action ( 'wp_head', 'fbfs_header_elements');
add_action ( 'admin_menu', 'fbfs_plugin_menu');

function fbfs_plugin_menu() 
{
	add_options_page('My Plugin Options', 'FeedBurner Footer SlideUp', 'manage_options', 'fbfs', 'fbfs_plugin_options');
	add_action( 'admin_init', 'register_fbfs_settings' );
}

function register_fbfs_settings() 
{
	//register settings
	register_setting( 'fbfs-settings-group', 'fbfs_tagline' );
	register_setting( 'fbfs-settings-group', 'fbfs_fburi' );
	register_setting( 'fbfs-settings-group', 'fbfs_no_jquery' );
	register_setting( 'fbfs-settings-group', 'fbfs_no_close' );
	register_setting( 'fbfs-settings-group', 'fbfs_no_never_show' );
	register_setting( 'fbfs-settings-group', 'fbfs_no_css' );
	register_setting( 'fbfs-settings-group', 'fbfs_def_email' );
	register_setting( 'fbfs-settings-group', 'fbfs_def_submit' );

}


function fbfs_plugin_options() 
{
?>
<div class="wrap">
<h2>Feedburner Footer Slideup Settings</h2>
<p>Footer Slideup Form is one of the best ways to ask your user to subscribe to your list without any interruption or blocking and this plugin does exactly that. It adds an FeedBurner subscribe sliding form in the footer of your Wordpress blog. </p>
<p>I use and recommend <A HREF="http://imtips.co/feedburner-vs-aweber.html">AWeber over Feedburner</A> for RSS to email but my blog readers wanted to have Slideup plugin for Feedburner like I have for AWeber.</p>
<p>For all your queries, help and support for plugin please post them in comments <A HREF="http://imtips.co/feedburner-footer-slideup.html" target="_blank">at my blog</A>. I will be actively supporting the plugin.</p>
<p><strong>Some people ask me how they can repay me back - which is not necessary - but for those wanting to show their appreciation, I just say linking to my blog <A href="http://imtips.co/">Internet Marketing Tips</a> is the best compensation I could receive.</strong></p>
<!--<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3BLM8E3A4TET8" target="_blank">Donate</a>-->
<form method="post" action="options.php">
<?php settings_fields( 'fbfs-settings-group' ); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Tag Line</th>
<td><input type="text" name="fbfs_tagline" style="width:400px;" value="<?php echo get_option('fbfs_tagline'); ?>" />
<div>If nothing is entered you will see - "Subscribe By Email for Updates"</div>
</td>
</tr>
<tr valign="top">
<th scope="row">FeedBurner URI (Required)
</th>
<td>
<input type="text" name="fbfs_fburi" id="fbfs_fburi" style="width:400px;" value="<?php echo get_option('fbfs_fburi'); ?>" />
<div style="font-weight:bold;color:red;padding-top:10px;">Activate Email subscription for your Feeds under the Publicize Section and get the email subscription form HTML code. Search for uri=SomeString and place the content of SomeString here.</div>
</td>
</tr>
<tr valign="top">
<th scope="row">Don't show Close for Now Link.</th>
<td><INPUT TYPE="checkbox" NAME="fbfs_no_close" id="fbfs_no_close" value="1" <?php if(get_option('fbfs_no_close')) echo 'checked'; ?>>
<div>Close for Now link hides the slider for the current session on every page of your blog. If user closes the browser and re-opens it, he will see the slideup once again.</div>
</td>
</tr>
<tr valign="top">
<th scope="row">Don't show Never Show Again Link.</th>
<td><INPUT TYPE="checkbox" NAME="fbfs_no_never_show" id="fbfs_no_never_show" value="1" <?php if(get_option('fbfs_no_never_show')) echo 'checked'; ?>>
<div>Never Show Again link hides the slider permanently using cookies. You may need to clear cookies to see the slideup once again.</div>
</td>
</tr>
<tr valign="top">
<th scope="row">Don't Include Plugin CSS (I have added the CSS to my theme file).</th>
<td><INPUT TYPE="checkbox" NAME="fbfs_no_css" id="fbfs_no_css" value="1" <?php if(get_option('fbfs_no_css')) echo 'checked'; ?>>
<div>Plugin CSS is stored in <A href="<?php echo PLUGIN_ABS_URL ?>/style.css"><?php echo PLUGIN_ABS_URL ?>/style.css</a> file and you can copy the content of the CSS file and paste into your theme's CSS file. Remember to copy the following image as well.
<p><img style="vertical-align:middle" src="<?php echo PLUGIN_ABS_URL ?>/images/mail.png" /> located @ <a href="<?php echo PLUGIN_ABS_URL ?>/images/mail.png"><?php echo PLUGIN_ABS_URL ?>/images/mail.png</a></p>
If you are using frameworks like Thesis or Genesis you can add them to the custom CSS options they provide. It will reduce an extra file request to the CSS file on your server.</div>
</td>
</tr>
<tr valign="top">
<th scope="row">Default Value in Email Field</th>
<td><input type="text" name="fbfs_def_email" value="<?php echo get_option('fbfs_def_email'); ?>" />
<div>The Default Content of the Email Field. When user clicks the email field this value vanishes. If you leave it as blank, the form will take the default value of "Your Best Email".</div>
</td>
</tr>
<tr valign="top">
<th scope="row">Default Submit Button Text</th>
<td><input type="text" name="fbfs_def_submit" value="<?php echo get_option('fbfs_def_submit'); ?>" />
<div>Button Text. If you leave it as blank, the form will take the default value of "Subscribe" If you want to use an image background enter minus (-) and it will not show any text as output.</div>
</td>
</tr>
<tr valign="top">
<th scope="row">Don't include jQuery through plugin.</th>
<td><INPUT TYPE="checkbox" NAME="fbfs_no_jquery" id="fbfs_no_jquery" value="1" <?php if(get_option('fbfs_no_jquery')) echo 'checked'; ?>>
<div>Never check this box unless you have issues with other sliders disappearing.</div></td>
</tr>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="fbfs_tagline,fbfs_fburi" />
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?php
}
?>
