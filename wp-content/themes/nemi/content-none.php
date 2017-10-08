<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */
?>

<header class="page-header">
	<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'nemi' ); ?></h1>
</header>

<div class="page-content">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'nemi' ) ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nemi' ); ?></p>
	<?php nemi_fnc_categories_searchform() ?>

	<?php else : ?>

	<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'nemi' ); ?></p>
	<?php nemi_fnc_categories_searchform() ?>

	<?php endif; ?>
</div><!-- .page-content -->
