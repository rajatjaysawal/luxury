<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     ENGOTHEME Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com
 * @support  http://engotheme.com.
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $woocommerce;
$meta_query  = WC()->query->get_meta_query();
$tax_query   = WC()->query->get_tax_query();
$tax_query[] = array(
	'taxonomy' => 'product_visibility',
	'field'    => 'name',
	'terms'    => 'featured',
	'operator' => 'IN',
);

$query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => $number,
	'orderby'             => $orderby,
	'order'               => $order,
	'meta_query'          => $meta_query,
	'tax_query'           => $tax_query,
);

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() || $query->found_posts < 5 ) {
	return;
}

echo "<div class='widget widget-products".( ! empty( $el_class ) ? ' ' . $el_class : '' ) . "'>";

	if( $title != '' ) : ?>
		<div class="widget-text-heading">
			<h3 class="widget-title">
		      	<span class="visual-title"><?php echo esc_attr( $title ); ?></span>
			</h3>
			<?php if( isset($subtitle) && $subtitle ){ ?>
				<span class="subtitle"><?php echo esc_html($subtitle); ?></span>
			<?php } ?>
		</div>

	<?php endif; ?>

	<?php if ( $query->have_posts() ) : ?>
		<div class="widget-content">
			<div class="row">
				<?php $i = 0; while( $query->have_posts() ) : $query->the_post(); $i++; ?>

					<?php if ( $i == 1 || $i == 5 ) : ?>
						<div class="col-md-6 col-xs-12 col-sm-6">
						<?php if ( $i == 5 ) : ?>
							<div class="pbr-products-carousel owl-carousel-play">
								<div class="owl-carousel" data-slide="1" data-pagination="<?php echo esc_attr( $pagination ) ?>" data-navigation="<?php echo esc_attr( $navigation ) ?>">
						<?php elseif( $i == 1 ): ?>
									<div class="row">
						<?php endif; ?>
					<?php endif; ?>

						<?php if ( $i <= 4 ) : ?>
							<div class="col-sm-6 col-md-6 col-xs-12">
						<?php else: ?>
							<?php add_filter( 'nemi_woo_shop_loop_item_image_size', 'nemi_full_image_size' ); ?>
						<?php endif; ?>

							<?php wc_get_template_part( 'content-product', 'inner' ); ?>

						<?php if ( $i <= 4 ) : ?>
							</div>
						<?php else: ?>
							<?php remove_filter( 'nemi_woo_shop_loop_item_image_size', 'nemi_full_image_size' ); ?>
						<?php endif; ?>

					<?php if( $i == 4 || $i == $query->found_posts || $i === $number ): ?>

						<?php if ( $i == 4 ) : ?>
									</div>
						<?php elseif ( $i == $query->found_posts || $i === $number ) : ?>
								</div>
							</div>
						<?php endif; ?>
						</div>
					<?php endif; ?>

				<?php endwhile; ?>
			</div>
		</div>
	<?php wp_reset_postdata(); endif; ?>

<?php echo "</div>"; ?>
