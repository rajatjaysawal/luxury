<?php global $woocommerce; ?>
<div class="pbr-topcart">
   <div id="cart" class="dropdown version-1">
     	<a class="dropdown-toggle mini-cart" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_html_e('View your shopping cart', 'nemi'); ?>">
         <span class="text-skin cart-icon">
          	<span class="icon-shopping icons"></span>
         </span>

         <?php echo sprintf(_n(' <span class="mini-cart-items"> %d  </span> ', ' <span class="mini-cart-items"> %d <em>item</em> </span> ', $woocommerce->cart->cart_contents_count, 'nemi'), $woocommerce->cart->cart_contents_count);?>
      </a>       
      <div class="dropdown-menu">
         <div class="widget_shopping_cart_content">
          	<div class="inner">
          		<?php woocommerce_mini_cart(); ?>
          	</div>
         </div>
     	</div>
   </div>
</div>    