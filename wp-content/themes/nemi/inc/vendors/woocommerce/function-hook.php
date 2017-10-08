<?php

function nemi_woocommerce_enqueue_scripts() {
	wp_enqueue_script( 'nemi-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery', 'suggest' ), NEMI, true );
}
add_action( 'wp_enqueue_scripts', 'nemi_woocommerce_enqueue_scripts' );


/**
 */
add_filter('woocommerce_add_to_cart_fragments',	'nemi_fnc_woocommerce_header_add_to_cart_fragment' );

function nemi_fnc_woocommerce_header_add_to_cart_fragment( $fragments ){
	global $woocommerce;

	$fragments['#cart .mini-cart-items'] =  sprintf(_n(' <span class="mini-cart-items"> %d  </span> ', ' <span class="mini-cart-items"> %d <em>items</em> </span> ', $woocommerce->cart->cart_contents_count, 'nemi'), $woocommerce->cart->cart_contents_count);
 	$fragments['#cart .mini-cart .amount'] = trim( $woocommerce->cart->get_cart_total() );

    return $fragments;
}

/**
 * Mini Basket
 */
if(!function_exists('nemi_fnc_minibasketent')){
    function nemi_fnc_minibasketent( $style='' ){
        $template =  apply_filters( 'nemi_fnc_minibasketent_template', nemi_fnc_get_header_layout( '' )  );

      //  if( $template == 'v4' ){
        //	$template = 'v3';
     //   }

        return get_template_part( 'woocommerce/cart/mini-cart-button', $template );
    }
}
if(nemi_fnc_theme_options("woo-show-minicart",true)){
	add_action( 'nemi_template_header_right', 'nemi_fnc_minibasketent', 30, 0 );
}
/******************************************************
 * 												   	  *
 * Hook functions applying in archive, category page  *
 *												      *
 ******************************************************/
function nemi_template_woocommerce_main_container_class( $class ){
	if( is_product() ){
		$class .= ' '.  nemi_fnc_theme_options('woocommerce-single-layout');
	}else if( is_product_category() || is_archive()  ){
		$class .= ' '.  nemi_fnc_theme_options('woocommerce-archive-layout');
	}
	return $class;
}

add_filter( 'nemi_template_woocommerce_main_container_class', 'nemi_template_woocommerce_main_container_class' );
function nemi_fnc_get_woocommerce_sidebar_configs( $configs = '' ){

	global $post;
	$right = $left = null;

	if( is_product() ){
		$left  	= nemi_fnc_theme_options( 'woocommerce-single-left-sidebar', 'sidebar-left' );
		$right 	= nemi_fnc_theme_options( 'woocommerce-single-right-sidebar', 'sidebar-right' );
		$layout = nemi_fnc_theme_options( 'woocommerce-single-layout', 'mainright');

	} else if( is_product_category() || is_archive() ){
		$left  	= nemi_fnc_theme_options( 'woocommerce-archive-left-sidebar', 'sidebar-left' );
		$right 	= nemi_fnc_theme_options( 'woocommerce-archive-right-sidebar', 'sidebar-right' );
		$layout = nemi_fnc_theme_options( 'woocommerce-archive-layout', 'mainright' );
	}

	return nemi_fnc_get_layout_configs( $layout, $left, $right, $configs );
}

add_filter( 'nemi_fnc_get_woocommerce_sidebar_configs', 'nemi_fnc_get_woocommerce_sidebar_configs', 1, 1 );

function nemi_woocommerce_breadcrumb_defaults( $args ){
	$breadcrumb_img = nemi_fnc_theme_options( 'wc-banner' );
	$styles = '';
	if ( $breadcrumb_img ) {
		$styles = ' style="background-image: url('.$breadcrumb_img.')"';
	}
	$args['wrap_before'] = '<div class="container"><div class="pbr-breadscrumb pbr-woocommerce-breadcrumb"'.sprintf( '%s', $styles ).'><ol class="breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
	$args['wrap_after'] = '</ol></div></div>';

	return $args;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'nemi_woocommerce_breadcrumb_defaults' );


add_action( 'nemi_woo_template_main_before', 'nemi_pre_woocommerce_breadcrumb', 30, 0 );
if ( ! function_exists( 'nemi_pre_woocommerce_breadcrumb' ) ) {

	/**
	 * Just display breadcrumb if it's shop page
	 */
	function nemi_pre_woocommerce_breadcrumb() {
		woocommerce_breadcrumb();
	}
}


function nemi_fnc_woocommerce_after_shop_loop_start(){
	echo '<div class="products-bottom-wrap clearfix">';
}

add_action( 'woocommerce_after_shop_loop', 'nemi_fnc_woocommerce_after_shop_loop_start', 1 );

function nemi_fnc_woocommerce_after_shop_loop_after(){
	echo '</div>';
}

add_action( 'woocommerce_after_shop_loop', 'nemi_fnc_woocommerce_after_shop_loop_after', 10000 );


/**
 * Wrapping all elements are wrapped inside Div Container which rendered in woocommerce_before_shop_loop hook
 */
function woocommerce_before_shop_loop_start(){
	echo '<div class="products-top-wrap clearfix">';
}

function woocommerce_before_shop_loop_end(){
	echo '</div>';
}

//Add class for hook woocommerce_before_shop_loop
add_action( 'woocommerce_before_shop_loop', 'woocommerce_before_shop_loop_start' , 0 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_before_shop_loop_end' , 1000 );
//Remove catelog ordering
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

//Add Display list/grid 
add_action( 'woocommerce_before_shop_loop', 'nemi_fnc_woocommerce_display_modes' , 25 );
function nemi_fnc_woocommerce_display_modes(){
	global $wp;
	$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
	$woo_display = 'grid';

	if (isset($_GET['display'])){
        $woo_display = $_GET['display'];
    }
    echo '<form class="display-mode" method="get">';
        echo '<button title="'.esc_html__('Grid','nemi').'" class="btn '.($woo_display == 'grid' ? 'active' : '').'" value="grid" name="display" type="submit"><i class="fa fa-th"></i></button>';   
        echo '<button title="'.esc_html__( 'List', 'nemi' ).'" class="btn '.($woo_display == 'list' ? 'active' : '').'" value="list" name="display" type="submit"><i class="fa fa-th-list"></i></button>';   
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) {
            if ( 'display' === $key || 'submit' === $key ) {
                continue;
            }
            if ( is_array( $val ) ) {
                foreach( $val as $innerVal ) {
                    echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
                }

            } else {
                echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
            }
        }
    echo '</form>';   

}



/**
 * Processing hook layout content
 */
function nemi_fnc_layout_main_class( $class ){
	$sidebar = nemi_fnc_theme_options( 'woo-sidebar-show', 1 ) ;
	if( is_single() ){
		$sidebar = nemi_fnc_theme_options('woo-single-sidebar-show'); ;
	}
	else {
		$sidebar = nemi_fnc_theme_options('woo-sidebar-show');
	}

	if( $sidebar ){
		return $class;
	}

	return 'col-lg-12 col-md-12 col-xs-12';
}
add_filter( 'nemi_woo_layout_main_class', 'nemi_fnc_layout_main_class', 4 );


/**
 *
 */
function wpopal_fnc_woocommerce_archive_image(){
	if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
		$thumb =  get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ;

		if( $thumb ){
			$img = wp_get_attachment_image_src( $thumb, 'full' );

			echo '<p class="category-banner"><img src="'.esc_url_raw( $img[0]).'"></p>';
		}
	}
}
add_action( 'woocommerce_archive_description', 'wpopal_fnc_woocommerce_archive_image', 9 );

	/**
	 *
	 */
function nemi_fncr_woocommerce_single_product_summary_outer_promotions() {
		global $product ;

		$post_id = $product->get_id();

		$wfg_enabled 	 = get_post_meta( $post_id, '_wfg_single_gift_enabled', true );
		$allowed 		 = get_post_meta( $post_id, '_wfg_single_gift_allowed', true );
		$products 		 = get_post_meta( $post_id, '_wfg_single_gift_products', true );
  	?>

  	<?php if( $wfg_enabled && $products ) : ?>
     	<div role="alert" class="productinfo-free-gift alert alert-danger media">
	     	<div class="gifts-icon pull-left"><i class="fa fa-gift fa-2x"></i></div>
	     	<div class="gift-content media-body">
		     	<h5><?php esc_html_e( 'Gifts', 'nemi' ); ?></h5>
		  	 	<ul class="list-unstyled">
		  	 		<?php foreach( $products as $product_id ) :
		  	 			$_product = get_product( $product_id );
		  	 		?>
		  	 		<li class="product-gift">
		  	 			<i class="fa fa-check-square"></i>
		  	 			<?php esc_html_e('Free', 'nemi'); ?> <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"><?php echo get_the_title($product_id); ?></a> - <?php echo trim( $_product->get_price_html() ); ?>
		  	 		</li>
		  	 		<?php endforeach; ?>

		  	 	</ul>
	  		</div>
		</div>
	<?php endif; ?>

<?php }

add_action( 'woocommerce_single_product_summary', 'nemi_fncr_woocommerce_single_product_summary_outer_promotions', 99 );

add_filter( 'yith_wcwl_button_label',          'nemi_fnc_woocomerce_icon_wishlist'  );
add_filter( 'yith-wcwl-browse-wishlist-label', 'nemi_fnc_woocomerce_icon_wishlist_add' );


function nemi_fnc_woocomerce_icon_wishlist( $value='' ){
	return '<i class="icon-wishlist"></i><span class="title">'.esc_html__('Wishlist', 'nemi').'</span>';
}

function nemi_fnc_woocomerce_icon_wishlist_add(){
	return '<i class="icon-wishlist"></i><span class="title">'.esc_html__('Added', 'nemi').'</span>';
}


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'pbrthemer_woocommerce_output_related_products', 'woocommerce_output_related_products', 20 );

/**
 * Show/Hide related, upsells products
 */
function nemi_woocommerce_related_upsells_products($located, $template_name) {
	$options      = get_option('pbr_theme_options');
	$content_none = get_template_directory() . '/woocommerce/content-none.php';

	if ( 'single-product/related.php' == $template_name ) {
		if ( isset( $options['wc_show_related'] ) &&
			( 1 == $options['wc_show_related'] ) ) {
			$located = $content_none;
		}
	} elseif ( 'single-product/up-sells.php' == $template_name ) {
		if ( isset( $options['wc_show_upsells'] ) &&
			( 1 == $options['wc_show_upsells'] ) ) {
			$located = $content_none;
		}
	}

	return apply_filters( 'nemi_woocommerce_related_upsells_products', $located, $template_name );
}

add_filter( 'wc_get_template', 'nemi_woocommerce_related_upsells_products', 10, 2 );

/**
 * Number of products per page
 */
function nemi_woocommerce_shop_per_page($number) {
	$value = nemi_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
	if ( is_numeric( $value ) && $value ) {
		$number = absint( $value );
	}
	return $number;
}

add_filter( 'loop_shop_per_page', 'nemi_woocommerce_shop_per_page' );

/**
 * Number of products per row
 */
function nemi_woocommerce_shop_columns($number) {
	$value = nemi_fnc_theme_options('wc_itemsrow', 3);
	if ( in_array( $value, array(2, 3, 4, 6) ) ) {
		$number = $value;
	}
	return $number;
}

add_filter( 'loop_shop_columns', 'nemi_woocommerce_shop_columns' );

function nemi_fnc_woocommerce_share_box() {
	if ( nemi_fnc_theme_options('wc_show_share_social', 1) ) {
		get_template_part( 'page-templates/parts/sharebox' );
	}
}
add_action( 'woocommerce_single_product_summary', 'nemi_fnc_woocommerce_share_box', 100 );

function nemi_fnc_woocommerce_product_thumbnails_columns($number) {
	return 5;
}
add_filter('woocommerce_product_thumbnails_columns', 'nemi_fnc_woocommerce_product_thumbnails_columns');


function nemi_single_product_config( $productConfig ){
	return array(
	  'product_enablezoom'         => 1,
	  'product_zoommode'           => 'window',
	  'product_zoomeasing'         => 1,
	  'product_zoomlensshape'      => "round",
	  'product_zoomlenssize'       => "300",
	  'product_zoomgallery'        => 0,
	  'enable_product_customtab'   => 0,
	  'product_customtab_name'     => '',
	  'product_customtab_content'  => '',
	  'product_related_column'     => 0,
	  'product_zoomWindowPosition' => 1
	);
}
add_filter('pbrthemer_woocommerce_product_zoom_config', 'nemi_single_product_config' );

add_action( 'woocommerce_single_product_summary', 'nemi_pre_tag_short_description', 19.9999 );
if ( ! function_exists( 'nemi_pre_tag_short_description' ) ) {

	function nemi_pre_tag_short_description() {
		?>
			<div class="product_ctn_bottom">
		<?php
	}
}

add_action( 'woocommerce_single_product_summary', 'nemi_pre_tag_share', 99.9999 );
if ( ! function_exists( 'nemi_pre_tag_share' ) ) {

	function nemi_pre_tag_share() {
		?>
			<div class="product_ctn_share">
		<?php
	}
}


add_action( 'woocommerce_single_product_summary', 'nemi_after_tag_short_description', 10.0001 );
add_action( 'woocommerce_single_product_summary', 'nemi_after_tag_short_description', 40.0001 );
if ( ! function_exists( 'nemi_after_tag_short_description' ) ) {

	function nemi_after_tag_short_description() {
		?>
			</div>
		<?php
	}
}

add_action( 'woocommerce_single_product_images', 'nemi_woocommerce_single_product_images_senior' );
if ( ! function_exists( 'nemi_woocommerce_single_product_images_senior' ) ) {

	function nemi_woocommerce_single_product_images_senior() {
		wc_get_template_part( 'product-image', 'senior' );
	}

}

if ( ! function_exists( 'nemi_full_image_size' ) ) {

	function nemi_full_image_size( $size ) {
		$size = 'full';
		return $size;
	}
}


//Render form fillter product
function nemi_woocommerce_product_fillter($options, $name, $default){
    // Only show on product categories
    if ( ! woocommerce_products_will_display() ) :
        return;
    endif;

    ?>
    <form method="get" class="woocommerce-fillter">
        <select name="<?php echo esc_attr($name); ?>" onchange="this.form.submit()" class="select">
            <?php foreach( $options as $key => $value ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, nemi_woocommerce_get_fillter($name, $default) ); ?>>
                    <?php echo trim($value);?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) :

            if ( $name === $key || 'submit' === $key ) :
                continue;
            endif;
            if ( is_array( $val ) ) :
                foreach( $val as $inner_val ) :
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
                endforeach;
            else :
                ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
            endif;
        endforeach;
    ?>
    </form>
<?php

}

//get value fillter
function nemi_woocommerce_get_fillter($name, $default){

    if ( isset( $_GET[$name] ) ) :
        return $_GET[$name];
    else :
        return $default;
    endif;
}


//Add query product per page
function nemi_woocommerce_product_per_page_query( $q ){
    $default = nemi_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
    $product_per_page = nemi_woocommerce_get_fillter('product_per_page',$default);
    if ( function_exists( 'woocommerce_products_will_display' ) && woocommerce_products_will_display() && $q->is_main_query() ) :
        $q->set( 'posts_per_page', $product_per_page );
    endif;
}
add_action( 'woocommerce_product_query', 'nemi_woocommerce_product_per_page_query' );


//Add form fillter by product per page
function nemi_woocommerce_product_per_page_fillter(){
    $columns = nemi_fnc_theme_options('wc_itemsrow', 3);
    $default = nemi_fnc_theme_options('woo-number-page', get_option('posts_per_page'));
    $options= array();
    for($i=1; $i<=5; $i++){
        $options[$i*$columns] =  $i*$columns.' '.esc_html__( ' products per page', 'nemi');
    }
    $options['-1'] = esc_html__('All products', 'nemi' );
    $name = 'product_per_page';
    nemi_woocommerce_product_fillter($options, $name, $default);
}

//Add product per page filter
add_action('woocommerce_before_shop_loop', 'nemi_woocommerce_product_per_page_fillter', 30);


function nemi_fnc_woocommerce_product_type(){
	$options = array(
        'recent_products'      => esc_html__( 'Latest', 'nemi' ),
        'sale_products'         => esc_html__( 'Sale', 'nemi' ),
        'featured_products'     => esc_html__( 'Featured', 'nemi' ),
        'best_selling_products' => esc_html__( 'Best Selling', 'nemi' ),
        'top_rate'              => esc_html__( 'Top Rate', 'nemi' ),
    ); ?>
    <ul class="nav nav-tabs product-type" role="tablist">
    	<?php foreach ($options as $key => $value): ?>
    		<li role="presentation" class="<?php echo ($key=='recent_products')? 'active': ''; ?>">
    			<a href="#<?php echo esc_attr($key);?>" aria-controls="<?php echo esc_attr($key);?>" role="tab" data-toggle="tab">
    				<?php echo trim($value); ?>
				</a>
    		</li>
    	<?php endforeach; ?>
    </ul>
<?php
}
add_action('woocommerce_before_shop_loop', 'nemi_fnc_woocommerce_product_type', 5);