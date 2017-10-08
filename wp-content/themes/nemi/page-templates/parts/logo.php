<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): ?>
	<div id="pbr-logo" class="logo">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php the_custom_logo(); ?>
		</a>
	</div>
<?php else: ?>
	<div id="pbr-logo" class="logo logo-theme">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
		</a>
	</div>
<?php endif; ?>