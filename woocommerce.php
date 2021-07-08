<?php
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    // the woocommerce_new_order callback
	function ubernet_sms_action_woocommerce_new_order($order_id) {
		$order = wc_get_order( $order_id );
		$options = get_option( 'ubernet_sms_settings' );
		$customer_phone = $order->get_billing_phone();
		$customer_name = $order->get_billing_first_name().' '.$order->get_billing_first_name();


		$admin_msg = $options['ubernet_sms_admin_template_order_placed'];
		$admin_msg = str_replace("{{ordernumber}}", $order_id, $admin_msg);
		$admin_msg = str_replace("{{customername}}", $customer_name , $admin_msg);


		$smsbody = $options['ubernet_sms_template_order_placed'];
		$smsbody = str_replace("{{ordernumber}}", $order_id, $smsbody);
		$smsbody = str_replace("{{customername}}", $order->get_billing_first_name(), $smsbody);

		if ($options['ubernet_sms_enable_sms'] == 1 && $options['ubernet_sms_check_order_placed'] == 1) {
			ubernet_sms_send_sms($customer_phone, $smsbody, $admin_msg);
		}
	};
	add_action( 'woocommerce_new_order', 'ubernet_sms_action_woocommerce_new_order', 10, 3 );

	// the woocommerce_order_processing callback
	function ubernet_sms_action_woocommerce_order_processing($order_id) {
		$order = wc_get_order( $order_id );
		$options = get_option( 'ubernet_sms_settings' );
		$customerphonenumber = $order->get_billing_phone();
		$smsbody = $options['ubernet_sms_template_order_processing'];
		$smsbody = str_replace("{{ordernumber}}", $order_id, $smsbody);
		$smsbody = str_replace("{{customername}}", $order->get_billing_first_name(), $smsbody);
		if ($options['ubernet_sms_enable_sms'] == 1 && $options['ubernet_sms_check_order_processing'] == 1) {
			ubernet_sms_send_sms($customerphonenumber, $smsbody);
		}
	};
	add_action( 'woocommerce_order_status_processing', 'ubernet_sms_action_woocommerce_order_processing', 10, 3 );

	// the woocommerce_ordercompleted callback
	function ubernet_sms_action_woocommerce_order_completed($order_id) {
		$order = wc_get_order( $order_id );
		$options = get_option( 'ubernet_sms_settings' );
		$customerphonenumber = $order->get_billing_phone();
		$smsbody = $options['ubernet_sms_template_order_completed'];
		$smsbody = str_replace("{{ordernumber}}", $order_id, $smsbody);
		$smsbody = str_replace("{{customername}}", $order->get_billing_first_name(), $smsbody);
		if ($options['ubernet_sms_enable_sms'] == 1 && $options['ubernet_sms_check_order_completed'] == 1) {
			ubernet_sms_send_sms($customerphonenumber, $smsbody);
		}
	};
	add_action( 'woocommerce_order_status_completed', 'ubernet_sms_action_woocommerce_order_completed', 10, 3 );

}
