<?php
function ubernet_sms_scripts() {
    wp_enqueue_style( 'ubernet_sms_style',  plugin_dir_url( __FILE__ ) . "/css/style.css");
}

add_action( 'admin_print_styles', 'ubernet_sms_scripts' );

add_action( 'admin_menu', 'ubernet_sms_add_admin_menu' );
add_action( 'admin_init', 'ubernet_sms_settings_init' );


function ubernet_sms_add_admin_menu(  ) {

	add_options_page( 'Ubernet SMS', 'Ubernet SMS', 'manage_options', 'ubernet_sms', 'ubernet_sms_options_page' );

}


function ubernet_sms_settings_init(  ) {

	register_setting( 'pluginPage', 'ubernet_sms_settings' );

	add_settings_section(
		'ubernet_sms_pluginPage_api_section',
		__( 'API SETTINGS', 'ubernet-sms' ),
		'ubernet_sms_settings_api_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'ubernet_sms_enable_sms',
		__( 'SMS Notification:', 'ubernet-sms' ),
		'ubernet_sms_enable_sms_render',
		'pluginPage',
		'ubernet_sms_pluginPage_api_section'
	);

	add_settings_field(
		'ubernet_sms_select_provider',
		__( 'Select SMS Provider', 'ubernet_sms' ),
		'ubernet_sms_select_provider_render',
		'pluginPage',
		'ubernet_sms_pluginPage_api_section'
	);

  	add_settings_field(
		'ubernet_sms_api_key',
		__( 'API Key:', 'ubernet-sms' ),
		'ubernet_sms_api_key_render',
		'pluginPage',
		'ubernet_sms_pluginPage_api_section'
	);

	add_settings_field(
		'ubernet_sms_api_mask',
		__( 'Masking Name:', 'ubernet-sms' ),
		'ubernet_sms_api_mask_render',
		'pluginPage',
		'ubernet_sms_pluginPage_api_section'
	);

	add_settings_field(
		'ubernet_sms_admin_no',
		__( 'Admin Phone no:', 'ubernet-sms' ),
		'ubernet_sms_admin_no_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_section(
		'ubernet_sms_pluginPage_section',
		__( 'SMS TEMPLATES', 'ubernet-sms' ),
		'ubernet_sms_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'ubernet_sms_check_order_placed',
		__( 'New Order:', 'ubernet-sms' ),
		'ubernet_sms_check_order_placed_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_field(
		'ubernet_sms_template_order_placed',
		__( 'Customer SMS Template:', 'ubernet-sms' ),
		'ubernet_sms_template_order_placed_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_field(
		'ubernet_sms_admin_template_order_placed',
		__( 'Admin SMS Template:', 'ubernet-sms' ),
		'ubernet_sms_admin_template_order_placed_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_field(
		'ubernet_sms_check_order_processing',
		__( 'Order Processing:', 'ubernet-sms' ),
		'ubernet_sms_check_order_processing_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_field(
		'ubernet_sms_template_order_processing',
		__( 'SMS Template:', 'ubernet-sms' ),
		'ubernet_sms_template_order_processing_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_field(
		'ubernet_sms_check_order_completed',
		__( 'Order Complete:', 'ubernet-sms' ),
		'ubernet_sms_check_order_completed_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);

	add_settings_field(
		'ubernet_sms_template_order_completed',
		__( 'SMS Template:', 'ubernet-sms' ),
		'ubernet_sms_template_order_completed_render',
		'pluginPage',
		'ubernet_sms_pluginPage_section'
	);


}


function ubernet_sms_enable_sms_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='checkbox' name='ubernet_sms_settings[ubernet_sms_enable_sms]' <?php checked( $options['ubernet_sms_enable_sms'], 1 ); ?> value='1'> Enable
	<?php

}


function ubernet_sms_select_provider_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<select name='ubernet_sms_settings[ubernet_sms_select_provider]'>
    	<option value='ubernet' <?php selected( $options['ubernet_sms_select_provider'], 'ubernet' ); ?>>Ubernet SMS</option>
	</select>
	<?php

}

function ubernet_sms_api_key_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='text' name='ubernet_sms_settings[ubernet_sms_api_key]' value='<?php echo $options['ubernet_sms_api_key']; ?>'>
  	<p><i>If you use API KEY, You don't have to enter user name and password.</i></p>
	<?php
}



function ubernet_sms_api_mask_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='text' name='ubernet_sms_settings[ubernet_sms_api_mask]' value='<?php echo $options['ubernet_sms_api_mask']; ?>'>
	<?php

}


function ubernet_sms_check_order_placed_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='checkbox' name='ubernet_sms_settings[ubernet_sms_check_order_placed]' <?php checked( $options['ubernet_sms_check_order_placed'], 1 ); ?> value='1'> Enable SMS
	<?php

}


function ubernet_sms_template_order_placed_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<textarea cols='40' rows='5' name='ubernet_sms_settings[ubernet_sms_template_order_placed]'><?php echo $options['ubernet_sms_template_order_placed']; ?></textarea>
	<?php

}

function ubernet_sms_admin_no_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='text' name='ubernet_sms_settings[ubernet_sms_admin_no]' value='<?php echo $options['ubernet_sms_admin_no']; ?>'>
  	<p><i>Admin phone no for getting specific notifications.</i></p>
	<?php
}

function ubernet_sms_admin_template_order_placed_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<textarea cols='40' rows='5' name='ubernet_sms_settings[ubernet_sms_admin_template_order_placed]'><?php echo $options['ubernet_sms_admin_template_order_placed']; ?></textarea>
	<?php

}


function ubernet_sms_check_order_processing_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='checkbox' name='ubernet_sms_settings[ubernet_sms_check_order_processing]' <?php checked( $options['ubernet_sms_check_order_processing'], 1 ); ?> value='1'> Enable SMS
	<?php

}


function ubernet_sms_template_order_processing_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<textarea cols='40' rows='5' name='ubernet_sms_settings[ubernet_sms_template_order_processing]'><?php echo $options['ubernet_sms_template_order_processing']; ?></textarea>
	<?php

}


function ubernet_sms_check_order_completed_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<input type='checkbox' name='ubernet_sms_settings[ubernet_sms_check_order_completed]' <?php checked( $options['ubernet_sms_check_order_completed'], 1 ); ?> value='1'> Enable SMS
	<?php

}


function ubernet_sms_template_order_completed_render(  ) {

	$options = get_option( 'ubernet_sms_settings' );
	?>
	<textarea cols='40' rows='5' name='ubernet_sms_settings[ubernet_sms_template_order_completed]'><?php echo $options['ubernet_sms_template_order_completed']; ?></textarea>
	<?php

}


function ubernet_sms_settings_section_callback(  ) {

	echo __( 'Please enter your sms body text you want to send. <p>Use <span>{{ordernumber}}</span> <span>{{customername}}</span> for dynamic information.</p>', 'ubernet-sms' );

}

function ubernet_sms_settings_api_section_callback(  ) {

	echo __( 'Please enter your SMS API information of Notify.', 'ubernet-sms' );

}


function ubernet_sms_options_page(  ) {

		?>
		<div class="ubernet_sms_settings_page">
			<div class="ubernet_sms_settings_page_inner">
				<div class="ubernet_sms_settings_page_header">

					<div class="ubernet_sms_settings_page_header_info">
						<h2><?php echo __("Ubernet SMS");?></h2>
					</div>
				</div>
				<div class="ubernet_sms_settings_page_body">
					<form action='options.php' method='post'>
						<?php
						settings_fields( 'pluginPage' );
						do_settings_sections( 'pluginPage' );
						submit_button();
						?>
					</form>
				</div>
				<div class="ubernet_sms_settings_page_footer">
					<h4><strong><?php echo __("Please Note:</strong> This is a third-party plugin.<br>This plugin is not developed or managed by SMS providers.");?></h4>
					<p>Developed by: <a href="https://moshiur.pro" target="_blank"><?php echo __("Moshiur Rahman");?></a></p>
				</div>
			</div>
		</div>

		<?php

}
