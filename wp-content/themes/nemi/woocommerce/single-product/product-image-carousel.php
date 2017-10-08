<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Engotheme Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com
 * @support  http://engotheme.com.
 */

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();
$_images =array();
$_paginates = array();
if(has_post_thumbnail()){
	$_images[] = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
	$_paginates[] = get_the_post_thumbnail( $post->ID, array( 50, 50 ) );
}else{
	$_images[] = '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" />';
	$_paginates[] = '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" width="50" height="50" />';
}
foreach ($attachment_ids as $attachment_id) {
	$_images[] = wp_get_attachment_image( $attachment_id, 'shop_single' );
	$_paginates[] = wp_get_attachment_image( $attachment_id, array( 50, 50 ) );
}

?>
<div id="quickview-carousel" class="carousel slide" data-ride="carousel">
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<?php foreach ($_images as $key => $image) { ?>
			<div class="item<?php echo (($key==0)?' active':'') ?>">
				<?php echo trim($image); ?>
			</div>
		<?php } ?>
	</div>

	<?php if(count($_images)>1){ ?>
	<!-- Indicators -->
		<ol class="carousel-indicators">
			<?php foreach ($_paginates as $key => $image) {
				echo '<li data-target="#quickview-carousel" data-slide-to="'.$key.'" '.(($key==0)?'class="active"':'').'>';
				echo trim( $image );
				echo '</li>';
			} ?>
		</ol>
	<?php } ?>	

	<!-- Controls -->
	<a class="left carousel-control" href="#quickview-carousel" data-slide="prev">
		<span class="fa fa-angle-left"></span>
	</a>
	<a class="right carousel-control" href="#quickview-carousel" data-slide="next">
		<span class="fa fa-angle-right"></span>
	</a>
</div>
