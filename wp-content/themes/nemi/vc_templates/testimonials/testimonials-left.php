<?php 
	$job = get_post_meta( get_the_ID(), 'testimonials_job', true); 
	$name = get_post_meta( get_the_ID(), 'testimonials_name', true);
?>
<div class="testimonials-wrap">
<div class="testimonials-body">
	<div class="testimonials-title"><?php the_title();?></div>
    <div class="testimonials-quote"><?php the_content() ?></div>
    <div class="testimonials-profile">
        <div class="testimonials-avatar">
            <?php the_post_thumbnail('widget', '', 'class="radius-x"');?>
        </div> 
        <h4 class="name"> <?php echo trim($name); ?></h4>
        <div class="job"><?php echo trim($job); ?></div>
    </div>                    
</div>
</div>