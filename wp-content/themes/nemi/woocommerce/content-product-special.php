<?php
    global $product; 
    $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
?>
<div class="product-block">
    <div class="time-coundown">
        <?php if (   $time_sale ) {  ?>
        <div class="pts-countdown clearfix" data-countdown="countdown"
             data-date="<?php echo date('m',$time_sale).'-'.date('d',$time_sale).'-'.date('Y',$time_sale).'-'. date('H',$time_sale) . '-' . date('i',$time_sale) . '-' .  date('s',$time_sale) ; ?>">
        </div>
        <?php } ?> 
    </div> 
    <figure class="image">

            <span class="onsale">
                <?php
                $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
                    echo '-' . trim( $percentage ) . '%';
                 ?>
            </span>
        <?php echo trim( $product->get_image('image-widgets') ); ?>
    </figure>

    <div class="caption">
        
        <div class="meta">
            <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php
                /**
                * woocommerce_after_shop_loop_item_title hook
                *
                * @hooked woocommerce_template_loop_rating - 5
                * @hooked woocommerce_template_loop_price - 10
                */
                do_action( 'woocommerce_after_shop_loop_item_title');
            ?>            
        </div>
    </div>
</div>