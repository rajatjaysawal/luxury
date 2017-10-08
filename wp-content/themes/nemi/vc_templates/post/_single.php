<?php 
$post_category = "";
$categories = get_the_category();
$separator = ' | ';
$output = '';
  if($categories){
    foreach($categories as $category) {
      $output .= '<a href="'.esc_url( get_category_link( $category->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'nemi' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
    }
  $post_category = trim($output, $separator);
  }      
?>
<article class="post">
    
    <figure class="entry-thumb">
        <a href="<?php the_permalink(); ?>" title="" class="entry-image zoom-2">
        <?php if ( has_post_thumbnail() ){
                the_post_thumbnail( 'full' );
        }?>
        </a>
        <!-- vote    -->
        <?php do_action('wpopal_show_rating') ?>
         <div class="category-highlight hidden">
            <?php echo trim($post_category); ?>
        </div>
    </figure>

    <div class="entry-content">
        <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
        <?php } ?>
       
        <div class="entry-content-inner clearfix">
            <div class="entry-meta clearfix">
                <span class="entry-date">
                    <span><?php the_time( 'F' ); ?></span>&nbsp;<?php the_time( 'd' ); ?>,&nbsp;<?php the_time( 'Y' ); ?>
                </span>
            </div>
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
            <a href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read More', 'nemi' ); ?>"><?php esc_html_e( 'Read More', 'nemi' ); ?> <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</article>