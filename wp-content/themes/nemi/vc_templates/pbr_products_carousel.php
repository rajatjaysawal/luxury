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

$query = new WP_Query( array(
		'post_type'			=> 'product',
		'posts_per_page'	=> $number,
		'post_status'		=> 'publish'
	) );

echo "<div class='widget widget-" . esc_attr( $style ) . " widget-products".( ! empty( $el_class ) ? ' ' . $el_class : '' ) . "'>";

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
			<div class="pbr-products-carousel-wrapper <?php echo esc_attr( $style ); ?>">
				<div class="pbr-products-carousel owl-carousel-play">
					<div class="owl-carousel" data-slide="<?php echo esc_attr( $columns ) ?>" data-pagination="<?php echo esc_attr( $pagination ) ?>" data-navigation="<?php echo esc_attr( $navigation ) ?>">
						<?php while( $query->have_posts() ) : $query->the_post(); ?>
							<?php wc_get_template_part( 'content-product', 'over' ); ?>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	<?php wp_reset_postdata(); endif; ?>

<?php echo "</div>"; ?>
