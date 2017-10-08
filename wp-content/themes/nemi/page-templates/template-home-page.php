<?php
/**
 * Template Name: Template Homepage
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */

get_header( apply_filters( 'nemi_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'nemi_template_main_before' ); ?>
<div id="main-content" class="main-content">

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
	<?php if( isset($nemi_page_layouts['sidebars']) && !empty($nemi_page_layouts['sidebars']) ) : ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
