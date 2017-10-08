<?php 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$args = array(
	'post_type' => 'team',
	'posts_per_page'=> $number
);

$loop = new WP_Query($args);

switch ($columns_count) {
	case '6': 
		$class_column = 'col-lg-2 col-md-4 col-sm-6 col-xs-12';
		break;
	case '4':
		$class_column='col-md-3 col-sm-6';
		break;
	case '3':
		$class_column='col-md-4 col-sm-12';
		break;
	case '2':
		$class_column='col-md-6 col-sm-6';
		break;
	default:
		$class_column='col-md-12 col-sm-12';
		break;
}

?>
<div class="widget widget-team">
	<?php if( $title ){ ?> 
			<h3 class="widget-title">
		       <span><?php echo trim($title); ?></span>
			</h3>
	<?php } ?>
	<div class="widget-content">
		<div class="row">
			<?php while( $loop->have_posts() ): $loop->the_post();

				$data = array( 'google', 'job', 'phone_number', 'facebook', 'twitter', 'pinterest' );
				$info = array();
				foreach( $data as $item ){
					$info[$item] =  get_post_meta( get_the_ID(), 'team_'.$item, true ); 
				}
			?>
			<div class="<?php echo esc_attr( $class_column); ?>">

				<div class="team-item">
				    <div class="team-image">
				      <a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?> </a>
				    </div>     
				    <div class="team-body text-center">
				        <div class="team-body-content">
				            <h3 class="team-name"><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a></h3>
				            <p class="team-job"><?php echo esc_html( $info['job'] ); ?></p>
				        </div>      
				        <div class="team-social">
				        	<?php if( $info['facebook'] ){  ?>
							<a class="facebook" href="<?php echo esc_url( $info['facebook'] ); ?>"> <i  class="fa fa-facebook"></i> </a>
								<?php } ?>
							<?php if( $info['twitter'] ){  ?>
							<a class="twitter" href="<?php echo esc_url( $info['twitter'] ); ?>"><i  class="fa fa-twitter"></i> </a>
							<?php } ?>
							<?php if( $info['pinterest'] ){  ?>
							<a class="pinterest" href="<?php echo esc_url( $info['pinterest'] ); ?>"><i  class="fa fa-pinterest"></i> </a>
							<?php } ?>
							<?php if( $info['google'] ){  ?>
							<a class="google" href="<?php echo esc_url( $info['google'] ); ?>"> <i  class="fa fa-google"></i></a>
							<?php } ?>		                              
				        </div>                        
				    </div>  
				   <!--  <div class="team-info">
				        <?php the_excerpt(); ?>
				    </div>   -->                                    
				</div>
			</div>	
			<?php endwhile; ?>
		</div>	
	</div>
</div>	
<?php wp_reset_postdata(); ?>