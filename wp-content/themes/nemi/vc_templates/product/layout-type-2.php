<?php
$_id = nemi_fnc_makeid();
$bcolumn = 12/$columns_count;


?>

<div class="category_content">
	<div class="widget-title clearfix">
		
		<a class="title pull-left" href="<?php echo esc_attr( get_category_link( $ocategory->term_id ) );?>" title="<?php echo esc_attr($ocategory->name); ?>">
			<span class="title-category" <?php if ($titlecolor != '') { echo 'style="color:'.$titlecolor.'" ';} else { echo ''; }?>> <?php echo esc_attr($ocategory->name); ?></span>
		</a>
		<?php
		$args = array(
		   'hierarchical' => 1,
		   'show_option_none' => '',
		   'hide_empty' => 0,
		   'parent' => $ocategory->term_id,
		   'taxonomy' => 'product_cat'
		);
		$subcats = get_categories($args);
		if ( $subcats ) { ?>
			<div class="sub-categories pull-right">
				<ul class="nav nav-pills">
				<?php
				$i = 0;
				foreach ( $subcats as $term ) {
				    $category_id = $term->term_id;
				    $category_name = $term->name;
				    $category_slug = $term->slug;

				    echo '<li'.($i == 0 ? ' class="active"' : '').'><a href="#tab_content_'.$term->term_id.'" data-toggle="pill">'.esc_html( $category_name ).'</a></li>';
				    $i++;
				}?>
				</ul>
			</div>
		<?php } ?>
	</div>
		
	<?php if( !empty($image_cat) ) { ?>
		<div class="category_img col-md-4 hidden-xs hidden-sm <?php echo esc_attr( $sidebar_position ); ?>">
			<?php $img = wp_get_attachment_image_src($image_cat,'full'); ?>
				<img src="<?php echo esc_url_raw($img[0]); ?>" title="<?php echo esc_attr($ocategory->name); ?>" alt="">
		</div>
	<?php } ?>
	<?php if ( $subcats ) { ?>
		<div class="tab-content col-md-<?php echo (!empty($image_cat) ? 8 : 12); ?> col-sm-12">
			<?php
			$i = 0;
			foreach ( $subcats as $term ) {
			?>
				<div id="tab_content_<?php echo esc_attr( $term->term_id ); ?>" class="tab-pane fade <?php echo ($i == 0 ? 'in active' : ''); ?>">
				<?php
					$_count = 0;
					$args = array( 'post_type' => 'product', 'posts_per_page' => $posts_per_page,'product_cat' => $term->slug, 'orderby' => $orderby, 'order' => $order );
						$loop = new WP_Query( $args );
							if ( $loop->have_posts() ) : ?>
							<div class="products">
								<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
								 	<?php if ($_count%$columns_count == 0): ?> 		
									<div class="products-layout row-products row">
								 	<?php endif; ?>

								 		<div class="product-wrapper col-sm-<?php echo esc_attr( $bcolumn ); ?>">
								 			<?php get_template_part( 'vc_templates/product/product-inner' ) ?>
								 		</div>

							 		<?php if ($_count%$columns_count == $columns_count - 1 || $_count == $loop->post_count - 1): ?>
								 	</div>
								 	<?php endif; ?>

								 <?php  $_count++ ; endwhile; ?>
							</div>
						<?php endif;
					$i++; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>