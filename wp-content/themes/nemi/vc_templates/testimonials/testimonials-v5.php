<?php 
	$job = get_post_meta( get_the_ID(), 'testimonials_job', true); 
	$name = get_post_meta( get_the_ID(), 'testimonials_name', true);
?>
<div class="testimonials-wrap">
	<div class="testimonials-body text-center">
	    <div class="testimonials-description"><?php the_content() ?></div>
	    <h4 class="testimonials-name"><?php echo trim($name); ?></h4>  
	    <div class="job"><?php echo trim($job); ?></div>
	</div>
	
</div>