<?php global $product; ?>

<?php
	$class=$attrs='';
	if(isset($animate) && $animate){
		$class= 'wow fadeInUp';
		//$attrs = 'data-wow-duration="0.6s" data-wow-delay="'.$delay.'ms"';
	}
?>

<li class="product-block widget-product <?php echo esc_attr($class); ?>" <?php echo trim($attrs); ?>>
	<div class="media">
		<?php if((isset($item_order) && $item_order==1) || !isset($item_order)) : ?>
			<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>" class="image pull-left">
				<?php echo trim( $product->get_image() ); ?>
				<?php if(isset($item_order) && $item_order==1) { ?> 
					<span class="first-order"><?php echo trim($item_order); ?></span>
				<?php } ?>
			</a>
		<?php endif; ?>
		<?php if(isset($item_order) && $item_order > 1){ ?>
			<div class="order"><span><?php echo trim($item_order); ?></span></div>
		<?php }?>
		<div class="media-body meta">
			<h3 class="name">
				<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo trim( $product->get_title() ); ?></a>
			</h3>
			<?php
             /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
             do_action( 'woocommerce_after_shop_loop_item_title');

         ?>

         <div class="button-action">
            <div class="button-groups">
                <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                <?php
                    $action_add = 'yith-woocompare-add-product';
                    $url_args   = array(
                        'action' => $action_add,
                        'id'     => $product->get_id()
                    );
                ?>
                <?php if(nemi_fnc_theme_options('is-quickview', true)){ ?>
                    <div class="quick-view">
                        <a href="#" class="quickview" data-productslug="<?php echo trim($product->get_slug()); ?>" data-toggle="modal" data-target="#pbr-quickview-modal">
                           <i class="icon-magnifier icons"></i>
                           <span class="title"><?php esc_html_e('Quick view', 'nemi'); ?></span>
                        </a>
                    </div>
                <?php } ?>  

                <?php
                    if( class_exists( 'YITH_WCWL' ) ) {
                        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                    }
                ?>   
        
                <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
                    <?php
                        $action_add = 'yith-woocompare-add-product';
                        $url_args = array(
                            'action' => $action_add,
                            'id' => $product->get_id()
                        );
                    ?>
                    <div class="yith-compare">
                        <a href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" class="compare" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
                            <i class="icon-chart icons"></i>
                            <span class="title"><?php esc_html_e('Compare', 'nemi'); ?></span>
                        </a>
                    </div>
                <?php } ?>     
            </div>    

        </div>
        
		</div>
	</div>
</li>


