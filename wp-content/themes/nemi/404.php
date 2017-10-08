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
/*
*Template Name: 404 Page
*/

get_header( apply_filters( 'nemi_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'nemi_template_main_before' ); ?>

<section id="main-container" class="<?php echo apply_filters('nemi_template_main_container_class','container');?> inner clearfix notfound-page">
	<div class="row">
		<div id="main-content" class="main-content col-lg-12 text-center">
			<div id="primary" class="content-area">
				 <div id="content" class="site-content" role="main">
					<div class="title">
						<span>404</span>						
					</div>
					<div class="sub-title">
						<span><?php esc_html_e( 'Oops 404 Again! That Page Can&rsquo;t Be Found.', 'nemi' ); ?></span>
					</div>
					<div class="error-description">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'nemi' ); ?></p>
					</div><!-- .page-content -->
					
					<div class="search-notfound-page">
						<?php get_search_form(); ?>
					</div>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->

		 
		<?php get_sidebar(); ?>
	 
	</div>	
</section>
<?php

get_footer();

 