<?php
/* Template Name: PageDemo */

/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header();

$listProduct = get_list_product();

$productPrice = get_product_price(13);

// if (isset($_POST['submit-value'])){
// 	 payment_method();
// }

$url = get_template_child_directory();

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<h1>This new content</h1>

		<a href="https://buy.stripe.com/test_6oEbIRfKofT07EQ6oo">Purchase</a>

		<form method="POST">
			<input id="btn-submit" type="submit" name="submit-value" value="submit">
			<!-- <button id="btn-submit">Submit</button> -->
		</form>

		<form action="<?=$url?>/create-checkout-session.php" method="POST">
			<button type="submit">Checkout</button>
		</form>

		<form method="POST">
			<input id="payment" type="submit" name="" value="Payment">
			<!-- <button id="btn-submit">Submit</button> -->
		</form>
	</main><!-- #main -->
</div><!-- #primary -->





<?php
echo do_shortcode('[jsshortcode]');

do_action('storefront_sidebar');
get_footer();
