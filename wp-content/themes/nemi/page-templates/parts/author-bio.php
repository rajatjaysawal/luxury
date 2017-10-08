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
?>

<div class="author-info">

	<div class="author-about-container media">
		<div class="avatar-img pull-left">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ),90 ); ?>
		</div>
		<!-- .author-avatar -->
		<div class="description media-body">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h4 class="author-title">
						<?php esc_html_e( 'Post by ', 'nemi' ); ?>
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
							<?php echo get_the_author(); ?>
						</a>
					</h4>
					<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
				</div>
			</div>
			
		</div>
		
	</div>
</div>