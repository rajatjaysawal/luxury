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
<?php //get_template_part( 'page-templates/parts/preloader' ); ?>	
<div id="page" class="hfeed site">
<div class="pbr-page-inner row-offcanvas row-offcanvas-left">
	<header id="pbr-masthead" class="pbr-header-v1 header-v3">
	
		<!-- menu-logo-search-cart -->
		<div class="container">
			<div class="header_main">	
				<div class="d_grid d_grid_11-1">
					<div class="hd_logo_megamenu">							

			 			<?php get_template_part( 'page-templates/parts/logo' ); ?>

			 			<div class="pbr-mainmenu hidden-sm hidden-xs text-left">	
							<div class="navbar-mega-simple clearfix">
								<div class="nav_megamenu">
									<?php get_template_part( 'page-templates/parts/nav' ); ?>
								</div>
							</div>	
						</div>	

					</div>

					<div class="hd_cart_search d_flex d_flex_end">
						<?php do_action( "nemi_template_header_right" ); ?>

						<div id="search-container" class="tp_search search_modal">
							<a href="" class="tp_btn_search" data-toggle="modal" data-target="#myModal">
								<span class="icon-search icons"></span>
							</a>

							<div id="myModal" class="modal fade" role="dialog">
								<div class="modal-content">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<?php get_search_form(); ?>
								</div>
							</div>							
						</div>						

						<div class="verticalmenu">
					        <button data-toggle="offcanvas" class="btn-offcanvas btn-toggle-canvas offcanvas" type="button">
					           <i class="icon-bars"></i>
					        </button>
					    </div> 
					</div>
				</div>
			</div>	
		</div>
		<!-- menu-logo-search-cart-end -->

	</header><!-- #masthead -->

	<?php do_action( 'nemi_template_header_after' ); ?>
	
	<div id="main" class="site-main">
