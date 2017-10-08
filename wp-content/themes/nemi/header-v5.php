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
	<header id="pbr-masthead" class="pbr-header-v5 header-default">
	
		<!-- menu-logo-search-cart -->
		<div class="container">
			<div class="header-top">
				<?php if( is_user_logged_in() ){ ?>

	                <?php $current_user = wp_get_current_user(); ?>

	                <div class="tp_user-login">
	                    <span class="dropdown-toggle" data-toggle="dropdown" title="<?php esc_html_e( 'Welcome', 'nemi' ); ?> <?php echo esc_html( $current_user->display_name); ?> !">
	                        <?php esc_html_e( 'Welcome to', 'nemi' ); ?> <span class="name"><?php echo esc_html( $current_user->display_name); ?> !</span>
	                    </span>
	                    <div class="dropdown-menu">
	                        <?php
	                            $args = array(
	                                'theme_location'  => 'tpaccount',
	                                'menu_class'      => 'tp_account',
	                                'fallback_cb'     => '',
	                                'menu_id'         => ''
	                            );
	                            wp_nav_menu($args);
	                        ?>                     
	                    </div>
	                </div>
	            <?php } else { ?>
	                <div class="tp_user-login">
	                    <span class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" title="login">
	                        <i class="icon-user icons"></i>
	                        <span><?php esc_html_e( 'My Acount', 'nemi' ); ?></span>
	                    </span>
	                    <div class="dropdown-menu">
	                        <ul>
	                            <?php do_action('opal-account-buttons'); ?>
	                        </ul>
	                    </div>
	                </div>
	            <?php } ?>

	            <div class="pbr-mainmenu hidden-sm hidden-xs text-center">	
					<div class="navbar-mega-simple clearfix">
						<div class="nav_megamenu">
							<?php get_template_part( 'page-templates/parts/nav' ); ?>
						</div>
					</div>	
				</div>

				<div id="search-container" class="search">
					<?php get_search_form(); ?>							
				</div>	
			</div>
			<div class="header_main">	
				<div class="verticalmenu">
			        <button data-toggle="offcanvas" class="btn-offcanvas btn-toggle-canvas offcanvas" type="button">
			           <i class="icon-bars"></i>
			        </button>
			    </div> 

				<?php get_template_part( 'page-templates/parts/logo' ); ?>

				<div class="d_flex d_flex_end">
					<?php do_action( "nemi_template_header_right" ); ?>
				</div>
			</div>	
		</div>
		<!-- menu-logo-search-cart-end -->

	</header><!-- #masthead -->

	<?php do_action( 'nemi_template_header_after' ); ?>
	
	<div id="main" class="site-main">
