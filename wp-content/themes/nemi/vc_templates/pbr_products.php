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

switch ($columns_count) {

	case '6': 
		$class_column = 'col-lg-2 col-md-4 col-sm-6 col-xs-6';
		break;

	case '4':
		$class_column= 'col-md-3 col-sm-6';
		break;

	case '3':
		$class_column= 'col-md-4 col-sm-4';
		break;

	case '2':
		$class_column= 'col-md-6 col-sm-6';
		break;
		
	default:
		$class_column= 'col-md-5 col-sm-6 col-xs-12';
		break;
}

if($type=='') return;


global $woocommerce;

$_id = nemi_fnc_makeid();
$_count = 1;

if(  strtolower($term_id) == 'none' ){
	 $term_id = null;
}

$loop = nemi_fnc_woocommerce_query( $type, $number, $term_id );


if( $image_bg && !empty( $image_bg )) {
    $image = wp_get_attachment_image_src( $image_bg, 'full' );
}

echo "<div class='widget widget-".esc_attr($style) . " widget-products".((!empty($el_class))?" ".$el_class:'')."'>";

if($title!=''){ ?>
<div class="widget-text-heading ">
	<h3 class="widget-title" style="<?php echo isset($image) && $image ? "background-image:url('".esc_url_raw( $image[0] )."')" : ''; ?>">
      <span class="visual-title"><?php echo esc_attr( $title ); ?></span>
	</h3>
	<?php if( isset($subtitle) && $subtitle ){ ?><span class="subtitle"><?php echo esc_html($subtitle); ?></span> <?php } ?>
</div>
	
<?php }

if ( $loop->have_posts() ) : ?>
	<div class="widget-content">
		<div class="<?php echo esc_attr( $style ); ?>-wrapper">
			<?php wc_get_template( 'widget-products/'.$style.'.php' , array( 'loop'=>$loop,'columns_count'=>$columns_count,'class_column'=>$class_column,'posts_per_page'=>$number ) ); ?>
		</div>
	</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php echo "</div>" ?>
