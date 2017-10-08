<?php 
    $job = get_post_meta( get_the_ID(), 'testimonials_job', true); 
    $name = get_post_meta( get_the_ID(), 'testimonials_name', true);
?>
<div class="testimonials-v6">
    <div class="testimonials-body">
        <div class="testimonials-title"><?php the_title();?></div>
        <p class="testimonials-description"><?php the_content() ?></p>                            
        <ul class="testimonials-avatar list-unstyled">
            <li class="active">
                 <div class="radius-x"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?></div>
            </li>                       
        </ul>                        
        <h5 class="testimonials-name"><?php echo trim($name); ?></h5> 
        <div class="job"><?php echo trim($job); ?></div>  
    </div>                      
</div>