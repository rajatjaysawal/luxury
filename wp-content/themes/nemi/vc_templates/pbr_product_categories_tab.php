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

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$_id = nemi_fnc_makeid();
$_count = 0;


$_title = !empty($title)? $title : nemi_fnc_woocommerce_product_type_title($product_type);
$cats = explode(',', $categories);
switch ($columns) {
	case '4':
		$class_column='col-md-3 col-sm-6';
		break;
	case '3':
		$class_column='col-md-4 col-sm-6';
		break;
	case '2':
		$class_column='col-md-6 col-sm-6';
		break;
	default:
		$class_column='col-md-12 col-sm-12';
		break;
}

?>
<div id="product-category-tab" class="product-category-tab">
	<div class="widget-heading clearfix">
		<h3 class="widget-title"><?php echo trim($_title); ?></h3>

	  	<ul class="nav nav-tabs" role="tablist">
	  		<li role="presentation" class="active">
	  			<a href="#all-product-<?php echo trim($_id);?>" aria-controls="all-product-<?php echo trim($_id);?>" role="tab" data-toggle="tab">
	  				<?php esc_html_e('All', 'nemi'); ?>
	  			</a>
			</li>
			<?php foreach($cats as $category_id): ?>
				<?php $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' ); ?>
				<?php if ( !empty($term) && !is_wp_error($term) ): ?>
					<li role="presentation">
						<a href="#<?php echo esc_attr($term['slug']);?>-<?php echo trim($_id);?>" aria-controls="<?php echo esc_attr($term['slug']);?>-<?php echo trim($_id);?>" role="tab" data-toggle="tab">
							<?php echo trim($term['name']); ?>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>	
	<div class="widget <?php echo esc_attr($el_class); ?> widget-products tab-content row">
		<div role="tabpanel" class="tab-pane active" id="all-product-<?php echo trim($_id);?>">
			<?php $loop = nemi_fnc_woocommerce_query( $product_type, $per_page);?>
			<?php if ( $loop->have_posts() ) : ?>
					<div class="widget-content">
						<div class="grid-wrapper">
							<?php wc_get_template( 'widget-products/grid.php' , array( 'loop'=>$loop,'columns_count'=>$columns,'class_column'=>$class_column,'posts_per_page'=>$per_page ) ); ?>
						</div>
					</div>
			<?php endif; ?>
		</div>
		<?php foreach($cats as $category_id): ?>
			<?php $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' ); ?>
			<?php if ( !empty($term) && !is_wp_error($term) ): ?>
				<div role="tabpanel" class="tab-pane" id="<?php echo esc_attr($term['slug']);?>-<?php echo trim($_id);?>">
					<?php $loop = nemi_fnc_woocommerce_query( $product_type, $per_page, array($category_id)); ?>
					<?php if ( $loop->have_posts() ) : ?>
							<div class="widget-content">
								<div class="grid-wrapper">
									<?php wc_get_template( 'widget-products/grid.php' , array( 'loop'=>$loop,'columns_count'=>$columns,'class_column'=>$class_column,'posts_per_page'=>$per_page ) ); ?>
								</div>
							</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>