<?php
function ubernet_sms_send_sms($customer_phone, $customer_msg, $admin_msg){

	$options = get_option( 'ubernet_sms_settings' );
	$apikey = $options['ubernet_sms_api_key'];
	
	
	$admin_phone = $options['ubernet_sms_admin_no'];

	$api_url = "http://www.btssms.com/smsapimany";

	$data = [
		"api_key" => $apikey,
		"senderid" => $options['ubernet_sms_api_mask'],
		"messages" => json_encode( [
		[
			"to" => $customer_phone,
			"message" => $customer_msg
		],
		[
			"to" => $admin_phone,
			"message" => $admin_msg
		]
		])
	];

	$args = array(
	    'body' => $data,
	    'timeout' => '5',
	    'redirection' => '5',
	    'httpversion' => '1.0',
	    'blocking' => true,
	    'headers' => array(),
	    'cookies' => array()
	);

	if ($options['ubernet_sms_select_provider'] == 'ubernet') {
		$response = wp_remote_post( $api_url, $args );
		file_put_contents(plugin_dir_path( __FILE__ ) . 'logs/log_'.time().'.log', serialize($data));
	}

	return false;
}
