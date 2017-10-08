<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>
<?php if($show_facebook || $show_instagram || $show_google_plus || $show_youtube || $show_tumblr || $show_pinterest || $show_linkedIn || $show_twitter ): ?>
<div class="widget-social widget<?php echo esc_attr($el_class); ?>">
	<?php if( !empty( $title)): ?>
		<h3 class="wpb_heading">
			<span><?php echo esc_attr($title);?></span>
		</h3>
	<?php endif; ?>
	
	<?php if( $style =='style-1') : ?>
		<ul class="social list-unstyled style-v1 ">
		<?php if($show_facebook): ?>
			<li>
				<a class="facebook-social" href="<?php echo esc_url($link_facebook);?>"  target="_blank" >
					<i class="fa fa-facebook"></i> 
				</a>
				<?php esc_html_e( 'facebook', 'nemi'); ?>
			</li>
		<?php endif; ?>	
		<?php if($show_instagram): ?>
			<li>
				<a class="instagram-social" href="<?php echo esc_url($link_instagram);?>"  target="_blank" >
					<i class="fa fa-instagram"></i> 
				</a>
				<?php esc_html_e( 'instagram', 'nemi'); ?>
			</li>
		<?php endif; ?>	
		<?php if($show_youtube): ?>
			<li>
				<a href="<?php echo esc_url($link_youtube);?>"  target="_blank">
					<i class="fa fa-youtube-play"></i>
				</a>
				<?php esc_html_e( 'youtube', 'nemi'); ?>
			</li>
		<?php endif; ?>	 
		<?php if($show_twitter): ?>
			<li>
				<a class="twitter-social" href="<?php echo esc_url($link_twitter);?>"  target="_blank">
					<i class="fa fa-twitter"></i> 
				</a>
				<?php esc_html_e( 'twitter', 'nemi'); ?>
			</li>
		<?php endif; ?>		
		<?php if($show_tumblr): ?>
			<li>
				<a class="tumblr-social" href="<?php echo esc_url($link_tumblr);?>"  target="_blank">
					<i class="fa fa-tumblr"></i> 
				</a>
				<?php esc_html_e( 'tumblr', 'nemi'); ?>
			</li>
		<?php endif; ?>	
		<?php if($show_google_plus): ?>
			<li>
				<a href="<?php echo esc_url($link_google_plus);?>"  target="_blank">
					<i class="fa fa-google-plus"></i> 
				</a>
				<?php esc_html_e( 'google +', 'nemi'); ?>
			</li>
		<?php endif; ?>			
		<?php if($show_pinterest): ?>
			<li>
				<a href="<?php echo esc_url($link_pinterest);?>"  target="_blank" >
					<i class="fa fa-pinterest"></i>
				</a>
				<?php esc_html_e( 'pinterest', 'nemi'); ?>
			</li>
		<?php endif; ?>	
			<?php if($show_linkedIn): ?>
				<li><a href="<?php echo esc_url($link_linkedIn);?>"  target="_blank">
						<i class="fa fa-linkedin"></i>
					</a>
					<?php esc_html_e( 'linkedin', 'nemi'); ?>
				</li>
			<?php endif; ?>	
		</ul>
	
	<?php else: ?>
		<ul class="social list-unstyled bo-sicolor social-circle style-v2">
		<?php if($show_facebook): ?>
			<li>
				<a class="facebook" href="<?php echo esc_url($link_facebook);?>"  target="_blank" >
					<i class="fa fa-facebook"></i>
					<span><?php esc_html_e( 'Facebook', 'nemi'); ?></span>
				</a>
			</li>
		<?php endif; ?>	
		<?php if($show_instagram): ?>
			<li>
				<a class="instagram-social" href="<?php echo esc_url($link_instagram);?>"  target="_blank" >
					<i class="fa fa-instagram"></i> 
				</a>
				<span><?php esc_html_e( 'instagram', 'nemi'); ?></span>				
			</li>
		<?php endif; ?>	
		<?php if($show_youtube): ?>
			<li>
				<a href="<?php echo esc_url($link_youtube);?>"  target="_blank">
					<i class="fa fa-youtube-play"></i>
				</a>
				<span><?php esc_html_e( 'youtube', 'nemi'); ?></span>				
			</li>
		<?php endif; ?>	 
		<?php if($show_twitter): ?>
			<li>
				<a class="twitter" href="<?php echo esc_url($link_twitter);?>"  target="_blank">
					<i class="fa fa-twitter"></i>
					<span><?php esc_html_e( 'Twitter', 'nemi'); ?></span>
				</a>
			</li>
		<?php endif; ?>	
		<?php if($show_tumblr): ?>
			<li>
				<a class="tumblr-social" href="<?php echo esc_url($link_tumblr);?>"  target="_blank">
					<i class="fa fa-tumblr"></i> 
				</a>
				<span><?php esc_html_e( 'tumblr', 'nemi'); ?></span>				
			</li>
		<?php endif; ?>		
		<?php if($show_google_plus): ?>
			<li>
				<a  class="google-plus" href="<?php echo esc_url($link_google_plus);?>"  target="_blank">
					<i class="fa fa-google-plus"></i>
					<span><?php esc_html_e( 'Google plus', 'nemi'); ?></span>
				</a>
			</li>
		<?php endif; ?>	
		<?php if($show_pinterest): ?>
			<li>
				<a class="pinterest" href="<?php echo esc_url($link_pinterest);?>"  target="_blank" >
					<i class="fa fa-pinterest"></i>
					<span><?php esc_html_e( 'Pinterest', 'nemi'); ?></span>
				</a>
			</li>
		<?php endif; ?>	
		<?php if($show_linkedIn): ?>
			<li>
				<a class="linkedin" href="<?php echo esc_url($link_linkedIn);?>"  target="_blank">
					<i class="fa fa-linkedin"></i>
					<span><?php esc_html_e( 'Linkedin', 'nemi'); ?></span>
				</a>
			</li>
		<?php endif; ?>	
		</ul>
	<?php endif;?>
</div>
<?php endif; ?>