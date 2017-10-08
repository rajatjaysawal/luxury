<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */
get_sidebar( 'mass-footer-body' );

$footer_profile = apply_filters( 'nemi_fnc_get_footer_profile', 'default' );

?>
		</div><!-- #main -->
		<?php do_action( 'nemi_template_main_after' ); ?>
		<?php do_action( 'nemi_template_footer_before' ); ?>
		<footer id="pbr-footer" class="pbr-footer">
			<?php if( $footer_profile ) : ?>
				<div class="inner">
					<?php nemi_fnc_render_post_content( $footer_profile ); ?>
				</div>
			<?php else: ?>
				
			<?php endif; ?>

		</footer><!-- #colophon -->
		<div class="pbr-copyright">
			<div class="container">
				<div class="copyright-content">
					<div class="copyright">
						<?php do_action( 'nemi_fnc_credits' ); ?>
						<?php
							nemi_display_footer_copyright();
						?>	
					</div>
					<div class="custom-copyright">
						<?php dynamic_sidebar( 'custom-copyright' );  ?>
					</div>
				</div>
			</div>
		</div>
		<?php do_action( 'nemi_template_footer_after' ); ?>
		<?php get_sidebar( 'offcanvas' );  ?>
	</div>
</div>
<div class="scrollup">
	<span class="fa fa-long-arrow-up"></span>
</div>
	<!-- #page -->
<?php wp_footer(); ?>
</body>
</html>