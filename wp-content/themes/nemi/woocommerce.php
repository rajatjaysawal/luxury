<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */

$nemi_page_layouts = apply_filters( 'nemi_fnc_get_woocommerce_sidebar_configs', null );

get_header( apply_filters( 'nemi_fnc_get_header_layout', null ) ); ?>

	<section id="breadcrumb">
		<?php do_action( 'nemi_woo_template_main_before' ); ?>
	</section>

	<section id="main-container" class="<?php echo apply_filters('nemi_template_woocommerce_main_container_class','container');?>">

		<?php if(!is_product()): ?>
			<?php do_action('woocommerce_before_shop_loop'); ?>
		<?php endif; ?>
			<div class="row">

				<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($nemi_page_layouts['main']['class']); ?>">

					<div id="primary" class="content-area">
						<div id="content" class="site-content" role="main">
							<?php nemi_fnc_woocommerce_content(); ?>
						</div><!-- #content -->
					</div><!-- #primary -->

					<?php get_sidebar( 'content' ); ?>
				</div><!-- #main-content -->

				<?php if( isset($nemi_page_layouts['sidebars']) && !empty($nemi_page_layouts['sidebars']) ) : ?>
					<?php get_sidebar('shop'); ?>
				<?php endif; ?>

			</div>
	</section>

<?php
get_footer();