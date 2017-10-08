<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsell_ids();

if ( sizeof( $upsells ) == 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => nemi_fnc_theme_options('woo-number-product-single', 6),
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->get_id() ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = nemi_fnc_theme_options('product-number-columns', 3);

if ( $products->have_posts() ) : ?>

	<div class="upsells widget">

		<h3 class="widget-title">
			<span><?php esc_html_e( 'You may also like&hellip;', 'nemi' ) ?></span>
		</h3>
		<div class="widget-content products">
	 		<?php wc_get_template( 'widget-products/carousel.php',array( 'loop'=>$products,'columns_count'=> $woocommerce_loop['columns'], 'class_column'=>'', 'posts_per_page'=> nemi_fnc_theme_options('woo-number-product-single', 6) ) ); ?>
		</div>

	</div>
<?php endif;

wp_reset_postdata();
