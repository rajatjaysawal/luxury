<?php 
	$job = get_post_meta( get_the_ID(), 'testimonials_job', true); 
	$name = get_post_meta( get_the_ID(), 'testimonials_name', true);
?>
<div class="testimonials-wrap">
	
	<div class="testimonials-body">
		<div class="testimonials-title"><?php the_title();?></div>
	    <div class="testimonials-description"><?php the_content() ?></div>                
	    <div class="testimonials-avatar radius-x">
	        <a href="#"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?></a>
	    </div>
	    <div class="testimonials-meta">
		    <h5 class="testimonials-name">
		        <?php echo trim($name); ?>
		    </h5>  
		    <div class="job"><?php echo trim($job); ?></div> 
		</div>          
	</div>
</div>