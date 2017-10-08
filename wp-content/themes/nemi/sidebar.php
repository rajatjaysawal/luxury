<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */
global $nemi_page_layouts; 
$nemi_page_layouts = apply_filters( 'nemi_fnc_sidebars_others_configs', null );

if( isset($nemi_page_layouts['sidebars']) ): $sidebars = $nemi_page_layouts['sidebars']; 
?> 
	<?php if ( $sidebars['left']['show'] ) : ?>
	<div class="<?php echo esc_attr($sidebars['left']['class']) ;?>">
	  <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	   	<?php dynamic_sidebar( $sidebars['left']['sidebar'] ); ?>
	  </aside>
	</div>
	<?php endif; ?>
 	
 	<?php if ( $sidebars['right']['show'] ) : ?>
	<div class="<?php echo esc_attr($sidebars['right']['class']) ;?>">
	  <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	   	<?php dynamic_sidebar( $sidebars['right']['sidebar'] ); ?>
	  </aside>
	</div>
	<?php endif; ?>
<?php endif; ?> 

