<?php

/**

 * Checkout Form

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see https://docs.woocommerce.com/document/template-structure/

 * @package WooCommerce/Templates

 * @version 3.5.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}
?>
<div class="wc-tl-top-line flex">
	<div class="checkout-step checkout-form flex">

		<div class="step active"><span class="num-step active">1</span>פרטי משלוח</div>
		<div class="step"><span class="num-step">2</span>תיאום ותשלום</div>
		<div class="step"><span class="num-step">3</span>סיום</div>

	</div>
</div>
<div class="cart-title flex"><h2>סל הקניות שלי</h2></div>



<?php
WC()->shipping->get_shipping_methods();
//print_r(get_shipping_method_class_names());
//do_action( 'woocommerce_before_checkout_form', $checkout );
?>

<?php
// If checkout registration is disabled and not logged in, the user cannot checkout.

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {

	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );

	return;

}

foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	//echo $id;
	$qut =  apply_filters( 'woocommerce_checkout_cart_item_quantity',  sprintf( '%s', $cart_item['quantity'] ), $cart_item, $cart_item_key ); 
	?>
	<input type="hidden" name="hidden_qut" value="<?php echo $qut;?>" />
	<input type="hidden" name="hidden" data-atr="<?php echo $id;?>" class="hidden span-product_id" value="<?php echo $qut;?>" />
	<?php

}
?>
	<input type="hidden" name="hidden-total" value="<?php echo round(WC()->cart->total);?>">



<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="flex checkout-flex">



		<?php if ( $checkout->get_checkout_fields() ) : ?>



			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>



			<div class="tl-wc-form-checkout" id="customer_details">

				<div class="">

					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					
				</div>


			</div>



			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>



		<?php endif; ?>

		<div class="tl-order-review">

			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			<p class="phone-for-questions"><i class="icon-phone"></i> שאלות? <a href="tel:<?php echo get_field('phone_cart','option');?>"><?php echo get_field('phone_cart','option');?></a></p>
			<div  class="tl-order">


				<h3 id="order_review_heading"><?php esc_html_e( 'פרטי ההזמנה:', 'woocommerce' ); ?></h3>



				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>



				<div id="order_review" class="woocommerce-checkout-review-order">

					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					<div class="cart-info-text checkout-info">
						*עד 4 דוגמאות חינם ללקוח בכפוף לתקנון, יתכנו עלויות שילוח עבור הדוגמאות
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	<?php
	

	$WC_Cart = new WC_Cart();
	//$total_sum = $WC_Cart->cart_contents_total;
	global $woocommerce;
	$total_sum = $woocommerce->cart->total;
	//echo 	round($total_sum);
	if(round($total_sum) == 0): ?>
	<input type="button" id="tl-button"  class="tl-btn button" value="המשך" /> 
<?php else: ?>
	<input type="button" id="tl-button-save"  class="tl-btn button" value="המשך" /> 
<?php endif;?> 
<div class="tl-popup-form">
	<div class="tl-pop-up">
		<img src="<?php echo get_template_directory_uri()?>/img/icon.png">
		<div class="tl-msg-pop-up">
			<p>	תודה על ההזמנה!</p>
			אחד מנציגינו יחזור אליכם
			עוד היום לתיאום האספקה
		</div>
		<div class="tl-msg-pop-up2">אחד מנציגינו יחזור אליכם עוד היום או במהלך יום העסקים הקרוב לתיאום האספקה</div>
		<input type="button" name="product-action" class="button" id="tl-form-register-product" value="המשך" />
		<div class="phone-for-questions pop-qv"><i class="icon-phone pop-up-i-ph"></i> שאלות? <a href="tel:<?php echo get_field('phone_cart','option');?>"><?php echo get_field('phone_cart','option');?></a></div>
	</div>
</div>
</form>



<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

