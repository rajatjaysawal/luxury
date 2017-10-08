$(document).ready(function() {
	var nav_list = $('.widget_shopping_cart_content');
	$('.mini-cart').on("click", function(event) {
		event.stopPropagation();
		nav_list.toggleClass('open');
		$('body').toggleClass('cart_active');
	});

	$("#close").on("click", function() {
		$('body').removeClass('cart_active');
		nav_list.removeClass('open');
	});
});