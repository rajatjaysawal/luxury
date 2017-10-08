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

if(is_front_page()){
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
else{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$offset = ($per_page * $paged) - $per_page;
$args = array(
	'taxonomy' => 'product_cat',
	'orderby' => $orderby,
	'order' => $order,
	'number' => $per_page,
	'offset' => $offset
);

$categories = get_categories( $args );

if ( !empty( $categories ) ): ?>

	<div class="widget widget-ourcategories <?php echo (($el_class!='')?' '.esc_attr( $el_class ):''); ?>">
		<?php if(!empty($title)){ ?>
			<h4 class="widget-title">
				<span><?php echo trim($title); ?></span>
			</h4>
		<?php } ?>

		<div class="widget-content">
		<?php if ( $layout == 'special' ): ?>
			<div class="row">
			<?php $i = 0; foreach ($categories as $term): ?>
				<?php if ( $i == 0 || $i == 3 ): ?>
					<div class="col-md-3 col-sm-3">
				<?php endif; ?>
				<?php if ( $i == 2 ): ?>
					<div class="col-md-6 col-sm-6">
				<?php endif; ?>
					<div class="category-image">
							<?php
						        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
						        $image = wp_get_attachment_image_src( $thumbnail_id, 'postthumb-grid');
						    ?>
						    <?php if( !empty($image) && isset($image[0]) ) { ?>
		                        <img src="<?php echo esc_url_raw( $image[0] ); ?>" title="<?php echo esc_attr($term->name); ?>" style="max-width: 100%" alt="">
		                        <div class="ourcategories-link"><a class="btn btn-inverse-light btn-warning " href="<?php echo esc_url( get_term_link($term->slug, 'product_cat') ); ?>"><?php echo trim( $term->name ); ?></a></div>
		                    <?php } ?>
					</div>
				<?php if ( $i == 1 || $i == 2 || $i == 4 || $i == (count($categories) - 1) ): ?>
					</div>
				<?php endif; ?>

			<?php $i++; endforeach; ?>
			</div>
			<?php if ( isset($all_categories_page) && !empty($all_categories_page) ): ?>
				<div class="text-center clearfix text-more">
					<a class="btn btn-inverse-light btn-default" href="<?php echo esc_url( get_permalink( get_page_by_path( $all_categories_page ) ) ); ?>" title="<?php esc_html_e('All Categories', 'nemi'); ?>">
						<?php esc_html_e('All Categories', 'nemi'); ?>
					</a>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="row">
				<?php $i = 0; foreach ($categories as $term): ?>

					<div class="col-md-<?php echo esc_attr( round(12/$columns) ); ?>">
						<div class="category-image">
							
								<?php
							        $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
							        $image = wp_get_attachment_image_src( $thumbnail_id, 'postthumb-grid');
							    ?>
							    <?php if( !empty($image) && isset($image[0]) ) { ?>
			                        <img class="hidden-sm" src="<?php echo esc_url_raw( $image[0] ); ?>" title="<?php echo esc_attr($term->name); ?>" style="max-width: 100%" alt="">
			                        
			                    <?php } ?>
			                    <?php echo trim( $term->name ); ?>
						</div>
					</div>

				<?php $i++; endforeach; ?>
			</div>
			<?php if ( isset($all_categories_page) && !empty($all_categories_page) ): ?>
				<div class="text-center clearfix text-more">
					<a href="<?php echo esc_url( get_permalink( get_page_by_path( $all_categories_page ) ) ); ?>" title="<?php esc_html_e('All Categories', 'nemi'); ?>">
						<?php esc_html_e('All Categories', 'nemi'); ?>
					</a>
				</div>
			<?php endif; ?>

			<?php if ( isset($show_pagination) && !empty($show_pagination) ): ?>
				<?php 
					$args = array(
						'taxonomy' => 'product_cat',
						'orderby' => $orderby,
						'order' => $order
					);
					$all_categories = get_categories( $args );
					$found_posts = !empty($all_categories) ? count($all_categories) : 0;
					$max_num_pages = ceil($found_posts/$per_page);
				?>
				<div class="w-pagination">
				<?php nemi_fnc_pagination_custom_nav( $per_page, $found_posts, $max_num_pages, $paged );?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		</div>
	</div>
<?php endif; ?>