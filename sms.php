<?php
function ubernet_sms_send_sms($customer_phone, $customer_msg, $admin_msg){

	$options = get_option( 'ubernet_sms_settings' );
	$apikey = $options['ubernet_sms_api_key'];
	
	
	$admin_nums = $options['ubernet_sms_admin_no'];
	$admin_sms_array = [];
    if($admin_nums != "") {
        $admin_nums = explode(",", $admin_nums);
        foreach($admin_nums as $admin_num){
            $msg = ["to" => $admin_num, "message" => $admin_msg];
            array_push($admin_sms_array, $msg);
        }
    }


	$api_url = "http://www.btssms.com/smsapimany";

	$data = [
		"api_key" => $apikey,
		"senderid" => $options['ubernet_sms_api_mask'],
		"messages" => json_encode([array_merge(["to" => "customer","message" => "customer msg"],$admin_sms_array)])
		/*messages" => json_encode([
			[
				"to" => $customer_phone,
				"message" => $customer_msg
			],
			...$admin_sms_array
		])*/
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
