<?php global $woocommerce_loop; 
	$woocommerce_loop['columns'] = $columns_count ;
	
?>
<?php $_count = 1;$_delay = 150; $_total = $loop->post_count; ?>
<div class="<?php if($columns_count<=1){ ?>w-products-list<?php }else{ ?>products <?php } ?>">
	<div class="row products-grid">
		<?php $i =0; while ( $loop->have_posts() ) : $loop->the_post();
			$classes = array();
			$classes[] = $class_column;
			if( $i++%$columns_count==0 ){
				$classes[] = 'last-child';
			}
		 ?>
			<div <?php post_class( $classes ); ?>>
			 	<?php wc_get_template_part( 'content', 'product-inner' ); ?>
			</div>
		<?php endwhile; ?>
	</div>
</div>

<?php wp_reset_postdata(); ?>