<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="wc-tl-top-line flex">
	<div class="checkout-step flex">

		<div class="step active"><span class="num-step active">1</span>פרטי משלוח</div>
		<div class="step"><span class="num-step">2</span>תיאום ותשלום</div>
		<div class="step"><span class="num-step">3</span>סיום</div>

	</div>
	<div class="cart-title"><h2>סל הקניות שלי</h2></div>
</div>
<div class="flex wc-wrap-cart flex-wrap">
	<div class="wc-form">
		<div class="qty-error" style="color:red">*עד 4 דוגמאות חינם ללקוח בכפוף לתקנון, יתכנו עלויות שילוח עבור הדוגמאות</div>
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
				<thead>
					<tr>

						<th class="product-thumbnail"><?php esc_html_e( 'מוצר', 'woocommerce' ); ?></th>
						<th class="product-name"><?php esc_html_e( 'תיאור', 'woocommerce' ); ?></th>
						<th class="product-quantity"><?php esc_html_e( 'כמות', 'woocommerce' ); ?></th>
						<th class="actions">&nbsp;</th>			
						<th class="product-subtotal"><?php esc_html_e( 'סה״כ', 'woocommerce' ); ?></th>
						<th class="product-remove">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>

							<!-- Основное тело таблицы -->

							<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

								<td class="product-thumbnail">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
			echo $thumbnail; // PHPCS: XSS ok.

		} else {
			printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
		}
		?>
		<input type="hidden" name="hidden-total" value="<?php echo round(WC()->cart->total);?>">
	</td>

	<td class="product-name wc-tl-product-info" data-title="<?php esc_attr_e( 'תיאור:', 'woocommerce' ); ?>">
		<?php


		$name= $_product->get_name();
		$format = str_replace('- כן','',$name);
		//echo $format;
		$format = str_replace('- לא','',$format);
		if ( ! $product_permalink ) {
			echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
		} else {
			echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $format), $cart_item, $cart_item_key ) );
		}

		do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

		// Meta data.
		echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

		// Backorder notification.
		if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
			echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
		}

		?>
		<div class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
			<?php
			echo  WC()->cart->get_product_price($_product) . ' למ״ר';
			?>

		</div>

	</td>




	<td class="product-quantity" data-title="<?php esc_attr_e( 'כמות:', 'woocommerce' ); ?>">

		<?php

		$WC_Cart = new WC_Cart();
	//$total_sum = $WC_Cart->cart_contents_total;
		global $woocommerce;
		$total_sum = $woocommerce->cart->total;
		$max_qt = 4;
		$product = wc_get_product($_product);
		$product_sum = $product->get_price();
		$cart_item['has_error'];
//print_r($_product);
		$min = get_post_meta($product_id,'_ywmmq_product_minimum_quantity',true);
		if(round($total_sum) == 0){
			$max_qt = 1;
			$min = 0;
		}
		else{
			$min = get_post_meta($product_id,'_ywmmq_product_minimum_quantity',true);
			$max_qt = $_product->get_max_purchase_quantity();
			
		}

		if ( $_product->is_sold_individually() ) {
			$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
		} else {
			$min_qt = $cart_item['quantity'];
           // echo $min_qt;
          // print_r($_product->has_enough_stock());
			$product_quantity = woocommerce_quantity_input( array(
				'input_name'   => "cart[{$cart_item_key}][qty]",
				'input_value'  => $cart_item['quantity'],
				'max_value'    => $max_qt,
				'min_value'    => $min,
				'product_name' => $_product->get_name(),
			), $_product, false );
		}

		echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
		?>
	</td>

	<td  class="actions">

		<?php if ( wc_coupons_enabled() ) { ?>
		<div class="coupon">
			<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
			<?php do_action( 'woocommerce_cart_coupon' ); ?>
		</div>
		<?php } ?>

		<button type="submit" class="button update_cart" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'עדכן', 'woocommerce' ); ?>			
		</button>

		<?php do_action( 'woocommerce_cart_actions' ); ?>

		<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
	</td>

	<td class="product-subtotal" data-title="<?php esc_attr_e( 'סה״כ:', 'woocommerce' ); ?>">
		<?php
		$product = wc_get_product($_product);
		$product_sum = $product->get_price();
		$sum = WC()->cart->get_product_price($_product);
		if(round($product_sum) > 0):
			echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
		else:
			echo "<div style='color:#e86d20'>". $sum ."</div>";
		endif;
		?>
	</td>

	<td class="product-remove">
		<?php
		// @codingStandardsIgnoreLine
		echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
			'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
			esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
			__( 'Remove this item', 'woocommerce' ),
			esc_attr( $product_id ),
			esc_attr( $_product->get_sku() )
		), $cart_item_key );
		?>
	</td>
</tr>
<?php
}
}
?>

<?php //do_action( 'woocommerce_cart_contents' ); ?>

<?php do_action( 'woocommerce_after_cart_contents' ); ?>
</tbody>
</table>
<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
</div>

<div class="cart-collaterals">
	<p class="phone-for-questions"><i class="icon-phone"></i> שאלות? <a href="tel:<?php echo get_field('phone_cart','option');?>"><?php echo get_field('phone_cart','option');?></a></p>
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
</div>
<?php 

$terms = [];
$i = 0;
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	$defaults = array(
		'posts_per_page' => -1,
		'columns'        => 2,
		'orderby'        => 'rand', // @codingStandardsIgnoreLine.
		'order'          => 'desc',
	);

	$args = wp_parse_args( $args, $defaults );

	// Get visible related products then sort them at random.
	$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product_id, $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

	// Handle orderby.
	$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

	// Set global loop values.
	wc_set_loop_prop( 'name', 'related' );
	wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );

	
	
}
?>
<!-- <div class="slider-related"> -->
	<?php 
	//wc_get_template( 'single-product/related-slider.php', $args );
	?>
	<!-- </div> -->

	<?php do_action( 'woocommerce_after_cart' ); ?>
