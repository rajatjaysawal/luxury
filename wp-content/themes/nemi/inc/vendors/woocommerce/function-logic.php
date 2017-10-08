<?php
/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */
function nemi_fnc_woocommerce_query($type,$post_per_page=-1,$cat=''){
    global $woocommerce, $wp_query;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $orderby = (get_query_var('orderby')) ? get_query_var('orderby') : null;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
        'paged' => $paged,
        'orderby'   => $orderby
    );

    if ( isset( $args['orderby'] ) ) {
        if ( 'price' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_price',
                'orderby'   => 'meta_value_num'
            ) );
        }
        if ( 'featured' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_featured',
                'orderby'   => 'meta_value'
            ) );
        }
        if ( 'sku' == $args['orderby'] ) {
            $args = array_merge( $args, array(
                'meta_key'  => '_sku',
                'orderby'   => 'meta_value'
            ) );
        }
    }

    switch ($type) {
        case 'best_selling_products':
            $args['meta_key']   ='total_sales';
            $args['orderby']    ='meta_value_num';
            $args['order']      = 'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            break;

        case 'featured_products':
            
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['tax_query'][]    = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
            break;

        case 'top_rate':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['meta_key']       = '_wc_average_rating';
            $args['orderby']        = 'meta_value_num';
            $args['order']          = 'DESC';
            break;

        case 'recent_products':
            $args['orderby']    = 'date';
            $args['order']      =  'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            break;  

        case 'sale_products':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['post__in']       = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            break;

        case 'recent_review':
            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC";
            $results = $wpdb->get_results($query, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                if(!in_array($re->comment_post_ID, $_pids))
                    $_pids[] = $re->comment_post_ID;
                if(count($_pids) == $_limit)
                    break;
            }

            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = $_pids;

            break;
    }

    if( !empty($cat) && !is_array($cat) ){
        $cat = array( $cat );
    }
    if( !empty($cat) && is_array($cat) ){

        if( isset($cat[0]) && !is_numeric($cat[0]) ){
            $terms = array();
            foreach( $cat as $ct ){
                $ocategory = get_term_by( 'slug', $ct, 'product_cat' );

                if( $ocategory ){
                    $terms[] = $ocategory->term_id;
                }
            }
            $cat = $terms;
        }

        $args['tax_query']    = array(
            array(
                'taxonomy'      => 'product_cat',
                'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                'terms'         =>  $cat,
                'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            )
        );
    }

    return new WP_Query($args);

}

function nemi_fnc_get_review_counting(){

    global $post;
    $output = array();

    for($i=1; $i <= 5; $i++){
         $args = array(
            'post_id'      => ( $post->ID ),
            'meta_query' => array(
              array(
                'key'   => 'rating',
                'value' => $i
              )
            ),
            'count' => true
        );
        $output[$i] = get_comments( $args );
    }
    return $output;
}

function nemi_fnc_price( $price ){
    return $price;
}

function nemi_fnc_woocommerce_getcategorychilds( $parent_id, $array, $level, &$dropdown ) {
    foreach ($array as $key => $value) {
        if ( $value->category_parent == $parent_id ) {
            $data = array(
                str_repeat( "- ", $level ) . $value->name . '('.  $value->term_id .')' => $value->slug,
            );
            $dropdown = array_merge( $dropdown, $data );
            unset($array[$key]);
            nemi_fnc_woocommerce_getcategorychilds( $value->term_id, $array, $level + 1, $dropdown );
        }
    }
}


if ( ! function_exists( 'nemi_fnc_woocommerce_content' ) ) {

    /**
     * Output WooCommerce content.
     *
     * This function is only used in the optional 'woocommerce.php' template
     * which people can add to their themes to add basic woocommerce support
     * without hooks or modifying core templates.
     *
     */
    function nemi_fnc_woocommerce_content() {

        if ( is_singular( 'product' ) ) {

            $header_layout = nemi_fnc_theme_options( 'woocommerce-single-header-layout' );

            while ( have_posts() ) : the_post();
                wc_get_template_part( 'content-single-product', $header_layout );
            endwhile;

        } else { ?>
            <div class="category-header clearfix">
                <?php do_action( 'woocommerce_archive_description' ); ?>
            </div>
            <div class="category-content">

            <?php if ( apply_filters( 'woocommerce_show_page_title', false ) ) : ?>

                <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

            <?php endif; ?>


                <div class="childrens">
                    <ul class="list-inline">
                        <?php woocommerce_product_subcategories(); ?>
                    </ul>
                </div>

                <?php 
                    global $wp_query;
                    $options = array(
                        'recent_products'      => esc_html__( 'Latest', 'nemi' ),
                        'sale_products'         => esc_html__( 'Sale', 'nemi' ),
                        'featured_products'     => esc_html__( 'Featured', 'nemi' ),
                        'best_selling_products' => esc_html__( 'Best Selling', 'nemi' ),
                        'top_rate'              => esc_html__( 'Top Rate', 'nemi' ),
                    ); 
                    if(empty($woocommerce_loop['columns']) ){
                        $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
                    }
                    if ( isset($_GET['display']) && 'list' == $_GET['display'] ) {
                        $woocommerce_loop['columns']=1;
                    }

                ?>


                <?php woocommerce_product_loop_start(); ?>
                <div class="tab-content">
                    <?php foreach($options as $key=> $value): ?>
                        <div role="tabpanel" class="tab-pane fade in <?php echo ($key=='recent_products')? 'active': '';?>" id="<?php echo trim($key);?>">
                            <?php 
                                $args = nemi_woocommerce_meta_query($key);
                                $query = array_merge($wp_query->query_vars, $args);
                                $wp_query = new WP_Query($query);
                            ?>
                            <?php if($wp_query->have_posts()): ?>
                                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                                    <?php wc_get_template_part( 'content', 'product' ); ?>

                                <?php endwhile; // end of the loop. ?>
                                
                                <div class="pagination-tabs">
                                    <div class="clearfix"></div>
                                    <?php woocommerce_pagination(); ?>
                                </div>
                            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                                <?php wc_get_template( 'loop/no-products-found.php' ); ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php woocommerce_product_loop_end(); ?>
                <?php remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 ); ?>
                <?php do_action('woocommerce_after_shop_loop'); ?>
        </div>

        <?php
        }
    }
}

function nemi_fnc_woocommerce_before_shop_loop_item_title(){

    global $product;

    if( $product->get_sale_price() ){
        $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
        echo '<span class="product-sale-label">-' . trim( $percentage ) . '%</span>';
    }

}

function nemi_woocommerce_meta_query($type){
    $args = array();
    switch ($type) {
      
        case 'best_selling_products':
            $args['meta_key']   ='total_sales';
            $args['orderby']    ='meta_value_num';
            $args['order']      = 'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            return $args;
            break;

        case 'featured_products':
            
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['tax_query'][]    = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );
            return $args;
            break;

        case 'top_rate':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['meta_key']       = '_wc_average_rating';
            $args['orderby']        = 'meta_value_num';
            $args['order']          = 'DESC';
            return $args;
            break;

        case 'recent_products':
            $args['orderby']    = 'date';
            $args['order']      =  'DESC';
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query']  = WC()->query->get_tax_query();
            return $args;
            break;  

        case 'sale_products':
            $args['meta_query']     = WC()->query->get_meta_query();
            $args['tax_query']      = WC()->query->get_tax_query();
            $args['post__in']       = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            return $args;
            break;
    }
}

function nemi_fnc_woocommerce_product_type_title($type){
    $options = array(
        'recent_products'       => esc_html__( 'Latest Product', 'nemi' ),
        'sale_products'         => esc_html__( 'Sale Product', 'nemi' ),
        'featured_products'     => esc_html__( 'Featured Product', 'nemi' ),
       'best_selling_products'  => esc_html__( 'Best Selling', 'nemi' ),
        'top_rate'              => esc_html__( 'Top Rate', 'nemi' ),
    );
    foreach($options as $key=>$value){
        if($type == $key){
            return $value;
        }
    } 
}