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
global $thumbsize;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$_id = nemi_fnc_makeid();
if($categories=='') return;
$_count = 0;

$ocategory = get_term_by( 'id', $categories, 'product_cat' );
if ( !empty($ocategory) && !is_wp_error($ocategory) ):
	$title = !empty($title)? $title : $ocategory->name;

$loop = nemi_fnc_woocommerce_query( '', $per_page , array($ocategory->slug) );


switch ($columns) {
	case '6': 
		$class_column = 'col-lg-2 col-md-4 col-sm-6 col-xs-6';
		break;
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
<div class="widget <?php echo esc_attr($el_class); ?> widget-products widget-productcats row">
	<div class="col-md-3 col-xs-12">
		<div class="widget-heading clearfix">
			<h3 class="widget-title">
		       <a href="<?php echo get_term_link( $ocategory, 'product_cat' );?>"><?php echo trim($title); ?></a>
			</h3>
			<div class="description">
				<?php echo trim($content);?>
			</div>	
		</div>	
	</div>
	<div class="col-md-9 col-xs-12">
	<?php if ( $loop->have_posts() ) : ?>
		<div class="widget-content">
			<div class="<?php echo esc_attr( $layout ); ?>-wrapper">
				<?php wc_get_template( 'widget-products/'.$layout.'.php' , array( 'loop'=>$loop,'columns_count'=>$columns,'class_column'=>$class_column,'posts_per_page'=>$per_page) ); ?>
			</div>
		</div>
	<?php endif; ?>
	</div>
</div>
<?php endif;