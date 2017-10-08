<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();

$layout = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(empty($loop)) return;
$this->getLoop($loop);
$args = $this->loop_args;


if(is_front_page()){
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
else{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
$args['paged'] = $paged; 
$post_per_page = $args['posts_per_page']; 
 
$loop = new WP_Query($args);
?>

<section class="widget frontpage-posts frontpage-9 <?php echo (($el_class!='')?' '.esc_attr( $el_class ):''); ?>">
    <?php
        if($title!=''){ ?>
            <h3 class="widget-title">
                <span><?php echo trim($title); ?></span>
            </h3>
        <?php }
    ?>
    <div class="widget-content"> 
      <?php
        /**
         * $loop
         * $class_column
         *
         */

        $_count =0;

        $colums = $grid_columns;
        //echo "<pre>".print_r($colums,1);
        $bscol = floor( 12/$colums );

        ?>
         
        <div class="posts-grid grid">
            <?php
                $i =0; while($loop->have_posts()){  $loop->the_post(); ?>
                <?php $thumbsize = isset($thumbsize)? $thumbsize : 'thumbnail';?>

                <?php if(  $i++%$colums==0 ) {  ?>
                <div class="post-item grid-item row">
                <?php } ?>
                <div class="col-sm-<?php echo esc_attr($bscol); ?> grid-item">
                    <article class="post">
                        <div class="blog">
                            <?php
                            if ( has_post_thumbnail() ) {
                                ?>
                                    <figure class="entry-thumb">
                                        <a href="<?php the_permalink(); ?>" title="" class="entry-image zoom-2">
                                            <?php the_post_thumbnail( '$thumbsize' );?>
                                        </a>
                                        <!-- vote    -->
                                        <?php do_action('nemi_fnc_rating') ?>
                                    </figure>
                                    <?php
                                }
                            ?>
                            <div class="entry-content">                                
                                <header class="entry-header">
                                    <?php if (get_the_title()) { ?>
                                        <h3 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                    <?php  } ?>
                                </header>

                                <div class="date-cate">
                                    <span class="entry-date">
                                        <?php the_time('F j, Y'); ?>
                                    </span>

                                    <?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && nemi_fnc_categorized_blog() ) : ?>
                                        <div class="cat-links-meta">
                                            <span class="cat-links">
                                                <?php echo get_the_category_list( _x( ' ', 'Used between list items, there is a space after the comma.', 'nemi' ) ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php
                                    if (! has_excerpt()) {
                                        echo "";
                                    } else {
                                        ?>
                                            <p class="entry-description"><?php echo nemi_fnc_excerpt(50,'...'); ?></p>
                                        <?php
                                    }
                                ?>

                                <div class="readmore">
                                    <a class="btn btn-link" href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Continue Reading', 'nemi' ); ?>">
                                        <?php esc_html_e( 'Continue Reading', 'nemi' ); ?>
                                    </a>
                                </div>

                                <!-- <div class="entry-meta clearfix">
                                    <span class="author">
                                        <?php esc_html_e('by ', 'nemi'); the_author_posts_link(); ?>
                                    </span>

                                    <span class="meta-sep"> | </span>
                                    
                                </div> --> <!-- .entry-meta -->

                            </div>
                            
                            
                        </div>
                    </article>
                </div>
                <?php if(  ($i%$colums==0) || $i == $loop->post_count) {  ?>
                </div>
                <?php } ?>
            <?php   }  ?>
        </div>
         


    </div>
        <?php if( isset($show_pagination) && $show_pagination ): ?>
        <div class="w-pagination"><?php nemi_fnc_pagination_nav( $post_per_page,$loop->found_posts,$loop->max_num_pages ); ?></div>
        <?php endif ; ?>
</section>
<?php wp_reset_postdata(); ?>