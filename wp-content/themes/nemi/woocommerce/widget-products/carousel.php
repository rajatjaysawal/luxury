<?php

$_total = $loop->post_count;
$_count = 1;
$_id = nemi_fnc_makeid();

?>
    <div id="carousel-<?php echo esc_attr($_id); ?>" class="owl-carousel-play" data-ride="owlcarousel">
    	<?php if( $loop->post_count > $columns_count ) { ?>
			<div class="carousel-controls carousel-controls-v3">
				<a href="#productcarouse-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control carousel-md">
					<i class="fa fa-angle-left"></i>
				</a>
				<a href="#productcarouse-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control carousel-md">
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		<?php } ?>
         <div class="owl-carousel products product" data-slide="<?php echo esc_attr($columns_count); ?>" data-pagination="false" data-navigation="false" data-loop="true">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="products-grid">
                    <?php wc_get_template_part( 'content', 'product-inner' ); ?>
                </div>
            <?php endwhile; ?>
        </div>

    </div>

<?php wp_reset_postdata(); ?>