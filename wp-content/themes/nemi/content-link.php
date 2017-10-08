<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */
$link_url =  get_post_meta( get_the_ID(),'nemi_link_link', true );
$link_text =  get_post_meta( get_the_ID(),'nemi_link_text', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="blog">	
	
	<div class="post-preview">
		<?php if( empty($link_url) ) : ?>
		<?php nemi_fnc_post_thumbnail(); ?>
		<?php else : ?>
		<a class="post-link" href="<?php echo esc_url( $link_url ) ?>" title="<?php echo esc_url( $link_text ) ?>">
			<?php echo esc_url( $link_url ) ?>
		</a>
		<?php endif; ?>
		<?php if ( has_post_thumbnail() ): ?>
			<span class="post-format">
				<a class="entry-format" href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>"></a>
			</span>
		<?php endif; ?>
	</div>

	<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && nemi_fnc_categorized_blog() ) : ?>
		<div class="cat-links-meta">
			<span class="cat-links">
				<?php echo get_the_category_list( _x( ' ', 'Used between list items, there is a space after the comma.', 'nemi' ) ); ?>
			</span>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			endif;
		?>

		<div class="entry-meta clearfix">

			<span class="author">
				<?php esc_html_e('by ', 'nemi'); the_author_posts_link(); ?>
			</span>

			<span class="meta-sep"> | </span>

			<span class="entry-date">
				<span><?php the_time('F j, Y'); ?>
			</span>

			<?php edit_post_link( esc_html__( 'Edit', 'nemi' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			if(is_single()){
				the_content( sprintf(
					esc_html__( 'Continue reading %s', 'nemi').'<span class="meta-nav">&rarr;</span>',
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );
			}else{
				the_excerpt();
			}

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'nemi' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if(is_single()): ?>
		<?php the_tags( '<div class="tag-links"><span class="title">Tag:</span>', ',', '</div>' ); ?>

		<?php if( nemi_fnc_theme_options('blog-show-share-post', true) && function_exists('pbr_themer_get_template_part') ){
				pbr_themer_get_template_part( 'sharebox' );
			} ?>
		<div class="clearfix"></div>
		<?php
		// Previous/next post navigation.
	 	nemi_fnc_post_nav(); ?>
 	<?php else: ?>			 		
     	<div class="readmore">
			<a class="btn btn-primary btn-lg" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read More', 'nemi' ); ?>"><?php esc_html_e( 'Read More', 'nemi' ); ?></a>
		</div>
	<?php endif; ?>
	</div>
</article><!-- #post-## -->
