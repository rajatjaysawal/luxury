<?php
/**
 * The Header for our theme: Top has Logo left + search right . Below is horizal main menu
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Engotheme Team
 * @subpackage Presta_Base
 * @since Nemi 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>	
<div id="page" class="hfeed site">
<div class="pbr-page-inner row-offcanvas row-offcanvas-left">
	<header id="pbr-masthead" class="pbr-header-center header-default">
	
		<!-- menu-logo-search-cart -->
		<div class="container">
			<div class="header_main">
				<div class="topbar">
					<?php get_template_part( 'page-templates/parts/topbar' ); ?>
				</div>	
				<div class="d_grid d_grid_11-1">
					<div class="header-main">							
						<div class="verticalmenu">
					        <button data-toggle="offcanvas" class="btn-offcanvas btn-toggle-canvas offcanvas showleft" type="button">
					           <i class="icon-bars"></i>
					        </button>
					    </div>

			 			<?php get_template_part( 'page-templates/parts/logo' ); ?>

			 			<div class="hd_cart_search d_flex d_flex_end">
							<?php do_action( "nemi_template_header_right" ); ?>
						</div>

					</div>
				</div>
			</div>	
		</div>
		<!-- menu-logo-search-cart-end -->

	</header><!-- #masthead -->

	<?php do_action( 'nemi_template_header_after' ); ?>
	
	<div id="main" class="site-main">
