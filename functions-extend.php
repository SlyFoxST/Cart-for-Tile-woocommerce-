<?php

/*function rpf_edit_default_address_fields($fields) {

	/* ------ reordering ------ */
/*	$fields['billing_email']['priority'] = 10;
	$fields['billing_first_name']['priority'] = 20;
	$fields['billing_last_name']['priority'] = 30;
	$fields['address_1']['priority'] = 40;
	$fields['address_2']['priority'] = 50;
*/

/*	return $fields;
}*/
/*add_filter( 'woocommerce_default_address_fields', 'rpf_edit_default_address_fields', 100, 1 );*/

add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');
add_filter( 'woocommerce_checkout_fields' , 'hjs_wc_checkout_fields' );

function hjs_wc_checkout_fields( $fields ) {
	$fields['billing']['billing_email']['label'] = 'דוא"ל';
	$fields['billing']['billing_email']['required'] = true;
	$fields['billing']['billing_first_name']['label'] = 'שם פרטי';
	$fields['billing']['billing_first_name']['required'] = true;
	$fields['billing']['billing_last_name']['label'] = 'שם משפחה';
	$fields['billing']['billing_last_name']['required'] = true;
	$fields['billing']['billing_address_1']['label'] = 'כתובת שורה ראשונה ';
	$fields['billing']['billing_address_1']['placeholder'] = 'מספר בית ושם הרחוב';
	$fields['billing']['billing_address_1']['required'] = true;
	unset($fields['order']['order_comments']);
	return $fields;
}

add_action( 'wp_ajax_form', 'test_function' ); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action( 'wp_ajax_nopriv_form', 'test_function' );  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей

function test_function(){

	$name     = $_POST['name'];
	$lastName = $_POST['lastName'];
	$phone    = $_POST['phone'];
	$email    = $_POST['email'];
	$adress   = $_POST['adress'];
	$home     = $_POST['home'];
	$home2    = $_POST['home2'];
	$id       = $_POST['id'];
	$country   = $_POST['country'];
	$lift      = $_POST['lift'];
	$zayavka   = $_POST['zayavka'];
	$dostavka  = $_POST['dostavka'];
	$index     = $_POST['index'];
	$obj       = $_POST['obj'];
	$check     = $_POST['check'];
	$price_pr =  get_field('price_for_probnik','option');
	$order =  wc_create_order();

//Записываем в массив данные о доставке заказа и данные клиента
	$address = array(
		'first_name' => $name,
		'last_name'  => $lastName,
		'company'    => '',
		'email'      => $email,
		'phone'      => $phone,
		'address_1'  => $adress,
		'address_2'  => '', 
		'city'       => $country,
		'state'      => '',
		'postcode'   => '',
		'country'    =>  '',
	); 
	update_post_meta($order->id,'_billing_number_kv',$home);
	update_post_meta($order->id,'_billing_number',$home2);
	update_post_meta($order->id,'_billing_red',$lift);
	update_post_meta($order->id,'_billing__',$zayavka);
	update_post_meta($order->id,'_billing_vareible_shipping',$dostavka);
	update_post_meta($order->id,'_billing_indeks',$index);

	$args = array(
		'total'        => $price_pr,

	);
	$args = wp_parse_args( $args, $default_args );
	foreach ($obj as $key => $value) {
		$order -> add_product( get_product($key),$value);
	}
	if (!email_exists($email) ):
		//echo "Этот e-mail зарегистрирован на пользователя с ID: " . email_exists($email);
		$userdata = array(
	'user_login'      => $email, // обязательно
	'user_email'      => $email,
	'first_name'      => $name,
	'last_name'       => $lastName,
	'rich_editing'    => 'true', // false - выключить визуальный редактор
	'role'            => 'customer', // (строка) роль пользователя

);

		wp_insert_user( $userdata );
	    $user = get_user_by('email', $email);
	    $user_id = $user->ID;
		wp_new_user_notification( $user_id, 'both' );
	endif;
	$ship_rate_ob = new WC_Shipping_Rate();
	$ship_rate_ob->id=0;
	$ship_rate_ob->label='משלוח';
    $ship_rate_ob->taxes=array(); //not required in your situation
    $ship_rate_ob->cost=$price_pr; //not required in your situation
    $order->add_shipping($ship_rate_ob); 
    $order -> set_address( $address, 'billing' ); 
    $order -> set_address( $address, 'shipping' ); 
    $order->set_payment_method('check');
    $payment_gateway = wc_get_payment_gateway_by_order($order);
    $order->shipping_method_title = $shipping_method;
    $order -> calculate_totals(); 
    $order->set_total($price_pr);
    $order -> save();
    $order = new WC_Order($order->id);
    $orderID = $order->id;
    $order_key = $order->order_key;

    $url =  "https://tile.co.il/checkout/order-pay/".$orderID."/?pay_for_order=true&key=".$order_key." ";

    echo $url;

	die(); // даём понять, что обработчик закончил выполнение
}

add_action( 'wp_ajax_form2', 'save_function' ); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action( 'wp_ajax_nopriv_form2', 'save_function' );  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей

function save_function(){
	global $woocommerce;
	$name     = $_POST['name'];
	$lastName = $_POST['lastName'];
	$phone    = $_POST['phone'];
	$email    = $_POST['email'];
	$adress   = $_POST['adress'];
	$home     = $_POST['home'];
	$home2    = $_POST['home2'];
	$country   = $_POST['country'];
	$lift      = $_POST['lift'];
	$zayavka   = $_POST['zayavka'];
	$dostavka  = $_POST['dostavka'];
	$index     = $_POST['index'];
	$obj       = $_POST['obj'];
	$check     = $_POST['check'];
	$order =  wc_create_order();

//Записываем в массив данные о доставке заказа и данные клиента
	$address = array(
		'first_name' => $name,
		'last_name'  => $lastName,
		'company'    => '',
		'email'      => $email,
		'phone'      => $phone,
		'address_1'  => $adress,
		'address_2'  => '', 
		'city'       => $country,
		'state'      => '',
		'postcode'   => '',
		'country'    =>  '',
	); 
	update_post_meta($order->id,'_billing_number_kv',$home);
	update_post_meta($order->id,'_billing_number',$home2);
	update_post_meta($order->id,'_billing_red',$lift);
	update_post_meta($order->id,'_billing__',$zayavka);
	update_post_meta($order->id,'_billing_vareible_shipping',$dostavka);
	update_post_meta($order->id,'_billing_indeks',$index);

	$args = wp_parse_args( $args, $default_args );


	foreach ($obj as $key => $value) {
		$order -> add_product( get_product($key),$value);
	}
   //register_new_user($name,$email);
	$ship_rate_ob = new WC_Shipping_Rate();
	$ship_rate_ob->id=0;
	$ship_rate_ob->label='משלוח';
    $ship_rate_ob->taxes=array(); //not required in your situation
   // $ship_rate_ob->cost=300; //not required in your situation
    $order->add_shipping($ship_rate_ob); 
    $order -> set_address( $address, 'billing' ); 
    $order -> set_address( $address, 'shipping' ); 
    $order->set_payment_method('check');
    $payment_gateway = wc_get_payment_gateway_by_order($order);
    $order->shipping_method_title = $shipping_method;
    $order -> calculate_totals(); 
    $order -> save();
    $order = new WC_Order($order->id);
    $orderID = $order->id;
    $order_key = $order->order_key;
    global $woocommerce;
    $woocommerce->cart->empty_cart();

    die(); // даём понять, что обработчик закончил выполнение
}


add_action( 'woocommerce_cart_totals_before_shipping', 'bbloomer_display_coupon_form_below_proceed_checkout', 25 );

function bbloomer_display_coupon_form_below_proceed_checkout() {
	?> 
	<form class="woocommerce-coupon-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php if ( wc_coupons_enabled() ) { ?>
		<div class="coupon under-proceed">
			<label>קופון הנחה:</label>
			<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( '', 'woocommerce' ); ?>" /> 
			<button type="submit" class="cupon_button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'הכנס', 'woocommerce' ); ?></button>

		</div>
		<?php } ?>
	</form>
	<?php
}


add_filter( 'woocommerce_return_to_shop_redirect', 'empty_cart' );
function empty_cart( $wc_get_page_permalink ){
	 $wc_get_page_permalink = "https://tile.co.il/allproducts/";
	return $wc_get_page_permalink;
}


?>
