<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}
$count =  $product->get_review_count() ;

$counts = nemi_fnc_get_review_counting();

$average  = $product->get_average_rating();

?>

<div id="reviews"  class="widget-reviews">
 
<!-- <h3 class="heading-reviews" ><span><?php esc_html_e('Reviews', 'nemi'); ?></span></h3> -->
 
<div class="comments-content">
	<div class="reviews-summary">
		<div class="row">
			<div class="col-md-7 media">
				<h5><?php esc_html_e('Customers review', 'nemi'); ?></h5>
				<div class="review-summary-total pull-left">
					<div class="review-summary-result">
						<strong><?php echo floatval($average); ?></strong>
					</div>
					<?php printf( esc_html__( '%s ratings', 'nemi'),$count )  ; ?>
				</div>	
				<div class="media-body"><div class="review-summary-detal ">
					<?php foreach( $counts as $key => $value ):  $pc = ($count == 0 ? 0: ( ($value/$count)*100  ) ); ?>
						<div class="review-summery-item row">
							<div class="col-lg-1"></div>
							<div class="review-label col-lg-2"> <?php echo trim($key); ?> <?php esc_html_e('Star', 'nemi'); ?></div> 
							<div class="col-lg-8">	
								<div class="progress">
								  <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($pc);?>%;">
								    <?php echo round($pc,2);?>%
								  </div>
								</div>
							</div>	
					 

						</div>
					<?php endforeach; ?>
				</div></div>		
			</div>
			<div class="col-md-5 media">
				<h5><?php esc_html_e('Rate it!', 'nemi'); ?></h5>
				<div class="pull-left">
					<div class="icon-star"></div>
				</div>
				<div class="media-body">
					<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'nemi' ); ?></p>
					<a href="#review_form_wrapper" class="btn btn-default btn-block radius-5x" rel="nofollow"><?php esc_html_e('Write A Review', 'nemi'); ?></a>
				</div>	


			</div>
		</div>
	</div>	

	<div id="comments" class="comments">
		<h5><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( _n( '%s review for %s', '%s reviews for %s', $count, 'nemi' ), $count, get_the_title() );
			else
				esc_html_e( 'Reviews', 'nemi' );
		?></h5>

		<?php if ( have_comments() ) : ?>

			<ul class="commentlist list-unstyled">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'nemi' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<div id="review_form_wrapper" class="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'nemi' ) : esc_html__( 'Be the first to review', 'nemi' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'nemi' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author form-group">' . '<label for="author" class="control-label">' . esc_html__( 'Name', 'nemi' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email form-group"><label for="email" class="control-label">' . esc_html__( 'Email', 'nemi' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => esc_html__( 'Submit', 'nemi' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating form-group clearfix">
						<label for="rating" class="control-label">' . esc_html__( 'Your Rating', 'nemi' ) .'</label>
						<select name="rating" id="rating">
						<option value="">' . esc_html__( 'Rate&hellip;', 'nemi' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'nemi' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'nemi' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'nemi' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'nemi' ) . '</option>
						<option value="1">' . esc_html__( 'Very Poor', 'nemi' ) . '</option>
						</select></p>';
					}


					$comment_form['comment_field'] .= '<p class="comment-form-comment form-group"><label class="control-label" for="comment">' . esc_html__( 'Your Review', 'nemi' ) . '</label><textarea id="comment"  class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

	
	<?php endif; ?>

	<div class="clear"></div>
</div>
</div>