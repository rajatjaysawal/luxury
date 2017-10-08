<?php
/**
 * The Footer Sidebar
 *
 * @package ENGOTHEME
 * @subpackage Nemi
 * @since @uickmart 1.0
 */

?>
 
		<div class="container">
			<section class="footer-bottom">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
						<?php if ( is_active_sidebar( 'footer-logo' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="200ms" >
							<?php dynamic_sidebar('footer-logo'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
						<?php if ( is_active_sidebar( 'footer-menu' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="400ms" >
							<?php dynamic_sidebar('footer-menu'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
						<?php if ( is_active_sidebar( 'footer-social' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="600ms" >
							<?php dynamic_sidebar('footer-social'); ?>
						</div>
						<?php endif; ?>
					</div>

				</div>
			</section>
		</div>
 