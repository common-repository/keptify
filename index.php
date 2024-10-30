<?php
/**
 * Plugin Name: Keptify
 * Plugin URI: https://wordpress.org/plugins/keptify/
 * Description: Connect Keptify with your Wordpress Website
 * Version: 1.5.1
 * Author: Keptify
 * Author URI: http://keptify.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: Keptify
 */

	add_action('admin_menu', 'keptify_menu');
	add_action( 'wp_enqueue_style', 'keptify_menu' );

	function keptify_menu() {
		add_options_page( __('Keptify code'), 'Keptify Code', 'manage_options', 'keptify-code-settings', 'keptify_settings');
		wp_register_style( 'custom-style', plugin_dir_url(__FILE__) . 'css/style.css','','', 'screen' );
		wp_enqueue_style('custom-style');
		wp_enqueue_script('keptify', plugin_dir_url(__FILE__) . 'js/keptify.js');
	}
	
	function addkeptifyplg(){
		add_option( 'keptifycode_key','');
	}
	register_activation_hook(__FILE__,'addkeptifyplg');
		$txtTrackingCode = isset( $_POST['txtTrackingCode'] ) ? $_POST['txtTrackingCode'] : '';
	if(sanitize_text_field( $txtTrackingCode ) !='')
	{
		$removeSpacefromCode	=	str_replace(' ','',$_POST['txtTrackingCode']);
		$keptify_value			=	sanitize_text_field($removeSpacefromCode);
		update_option( 'keptifycode_key', $keptify_value);
		add_action( 'admin_notices', 'keptify_code_notice_for_add_success');
	}
	
	function keptify_code_notice_for_update_success() {
    ?>
    <div class="<?php echo esc_attr( 'notice notice-success is-dismissible' ); ?>">
        <p><?php _e( 'Your keptify code updated successfully.', 'keptify-code-admin' ); ?></p>
    </div>
    <?php
	}
	
	function keptify_code_notice_for_add_success() {
    ?>
    <div class="<?php echo esc_attr( 'notice notice-success is-dismissible' ); ?>">
        <p><?php _e( 'Your keptify code added successfully.', 'keptify-code-admin' ); ?></p>
    </div>
    <?php
	}
	
	function keptify_settings()
	{
		$keptify_options	=	get_option( 'keptifycode_key' );
		?>
		<form method="post" name="codefrm" id="codefrm" action="" autocomplete="off">
			
			<h2 class="form_title"><?php echo esc_html('Keptify Connect'); ?></h2>
			<div class="codebox">
				<div class="<?php echo esc_attr( 'codebox_fields' ); ?>">
				<?php echo esc_url('http://app.keptify.com/'); ?>
				<input type="text" name="txtTrackingCode" id="txtTrackingCode" class="code_input" value="<?php echo $keptify_options; ?>" placeholder="Your keptify code" maxlength="18" onkeyup="checkKeptycode(this.value);" />
				</div>
				<div class="<?php echo esc_attr( 'codebox_submit' ); ?>">
				<?php
				$btnAttr = array( 'class' => 'keptybtn' );
				submit_button ( 'Save code', 'primary', 'keptifysubmit', true, $btnAttr ); ?>
				</div>
			</div>
		</form>		
	<?php
	}
	
	function keptify_code() {
		$keptify_tracking_code		=	esc_attr(get_option( 'keptifycode_key' ));
		?>
		<script type='text/javascript'>
		(function() {
			var s = document.createElement('script'); s.type = 'text/javascript';
			s.async = true;
			s.src = '//app.keptify.com/<?php echo $keptify_tracking_code; ?>';
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
		})();
		</script>
		<?php
	}
	add_action( 'wp_footer', 'keptify_code' );
