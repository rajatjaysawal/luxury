<?php

/**
 * Remove javascript and css files not use
 */


/**
 * Hoo to top bar layout
 */
function nemi_fnc_topbar_layout(){
	$layout = nemi_fnc_get_header_layout();
	get_template_part( 'page-templates/parts/topbar', $layout );
	get_template_part( 'page-templates/parts/topbar', 'mobile' );
}

add_action( 'nemi_template_header_before', 'nemi_fnc_topbar_layout' );

/**
 * Hook to select header layout for archive layout
 */
function nemi_fnc_get_header_layout( $layout = '' ) {
	global $post;

	$layout = $post && get_post_meta( $post->ID, 'nemi_header_layout', 1 ) ? get_post_meta( $post->ID, 'nemi_header_layout', 1 ) : nemi_fnc_theme_options( 'headerlayout' );

 	if( $layout && $layout !='global' ) {
 		return trim( $layout );
 	} else if ( $layout == 'global' && $layout = nemi_fnc_theme_options( 'headerlayout','' ) ) {

 		return trim( $layout );
 	}

	return $layout;
}

add_filter( 'nemi_fnc_get_header_layout', 'nemi_fnc_get_header_layout' );

/**
 * Hook to select header layout for archive layout
 */
function nemi_fnc_get_footer_profile( $profile='default' ) {
	global $post;

	$profile = is_page() && $post ? get_post_meta( $post->ID, 'nemi_footer_profile', 1 ) : 'global';

 	if( $profile && $profile != 'global' ) {
 		return trim( $profile );
 	} elseif ( $profile == 'global' && $profile = nemi_fnc_theme_options('footer-style', $profile ) ) {
 		return trim( $profile );
 	}

	return $profile;
}

add_filter( 'nemi_fnc_get_footer_profile', 'nemi_fnc_get_footer_profile' );

/**
 * Show preload image
 */

// function nemi_fnc_preload_layout(){
// 	if( nemi_fnc_theme_options('show_preloaded', 1) ){
// 		get_template_part( 'page-templates/parts/preloader' ); 
// 	}
// }

// add_action( 'wp_footer', 'nemi_fnc_preload_layout' );

/**
 * Render Custom Css Renderig by Visual composer
 */
if ( !function_exists( 'nemi_fnc_print_style_footer' ) ) {
	function nemi_fnc_print_style_footer(){
		$footer =  nemi_fnc_get_footer_profile( 'default' );
		if($footer!='default'){
			$shortcodes_custom_css = get_post_meta( $footer, '_wpb_shortcodes_custom_css', true );
			if ( ! empty( $shortcodes_custom_css ) ) {
				echo '<style>
					'.$shortcodes_custom_css.'
					</style>';
			}
		}
	}
	add_action('wp_head','nemi_fnc_print_style_footer', 18);
}

/**
 * Hook to show breadscrumbs
 */
function nemi_fnc_render_breadcrumbs() {

	global $post;
	if ( is_object($post) ) {
		$disable = get_post_meta( $post->ID, 'nemi_disable_breadscrumb', 1 );
		if( $disable ){
			return true;
		}
		$bgimage = get_post_meta( $post->ID, 'nemi_image_breadscrumb', 1 );
		if(!empty($bgimage)){
			$bglink = wp_get_attachment_url($bgimage);
			
		}else{
			$bglink = nemi_fnc_theme_options('top-banner');
		}
		$color 	 = get_post_meta( $post->ID, 'nemi_color_breadscrumb', 1 );
		$bgcolor = get_post_meta( $post->ID, 'nemi_bgcolor_breadscrumb', 1 );
		$style = array();
		if( !empty( $bgcolor ) ){
			$style[] = 'background-color:'.$bgcolor;
		}
		if( !empty( $bglink ) ){
			$style[] = 'background-image:url(\''.esc_url_raw( $bglink ).'\'); background-position: top center;';
		}

		if( !empty($color ) ){
			$style[] = 'color:'.$color;
		}

		$estyle = ! empty( $style ) ? 'style="' . implode( ';', $style ) . '"':"";
	} else {
		
		$estyle = '';
	}

	echo '<section id="pbr-breadscrumb" class="pbr-breadscrumb" '.sprintf( '%s', $estyle ).'><div class="container">';
			nemi_fnc_breadcrumbs();
	echo '</div></section>';

}

add_action( 'nemi_template_main_before', 'nemi_fnc_render_breadcrumbs' );

/**
 * Main Container
 */

function nemi_template_main_container_class( $class ){
	global $post;
	global $nemi_wpopconfig;

	if ( $post && isset( $post->ID ) ) {
		$layoutcls = get_post_meta( $post->ID, 'nemi_enable_fullwidth_layout', 1 );

		if( $layoutcls ) {
			$nemi_wpopconfig['layout'] = 'fullwidth';
			return 'container-fluid';
		}
	}
	return $class;
}
add_filter( 'nemi_template_main_container_class', 'nemi_template_main_container_class', 1 , 1  );
add_filter( 'nemi_template_main_content_class', 'nemi_template_main_container_class', 1 , 1  );

function nemi_template_footer_before(){
	return get_sidebar( 'newsletter' );
}

//add_action( 'nemi_template_footer_before', 'nemi_template_footer_before' );

/**
 * Get Configuration for Page Layout
 *
 */
function nemi_fnc_get_page_sidebar_configs( $configs='' ){

	global $post;
	if ( is_object($post) ) {
		$left  	= get_post_meta( $post->ID, 'nemi_leftsidebar', 1 ) ? get_post_meta( $post->ID, 'nemi_leftsidebar', 1 ) : nemi_fnc_theme_options( 'page-left-sidebar', 'blog-sidebar-left');
		$right 	= get_post_meta( $post->ID, 'nemi_rightsidebar', 1 ) ? get_post_meta( $post->ID, 'nemi_rightsidebar', 1 ) : nemi_fnc_theme_options( 'page-right-sidebar', 'blog-sidebar-right');
		$layout = get_post_meta( $post->ID, 'nemi_page_layout', 1 );
	} else {
		$left  	= 1;
		$right 	= 1;
		$layout = 1;
	}
	return nemi_fnc_get_layout_configs($layout, $left, $right, $configs );
}

add_filter( 'nemi_fnc_get_page_sidebar_configs', 'nemi_fnc_get_page_sidebar_configs', 1, 1 );

function nemi_fnc_get_single_sidebar_configs( $configs = '' ) {
	global $post;

	$layout = nemi_fnc_theme_options( 'blog-single-layout', 'fullwidth');
	$left  	= nemi_fnc_theme_options( 'blog-single-left-sidebar', 'blog-sidebar-left');
	$right 	= nemi_fnc_theme_options( 'blog-single-right-sidebar', 'blog-sidebar-right');

	return nemi_fnc_get_layout_configs($layout, $left, $right, $configs );
}

add_filter( 'nemi_fnc_get_single_sidebar_configs', 'nemi_fnc_get_single_sidebar_configs', 1, 1 );

function nemi_fnc_get_archive_sidebar_configs( $configs = '' ){

	$left  	= nemi_fnc_theme_options( 'blog-archive-left-sidebar', 'blog-sidebar-left');
	$right 	= nemi_fnc_theme_options( 'blog-archive-right-sidebar', 'blog-sidebar-right');
	$layout = nemi_fnc_theme_options( 'blog-archive-layout', 'fullwidth');

	return nemi_fnc_get_layout_configs($layout, $left, $right, $configs);
}

add_filter( 'nemi_fnc_get_archive_sidebar_configs', 'nemi_fnc_get_archive_sidebar_configs', 1, 1 );
add_filter( 'nemi_fnc_get_category_sidebar_configs', 'nemi_fnc_get_archive_sidebar_configs', 1, 1 );


function nemi_fnc_sidebars_others_configs(){

	global $nemi_page_layouts;

	return $nemi_page_layouts;
}

add_filter("nemi_fnc_sidebars_others_configs", "nemi_fnc_sidebars_others_configs");


function nemi_fnc_get_layout_configs( $layout, $left, $right, $configs = array() ){

    switch ($layout) {

	    //One Sidebar Right
	    case 'mainright':
	        $configs['sidebars'] = array(
	    		'left'  => array('show'  	=> false),
				'right' => array(
					'show'  	=> true,
					'sidebar' 	=> $right,
					'active' 	=> is_active_sidebar( $right ),
					'class' 	=> 'col-xs-12 col-md-3'
				)
			);
			$configs['main'] = array('class' => 'col-xs-12 col-md-9 pull-left');
	    break;

	    // One Sidebar Left
	    case 'leftmain':
	        $configs['sidebars'] = array(
	    		'left'  => array(
	    			'show'  	=> true,
	    			'sidebar' 	=> $left,
	    			'active'  	=> is_active_sidebar( $left ),
	    			'class' 	=> 'col-xs-12 col-md-3'
				),
				'right' => array('show'  	=> false)
			);
			$configs['main'] = array('class' => 'col-xs-12 col-md-9 pull-right');
	    break;

	    // Fullwidth
	    default:
	        $configs['sidebars'] = array(
	    		'left'  => array('show'  	=> false),
				'right' => array('show'  	=> false )
			);
			$configs['main'] = array('class' => 'col-xs-12 col-md-12');
	        break;
    }

    return $configs;
}

if(!function_exists('nemi_fnc_related_post')){
    function nemi_fnc_related_post( $relate_count = 4, $posttype = 'post', $taxonomy = 'category' ){

        $terms = get_the_terms( get_the_ID(), $taxonomy );
        $termids =array();

        if($terms){
            foreach($terms as $term){
                $termids[] = $term->term_id;
            }
        }

        $args = array(
            'post_type' => $posttype,
            'posts_per_page' => $relate_count,
            'post__not_in' => array( get_the_ID() ),
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $termids,
                    'operator' => 'IN'
                )
            )
        );


        $relates = new WP_Query( $args );
 		if( $relates->have_posts() ): ?>
	    <div class="widget">
	        <h4 class="related-post-title">
	            <span><?php esc_html_e( 'Related post', 'nemi' ); ?></span>
	        </h4>

	        <div class="related-posts-content">
	            <div class="row">
	            <?php
	                $class_column = 12/$relate_count;
	                while ( $relates->have_posts() ) : $relates->the_post();
	                    ?>
	                    <div class="col-sm-<?php echo esc_attr( $class_column ); ?> col-md-<?php echo esc_attr( $class_column ); ?> col-lg-<?php echo esc_attr( $class_column ); ?>">
	                          <article class="post">
	                        <?php
	                        if ( has_post_thumbnail() ) {
	                            ?>
	                                <figure class="entry-thumb">
	                                    <a href="<?php the_permalink(); ?>" title="" class="entry-image zoom-2">
	                                        <?php the_post_thumbnail( );?>
	                                    </a>
	                                    <!-- vote    -->
	                                    <?php do_action('nemi_fnc_rating') ?>
	                                </figure>
	                            <?php
	                        }
	                        ?>
	                        <div class="entry-content">

	                            <?php if (get_the_title()) { ?>
	                                <h4 class="entry-title">
	                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                                </h4>
	                            <?php  } ?>
	                             <div class="entry-meta clearfix">
	                                <span class="entry-date">
	                                <span><?php the_time( 'd' ); ?></span>&nbsp;<?php the_time( 'M' ); ?>
	                                </span>
	                                <span class="meta-sep"> | </span>
	                                <span class="author"><?php esc_html_e('by', 'nemi'); the_author_posts_link(); ?></span>
	                                <span class="meta-sep"> | </span>
	                                <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
	                                <span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'nemi' ), esc_html__( '1 Comment', 'nemi' ), esc_html__( '% Comments', 'nemi' ) ); ?></span>
	                                <?php endif; ?>
	                            </div>

	                        </div>
	                    </article>
	                    </div>
	                    <?php
	                endwhile; ?>
	            </div>
	        </div>

	    </div>
	        <?php
	    endif;
        wp_reset_postdata();
    }
}


/**
 * Custom template tags for Cropshop
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since Nemi 1.0
 */

if ( ! function_exists( 'nemi_fnc_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Nemi 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function nemi_fnc_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( 'Previous', 'nemi' ),
		'next_text' => esc_html__( 'Next', 'nemi' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'nemi' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo trim($links); ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'nemi_fnc_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation">
		<h3 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'nemi' ); ?></h3>
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link','<div class="col-lg-6"><span class="meta-nav">'. esc_html__('Published In', 'nemi').'</span></div>');
			else :
				previous_post_link( '%link','<span class="meta-nav prev">'. esc_html__('Previous Post', 'nemi').'</span>' );
				next_post_link( '%link', '<span class="meta-nav next">' . esc_html__('Next Post', 'nemi').'</span>');
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'nemi_fnc_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post"><span class="fa fa-clock-o"></span> ' . esc_html__( 'Sticky', 'nemi' ) . '</span>';
	}

	// Set up and print post meta information.
	printf( '<span class="entry-date"><span class="fa fa-clock-o"></span> <a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
}
endif;

/**
 * Find out if blog has more than one category.
 *
 * @since Nemi 1.0
 *
 * @return boolean true if blog has more than 1 category
 */
function nemi_fnc_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'nemi_fnc_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'nemi_fnc_category_count', $all_the_cool_cats );
	}

	if ( 1 !== (int) $all_the_cool_cats ) {
		// This blog has more than 1 category so nemi_fnc_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so nemi_fnc_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in nemi_fnc_categorized_blog.
 *
 * @since Nemi 1.0
 */
function nemi_fnc_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'nemi_fnc_category_count' );
}
add_action( 'edit_category', 'nemi_fnc_category_transient_flusher' );
add_action( 'save_post',     'nemi_fnc_category_transient_flusher' );

if ( ! function_exists( 'nemi_fnc_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since Nemi 1.0
 * @since Cropshop 1.4 Was made 'pluggable', or overridable.
 */
function nemi_fnc_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
	<?php
		if ( ( ! is_active_sidebar( 'sidebar-2' ) || is_page_template( 'page-templates/full-width.php' ) ) ) {
			the_post_thumbnail( 'nemi-full-width' );
		} else {
			the_post_thumbnail();
		}
	?>
	</div>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
	<?php
		if ( ( ! is_active_sidebar( 'sidebar-2' ) || is_page_template( 'page-templates/full-width.php' ) ) ) {
			the_post_thumbnail( 'nemi-full-width' );
		} else {
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		}
	?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'nemi_fnc_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ...
 * and a Continue reading link.
 *
 * @since Cropshop 1.3
 *
 * @param string $more Default Read More excerpt link.
 * @return string Filtered Read More excerpt link.
 */
function nemi_fnc_excerpt_more( $more ) {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( esc_html__( 'Continue reading %s', 'nemi' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' ). ' <span class="meta-nav">&rarr;</span>'
		);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'nemi_fnc_excerpt_more' );
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image except in Multisite signup and activate pages.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Nemi 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function nemi_fnc_body_classes( $classes ) {
	global $post;

	$additionclass = (is_object($post) ? get_post_meta( $post->ID, 'nemi_additionclass', 1 ) : '');
	if ( !empty($additionclass) ) {
		$classes[] = $additionclass;
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
		$classes[] = 'masthead-fixed';
	}


	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	$currentSkin = str_replace( '.css','',nemi_fnc_theme_options('skin','default') );

	if( $currentSkin ){
		$class[] = 'skin-'.$currentSkin;
	}

	return $classes;
}
add_filter( 'body_class', 'nemi_fnc_body_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Nemi 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function nemi_fnc_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'nemi' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'nemi_fnc_wp_title', 10, 2 );

/**
 * upbootwp_breadcrumbs function.
 * Edit the standart breadcrumbs to fit the bootstrap style without producing more css
 * @access public
 * @return void
 */
function nemi_fnc_breadcrumbs() {

	$delimiter = '';
	$home = esc_html__( 'Home', 'nemi' );
	$before = '<li>';
	$after = '</li>';
	$title = '';
	$breadcrumbs = '';

	if ( ( ! is_home() && ! is_front_page() ) || is_paged() ) {

		

		global $post;
		$homeLink = esc_url( home_url() );
		$breadcrumbs .= '<li><a href="' . esc_url( $homeLink ) . '">' . esc_html( $home ) . '</a> ' . $delimiter . '</li> ';

		if (is_category()) {

			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0) $breadcrumbs .= (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			$breadcrumbs .= trim($before) . single_cat_title('', false) . $after;
			$title = single_cat_title('', false);
		} elseif (is_day()) {
			$breadcrumbs .= '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
			$breadcrumbs .= '<li><a href="' . esc_url( get_month_link(get_the_time('Y'),get_the_time('m')) ) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
			$breadcrumbs .= trim($before) . get_the_time('d') . $after;
			$title = get_the_time('d');
		} elseif (is_month()) {
			$breadcrumbs .= '<li><a href="' . esc_url( get_year_link(get_the_time('Y')) ) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
			$breadcrumbs .= trim($before) . get_the_time('F') . $after;
			$title = get_the_time('F');
		} elseif (is_year()) {
			$breadcrumbs .= trim($before) . get_the_time('Y') . $after;
			$title = get_the_time('Y');
		} elseif (is_single() && !is_attachment()) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$breadcrumbs .= '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
				$breadcrumbs .= trim($before) . get_the_title() . $after;
				$title = get_post_type();
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$breadcrumbs .= get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
				$breadcrumbs .= trim($before) . get_the_title() . $after;
				$title = get_the_title();
			}

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$breadcrumbs .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			$breadcrumbs .= '<li><a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
			$breadcrumbs .= trim($before) . get_the_title() . $after;
			$title = get_the_title();
		} elseif ( is_page() && !$post->post_parent ) {
			$breadcrumbs .= trim($before) . get_the_title() . $after;
			$title = get_the_title();

		} elseif ( is_page() && $post->post_parent || ( is_home() && !is_front_page() ) ) {
			$parent_id  = $post->post_parent;
			$_breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$_breadcrumbs[] = '<li><a href="' . esc_url( get_permalink($page->ID) ) . '">' . get_the_title($page->ID) . '</a></li>';
				$parent_id  = $page->post_parent;
			}
			$_breadcrumbs = array_reverse($_breadcrumbs);
			foreach ($_breadcrumbs as $crumb) $breadcrumbs .=  trim($crumb) . ' ' . $delimiter . ' ';
			$breadcrumbs .=  trim($before) . get_the_title() . $after;
			$title = get_the_title();
		} elseif ( is_search() ) {
			$breadcrumbs .=  trim($before) . esc_html__('Search results for ', 'nemi') . '"' . get_search_query() . '"' . $after;
			$title = esc_html__('Search results for "', 'nemi')  . get_search_query();
		} elseif ( is_tag() ) {
			$breadcrumbs .=  trim($before) . esc_html__('Posts tagged "', 'nemi'). single_tag_title('', false) . '"' . $after;
			$title = esc_html__('Posts tagged "', 'nemi'). single_tag_title('', false) . '"';
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			$breadcrumbs .=  trim($before) . esc_html__('Articles posted by ', 'nemi') . $userdata->display_name . $after;
			$title = esc_html__('Articles posted by ', 'nemi') . $userdata->display_name;
		} elseif ( is_404() ) {
			$breadcrumbs .=  trim($before) . esc_html__('Error 404', 'nemi') . $after;
			$title = esc_html__('Error 404', 'nemi');
		}elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( is_object( $post_type ) ) {
				$breadcrumbs .= trim($before) . $post_type->labels->singular_name . $after;
				$title = $post_type->labels->singular_name;
			}
		} 
		echo '<ol class="breadcrumb">';
			echo '<li class="active"><h2 class="title-active page-title">'.$title.'</h2></li>';
			echo trim($breadcrumbs);
		echo '</ol>';

	}
}


 /**
 *
 */
function nemi_display_footer_content(){
	$footer_profile =  apply_filters( 'nemi_fnc_get_footer_profile', 'default' );

	if( $footer_profile && !$footer_profile != 'default' ):
		$footer_data = nemi_fnc_get_footer_profile_postdata( $footer_profile );
 	?>
 	<?php if( $footer_data ): ?>
		<div class="opal-footer-profile clearfix">
			<?php echo do_shortcode( $footer_data->post_content ); ; ?>
		</div>
	<?php endif; ?>
	<?php else: ?>
	<?php get_sidebar( 'footer' ); ?>
	<?php endif; ?>

<?php
}

/**
 *
 */
function nemi_display_footer_copyright(){
	$copyright_text =  nemi_fnc_theme_options('copyright_text', '');
	if(!empty($copyright_text)){
		echo do_shortcode($copyright_text);
	}else{
		$devby = '<a target="_blank" href="'.esc_url('http://wwww.engotheme.com').'">Engotheme Team</a>';
		printf( esc_html__( 'Proudly powered by %s. Developed by %s', 'nemi' ), 'WordPress', $devby );
	}
}


if(!function_exists('nemi_fnc_categories_searchform')){
    function nemi_fnc_categories_searchform(){
        if( class_exists('WooCommerce') ){
			$dropdown_args = array(
			    'show_counts'        => false,
			    'hierarchical'       => true,
			    'show_uncategorized' => 0
			);
		?>
		<form method="get" class="input-group search-category" action="<?php echo esc_url( home_url('/') ); ?>"><div class="input-group-addon search-category-container">
		  <div class="select">
		    <?php wc_product_dropdown_categories( $dropdown_args ); ?>
		  </div>
		</div>
		<input name="s" maxlength="60" class="form-control search-category-input" type="text" size="20" placeholder="<?php esc_html_e('What do you need...', 'nemi'); ?>">

		<div class="input-group-btn">
		    <label class="btn btn-link btn-search">
		      <span class="title-search hidden"><?php esc_html_e('Search', 'nemi') ?></span>
		      <input type="submit" class="fa searchsubmit" value=""/>
		    </label>
		    <input type="hidden" name="post_type" value="product"/>
		</div>
		</form>
		<?php
		}else{
			get_search_form();
		}
    }
}


if(!function_exists('nemi_pbr_string_limit_words')){
    function nemi_pbr_string_limit_words($string, $word_limit)
    {
		$words = explode(' ', $string, ($word_limit + 1));

		if(count($words) > $word_limit) {
		array_pop($words);
		}

		return implode(' ', $words);
    }
}