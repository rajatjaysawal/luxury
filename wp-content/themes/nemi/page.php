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

global $nemi_page_layouts; 
$nemi_page_layouts = apply_filters( 'nemi_fnc_get_page_sidebar_configs', null );

get_header( apply_filters( 'nemi_fnc_get_header_layout', null ) );
?>

<?php do_action( 'nemi_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('nemi_template_main_container_class','container');?> inner">
	<div class="row">
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($nemi_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							// Include the page content template.
							get_template_part( 'content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						endwhile;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
			
		</div><!-- #main-content -->

		<?php if( isset($nemi_page_layouts['sidebars']) && !empty($nemi_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		
	</div>	
</section>
<?php get_footer();