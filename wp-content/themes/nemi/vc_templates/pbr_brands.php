<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Engotheme Team <engotheme@gmail.com>
 * @copyright  Copyright (C) 2017 engotheme.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://engotheme.com
 * @support  http://engotheme.com.
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$_id = nemi_fnc_makeid();
$args = array(
	'post_type' => 'brands',
	'posts_per_page'=> $number
);
$loop = new WP_Query($args);
if ( $loop->have_posts() ) :
	$_count = 1;
?>
	<div class="widget widget-brand-logo<?php echo (($el_class!='')?' '.esc_attr( $el_class ):''); ?>">
		<?php if(!empty($title)){ ?>
			<h4 class="wpb_heading">
				<span><?php echo trim($title); ?></span>
				<?php if(trim($descript)!=''){ ?>
		            <span class="widget-desc">
		                <?php echo trim($descript); ?>
		            </span>
		        <?php } ?>
			</h4>
		<?php } ?>

		<div class="widget-content">
		<?php if ( $style == 'carousel' ): ?>
			<div class="widget-brands-inner owl-carousel-play" id="productcarouse-<?php echo esc_attr($_id); ?>" data-ride="owlcarousel">
				<?php if( $loop->post_count > $columns_count ) { ?>
					<div class="carousel-controls carousel-controls-v2 carousel-hidden">
						<a href="#productcarouse-<?php echo esc_attr($_id); ?>" data-slide="prev" class="left carousel-control carousel-md">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#productcarouse-<?php echo esc_attr($_id); ?>" data-slide="next" class="right carousel-control carousel-md">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				<?php } ?>
				<div class="owl-carousel" data-slide="<?php echo esc_attr($columns_count); ?>" data-singleItem="true" data-navigation="true" data-pagination="false">
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<?php   echo '<div class="item">'; ?>
						<?php
							$link = get_post_meta(get_the_ID(),'brands_brank_link',true);
							$link = $link ? $link : '#';
						?>
						<!-- Product Item -->
						<div class="item-brand text-center">
							<a href="<?php echo esc_url($link); ?>" target="_blank" title="<?php the_title(); ?>">
								<?php the_post_thumbnail( 'brand-logo' ); ?>
							</a>
						</div>
						<!-- End Product Item -->

					<?php echo '</div>'; ?>
					<?php $_count++; ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				</div>
			</div>
		<?php else: ?>
		<?php
			$_count = 0;
			$col = floor(12/$columns_count);
        	$smcol = ($col > 4)? 6: $col;
        	$class_column ='col-lg-'.$col.' col-md-'.$col.' col-sm-'.$smcol. ' col-xs-12';
		?>

			<div class="widget-brands-inner">
				<?php while ( $loop->have_posts() ) : $loop->the_post();?>
					<?php if($_count%$columns_count==0): ?>
						<div class="row">
					<?php endif; ?>
						<div class="item <?php echo esc_attr( $class_column); ?>">
							<?php
								$link = get_post_meta(get_the_ID(),'brands_brank_link',true);
								$link = $link ? $link : '#';
							?>
							<!-- Product Item -->
							<div class="item-brand text-center">
								<a href="<?php echo esc_url($link); ?>" target="_blank">
									<?php the_post_thumbnail( 'brand-logo' ); ?>
								</a>
							</div>
							<!-- End Product Item -->

						</div>
					<?php if($_count%$columns_count==$columns_count-1 || $_count==$loop->post_count-1): ?>
						</div>
					<?php endif; ?>
					<?php $_count++; ?>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		</div>

	</div>
<?php endif; ?>