<?php
/**
 * The Template for displaying all single posts
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */
global $nemi_page_layouts; 
$nemi_page_layouts = apply_filters( 'nemi_fnc_get_single_sidebar_configs', null );

get_header( apply_filters( 'nemi_fnc_get_header_layout', null ) );

?>
<?php do_action( 'nemi_template_main_before' ); ?>
<section id="main-container" class="container <?php echo apply_filters( 'nemi_template_main_content_class', nemi_fnc_theme_options('blog-single-layout') ); ?>">
	<div class="row">
		
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($nemi_page_layouts['main']['class']); ?>">

			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
							?>
							<div class="author-about hidden clearfix">
                        <?php get_template_part('page-templates/parts/author-bio'); ?>
                    </div>
							<?php
							if( nemi_fnc_theme_options('blog-show-related-post', true) ): ?>
							<div class="related-posts">
								<?php
				                    $relate_count = nemi_fnc_theme_options('blog-items-show', 3);
				                    nemi_fnc_related_post($relate_count, 'post', 'category');
			                    ?>
			                </div>
			                <?php endif; ?>
			                <?php
			                
			                // If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						endwhile;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
		</div>

		<?php if( isset($nemi_page_layouts['sidebars']) && !empty($nemi_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>	

	</div>	
</section>
<?php
get_footer();
