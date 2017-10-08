<?php 
			$scolumns = 12;
			if( !empty($image_cat) ) {
				$scolumns = $scolumns - 3;
			}
			if ($sidebar_product_list != 'none') {
				$scolumns = $scolumns - 3;
			}
		?>

		<?php
		if ($sidebar_product_list != 'none') :
		?>
			<div class="category_productlist col-md-3 col-sm-12 col-xs-12 <?php echo esc_attr( $sidebar_position ); ?>">
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
						$loop = nemi_fnc_woocommerce_query( $sidebar_product_list, 4 , $category );
			    		wc_get_template( 'widget-products/list.php' , array( 'loop' => $loop,'columns_count' => $columns ,'posts_per_page' => $per_page ) ); 
					?>
					</div>
				</div>
			</div>
		<?php
		endif;
		?>
		<?php if( !empty($image_cat) ) { ?>
			<div class="category_img col-md-3 <?php if ($sidebar_position == 'pull-left'){ echo 'pull-right';} elseif ($sidebar_position == 'pull-right'){ echo 'pull-left';}?> hidden-xs hidden-sm">
				<?php $img = wp_get_attachment_image_src($image_cat,'full'); ?>
					<img src="<?php echo esc_url_raw($img[0]); ?>" title="<?php echo esc_attr($ocategory->name); ?>" alt="">
			</div>
		<?php } ?>

		<div class="col-md-<?php echo esc_attr( $scolumns ); ?> col-sm-12 col-xs-12">
			<?php
			$args = array( 'post_type' => 'product', 'posts_per_page' => $per_page, 'product_cat' => $ocategory->slug, 'orderby' => $orderby, 'order' => $order );
			$loop = new WP_Query( $args );
			$bcolumn = 12/$columns;
			if ( $loop->have_posts() ) : ?>
				<div class="products">
					<?php $_count = 0; while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
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