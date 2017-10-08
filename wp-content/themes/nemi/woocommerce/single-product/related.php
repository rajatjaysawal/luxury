<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}
$per_page = nemi_fnc_theme_options('woo-number-product-single', 8);
$related = wc_get_related_products( $product->get_id() );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->get_id() )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = nemi_fnc_theme_options('product-number-columns', 4);

if ( $products->have_posts() ) : ?>

	<div class="related-products widget widget-carousel">

		<h3 class="widget-title"><span><?php esc_html_e( 'Related Products', 'nemi' ); ?></span></h3>

		<?php wc_get_template( 'widget-products/carousel.php' , array( 'loop' => $products,'columns_count' => $woocommerce_loop['columns'], 'posts_per_page' => $products->post_count ) ); ?>
	</div>

<?php endif;

wp_reset_postdata();
