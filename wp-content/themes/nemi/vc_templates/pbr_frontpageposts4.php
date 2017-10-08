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

<section class="widget frontpage-posts frontpage-4 section-blog  <?php echo (($el_class!='')?' '.$el_class:''); ?>">
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

$_count =1;

$colums = '3';
$bscol = floor( 12/$colums );
 $end = $loop->post_count;
$num_mainpost = 0; 
?>

<div class="frontpage">
<div class="row">
<?php

    $i = 0;
    $main = $num_mainpost;

    while($loop->have_posts()){
        $loop->the_post();
 ?>
        <?php if( $i<=$main-1) { ?>
            <?php if( $i == 0 ) {  ?>
                <div  class="main-posts">
            <?php } ?>
            <?php $thumbsize = isset($thumbsize)? $thumbsize : 'thumbnail';?>
                        <div class="post col-sm-6">
                                 <?php get_template_part( 'vc_templates/post/_single' ) ?>
                        </div>



            <?php if( $i == $main-1 || $i == $end -1 ) { ?>
                </div>
            <?php } ?>
        <?php } else { ?>
                <?php if( $i == $main  ) { ?>
                     <div class="secondary-posts">
                                <?php }  ?>
                                    <div class="col-sm-6 post-items">
                                        <?php get_template_part( 'vc_templates/post/_single-v3' ) ?>
                                    </div>
                                <?php if( $i == $end-1 ) {   ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                <?php  $i++; } ?>
                </div>
</div>

   
    </div>
        <?php if( isset($show_pagination) && $show_pagination ): ?>
        <div class="w-pagination"><?php nemi_fnc_pagination_nav( $post_per_page,$loop->found_posts,$loop->max_num_pages ); ?></div>
        <?php endif ; ?>
</section>
<?php wp_reset_postdata(); ?>