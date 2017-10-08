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
    add_action( 'woocommerce_before_shop_loop_item_title', 'nemi_fnc_woocommerce_before_shop_loop_item_title');
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    global $woocommerce_loop;

    $woocommerce_loop['columns'] = $columns_count ;

    $loop = nemi_fnc_woocommerce_query($type, $number);

    $layout= 'product';
    if( $loop->have_posts()  ) { ?>
        <div class="woocommerce woo-onsale"> 


    <div id="pbr-filter" class="clearfix products-top-wrap">
        <?php
            nemi_fnc_woocommerce_display_modes();
        ?>
        <?php
            /**
             * woocommerce_before_shop_loop hook
             *
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
             //woocommerce_show_messages();
          woocommerce_catalog_ordering();
          $display_mode = isset($_GET['display']) && $_GET['display'] == 'list' ? 'list' : 'grid';
        ?>
    </div>
        <div class="products-<?php echo esc_attr($display_mode); ?> products ">
            <?php while ( $loop->have_posts() ) :   $loop->the_post();
                $product = wc_get_product();
                $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
            ?>
            <?php
                wc_get_template_part( 'content', 'product' );
            ?>
            <?php
                endwhile; 
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="widget clearfix product-bottom">
        	<?php nemi_fnc_pagination_nav( $number, $loop->found_posts, $loop->max_num_pages); ?>
        </div>
        <?php wp_reset_postdata(); ?>

    </div>
 
 <?php }else{
 	wc_get_template( 'loop/no-products-found.php' );
 }