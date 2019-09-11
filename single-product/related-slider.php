<?php

/**

 * Related Products

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see 	    https://docs.woocommerce.com/document/template-structure/

 * @package 	WooCommerce/Templates

 * @version     3.0.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



if ( $related_products ) : 

	?>
	<div class="wrap-tl-slider">
		<div class="title-related-slider">מוצרים נלווים</div>
		<div class="tl-slider">
			<?php foreach ( $related_products as $related_product ) : ?>



				<?php

				$post_object = get_post( $related_product->get_id() );



				setup_postdata( $GLOBALS['post'] =& $post_object );

				$product = wc_get_product( get_the_ID() );


					$mainimageurl=get_the_post_thumbnail_url( $product->get_id(),  'thumbnail' );//thumbnail, medium, large 

					?>

					<div class="slick-item-tl">

						<a href="<?php the_permalink();?>">

							<img src="<?php echo $mainimageurl;?>" alt="">
						</a>

						<div class="related-title">
							<a href="<?php the_permalink();?>">
								<?php
								the_title();
								?>
							</a>
						</div>
						<div class="related-price">
							<a href="<?php the_permalink();?>">
								<?php
								echo $product->get_price_html() ;
								?>
							</a>
						</div>
					</div>

					<?php



					//wc_get_template_part( 'content', 'product' ); ?>



				<?php endforeach; ?> 

			</div>
		</div>





	<?php endif;



	wp_reset_postdata();

