<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Themeocean Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.engotheme.com
 * @support  http://www.engotheme.com
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$_id = nemi_fnc_makeid();
if($category=='') return;

$ocategory = get_term_by( 'slug', $category, 'product_cat' );
 

?>
<?php if ( !empty($ocategory) && !is_wp_error($ocategory) ): ?>
<div class="widget <?php echo esc_attr($el_class); ?> widget-products-subcats">
	<div class="widget-heading clearfix">
		<h3 class="widget-title pull-left">	
			<span>
				<a class="title" href="<?php echo esc_url( get_category_link( $ocategory->term_id ) );?>" title="<?php echo esc_attr($ocategory->name); ?>">
					<?php if ($titlecolor != '') { echo 'style="color:'.$titlecolor.'" ';} else { echo ''; }?> <?php echo esc_attr($ocategory->name); ?>
				</a>
			</span>
		</h3>
		<?php
		$args = array(
		   'hierarchical' => 1,
		   'show_option_none' => '',
		   'hide_empty' => 0,
		   'parent' => $ocategory->term_id,
		   'taxonomy' => 'product_cat',
		   'number' => $number_subcat
		);
		$subcats = get_categories($args);
		if ( $subcats ) { ?>
			<ul class="sub-categories list-inline">
				<?php
				$i = 0;
				foreach ( $subcats as $term ) {
				    echo '<li><a href="'.esc_url( get_term_link($term, 'product_cat') ).'" title="'.esc_html( $term->name ).'">'.esc_html( $term->name ).'</a></li>';
				}?>
				</ul>
		<?php } ?>
	</div>
	<div class="content-product-subcats row clearfix">
		<?php 
			$scolumns = 12;
			if ($sidebar_product_list != 'none') {
				$scolumns = $scolumns - 3;
			}
		?>

		<?php
		if ($sidebar_product_list != 'none') :
		?>
			<div class="category_productlist col-md-3 hidden-sm hidden-xs <?php echo esc_attr( $sidebar_position ); ?>">
				<div class="widget-style">
					<h3 class="widget-title" <?php if ($titlecolor != '') { echo 'style="background-color:'.$titlecolor.'" ';} else { echo ''; }?> >
						<?php if ($sidebar_product_list == 'recent_product'): ?>
			    		<span><?php esc_html_e( 'New Arrivals', 'nemi'); ?></span>
			    		<?php else: ?>
			    		<span><?php esc_html_e( 'Special Products', 'nemi'); ?></span>
			    		<?php endif; ?>
			    	</h3>
			    	<div class="widget-content">
					<?php
						$loop = nemi_fnc_woocommerce_query( $sidebar_product_list, 4 , array($category) );
			    		wc_get_template( 'widget-products/list.php' , array( 'loop' => $loop,'columns_count' => $columns ,'posts_per_page' => $per_page ) ); 
					?>
					</div>
				</div>
			</div>
		<?php
		endif;
		?>
		<div class="col-md-<?php echo esc_attr( $scolumns ); ?> col-sm-12 col-xs-12">
		<?php if( !empty($image_cat) ) { ?>
			<div class="category_img <?php echo esc_attr( $image_position ); ?> hidden-xs hidden-sm">
				<?php $img = wp_get_attachment_image_src($image_cat,'full'); ?>
					<img src="<?php echo esc_url_raw($img[0]); ?>" title="<?php echo esc_attr($ocategory->name); ?>" alt="">
			</div>
		<?php } ?>

		
			<?php
			$args = array( 'post_type' => 'product', 'posts_per_page' => $per_page, 'product_cat' => $ocategory->slug, 'orderby' => $orderby, 'order' => $order );
			$loop = new WP_Query( $args );
			$bcolumn = 12/$columns;
			if ( $loop->have_posts() ) : ?>
				<div class="products">
					<?php $_count = 0; while ( $loop->have_posts() ) : $loop->the_post(); ?>
					 	<?php if ($_count%$columns == 0): ?> 		
						<div class="products-grid products-special">
					 	<?php endif; ?>
					 		<div class="product col-sm-<?php echo esc_attr( $bcolumn ); ?>">
					 			<?php get_template_part( 'vc_templates/product/product-inner' ) ?>
					 		</div>

				 		<?php if ($_count%$columns == $columns - 1 || $_count == $loop->post_count - 1): ?>
					 	</div>
					 	<?php endif; ?>

					<?php  $_count++ ; endwhile; ?>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>

	</div>
</div>
<?php endif; ?>