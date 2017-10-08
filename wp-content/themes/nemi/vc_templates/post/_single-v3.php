<?php
   global $thumbsize;
   $thumbsize = !empty($thumbsize)? $thumbsize : 'thumbnail';
   $post_category = "";
   $categories = get_the_category();
   $separator = ' ';
   $output = '';
   if($categories){
      foreach($categories as $category) {
         $output .= '<a href="'. esc_url( get_category_link( $category->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'nemi' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
      }
      $post_category = trim($output, $separator);
   }      
?>

   <article class="post">

      <div class="blog">
         <figure class="entry-thumb"> 
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="entry-image zoom-2">
               <?php
               if(!empty($thumbsize) && function_exists('wpb_getImageBySize')){
                   $post_thumbnail = wpb_getImageBySize( array( 'post_id' => get_the_ID(), 'thumb_size' => $thumbsize ) );
                   echo trim( $post_thumbnail['thumbnail'] );
               }elseif ( has_post_thumbnail() ){
                   the_post_thumbnail( $thumbsize );
            }?>
            </a>
         </figure>
         <div class="content_blog">
            <div class="content_blog_inner">
               <?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && nemi_fnc_categorized_blog() ) : ?>
                  <div class="cat-links-meta">
                     <span class="cat-links">
                        <?php echo get_the_category_list( _x( ' ', 'Used between list items, there is a space after the comma.', 'nemi' ) ); ?>
                     </span>
                  </div>
               <?php endif; ?>
               
               <header class="entry-header">
                  <h3 class="entry-title">
                     <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h3>
               </header>
               <div class="entry-meta">
                  <span class="comments-link">
                     <?php comments_popup_link( esc_html__( '0 comment', 'nemi' ), esc_html__( '1 Comment', 'nemi' ), esc_html__( '% Comments', 'nemi' ) ); ?>
                  </span> 
               </div>
               <span class="border_content"></span>
            </div>
         </div>
      </div>
   </article>