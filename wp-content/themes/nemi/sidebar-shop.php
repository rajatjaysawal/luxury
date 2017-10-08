<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */

$nemi_page_layouts = apply_filters( 'nemi_fnc_get_woocommerce_sidebar_configs', null );

if( isset($nemi_page_layouts['sidebars']) ): $sidebars = $nemi_page_layouts['sidebars']; 
?> 
	<?php if ( $sidebars['left']['show'] ) : ?>
	<div class="<?php echo esc_attr($sidebars['left']['class']) ;?> pull-left">
	  <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	   	<?php dynamic_sidebar( $sidebars['left']['sidebar'] ); ?>
	  </aside>
	</div>
	<?php endif; ?>
 	
 	<?php if ( $sidebars['right']['show'] ) : ?>
	<div class="<?php echo esc_attr($sidebars['right']['class']) ;?> pull-right">
	  <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	   	<?php dynamic_sidebar( $sidebars['right']['sidebar'] ); ?>
	  </aside>
	</div>
	<?php endif; ?>
<?php endif; ?> 