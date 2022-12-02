<?php
require_once ABSPATH . '/vendor/stripe-php/init.php';
require_once ABSPATH . '/vendor/autoload.php';


add_action('wp_enqueue_scripts', 'enqueue_parent_styles');
function enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

function get_template_child_directory()
{
    $template     = 'storefront-child';
    $theme_root   = get_theme_root_uri($template);
    $template_dir = "$theme_root/$template";

    return apply_filters('template_directory', $template_dir, $template, $theme_root);
}



function init_your_gateway_class()
{
    class WC_Gateway_Your_Gateway extends WC_Payment_Gateway {}
    $stripe = new \Stripe\StripeClient(SECRET_KEY);
}
add_action('woocommerce_init', 'init_your_gateway_class');

function add_your_gateway_class( $methods ) {
    $methods[] = 'WC_Gateway_Your_Gateway'; 
    return $methods;
}

add_filter( 'woocommerce_payment_gateways', 'add_your_gateway_class' );



function get_list_product(): ?array
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1
    );
    $loop = new WP_Query($args);


    $listIdProduct = get_posts(array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
    ));

    return $listIdProduct;
}

function get_product_price(int $productId): ?int
{
    $product = new WC_Product($productId);

    return intval($product->get_price());
}

function payment_js_shortcode()
{
    $baseUrl = get_template_child_directory();
    $path = '/asset/pages/index.js';

    return '<script type="text/javascript" src="' . $baseUrl . $path . '"></script>';
}
add_shortcode('js_shortcode', 'payment_js_shortcode');




// ====================================================
// \Stripe\Stripe::setApiKey(SECRET_KEY);

// $intent = \Stripe\PaymentIntent::create([
//   'amount' => 1099,
//   'currency' => 'thb',
// ]);




// *****************************
\Stripe\Stripe::setApiKey(SECRET_KEY);

$applePayDomain = \Stripe\ApplePayDomain::create([
  'domain_name' => 'example.com',
]);

var_dump($applePayDomain);






wp_enqueue_script('main', plugins_url('js/jquery.main.js'), array('jquery'), '', true);

wp_localize_script('main', 'ipAjaxVar', array(
    'ajaxurl' => admin_url('admin-ajax.php')
));


function hook_payment_ajax()
{
    wp_enqueue_script('script-checker', plugin_dir_url(__FILE__) . 'js/script-checker.js');
    wp_localize_script(
        'script-checker',
        'ipAjaxVar',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'fail_message' => __('Connection to server failed. Check the mail credentials.', 'script-checker'),
            'success_message' => __('Connection successful. ', 'script-checker')
        )
    );
    // wp_enqueue_script('script-checker', plugins_url('js/jquery.main.js'), array('jquery'), '', true);
    // wp_localize_script('script-checker', 'ipAjaxVar', array(
    //     'ajaxurl' => admin_url('admin-ajax.php')
    // ));
}
add_action('enqueue_scripts', 'hook_payment_ajax');
add_action('admin_enqueue_scripts', 'hook_payment_ajax');



// Create customer
function create_customer()
{
    $stripe = new \Stripe\StripeClient(SECRET_KEY);

    return $stripe->customers->create([
        'description' => 'My First Test Customer (created for API docs at https://www.stripe.com/docs/api)',
    ]);
}

// Checkout
function create_checkout(){
    $stripe = new \Stripe\StripeClient(SECRET_KEY);

    // $checkout = $stripe->checkout->sessions->create([
    //     'success_url' => 'https://example.com/success',
    //     'cancel_url' => 'https://example.com/cancel',
    //     'line_items' => [
    //       [
    //         'price' => 10,
    //         'quantity' => 2,
    //       ],
    //     ],
    //     'mode' => 'payment',
    //   ]);

    $prices =  $stripe->prices->all(['limit' => 3]);
    $products = $stripe->products->all(['limit' => 3]);

      var_dump($products);



}

use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

// Create order
function create_order(){

    $woocommerce = new Client(
        'https://example.com',
        'consumer_key',
        'consumer_secret',
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'query_string_auth' => true // Force Basic Authentication as query string true and using under HTTPS
        ]
    );

    var_dump($woocommerce);

}


// Call payment method
function payment_method_ajax()
{
    try {
        //code...
        create_order();

        $customer = create_customer();
        // $invoice = create_invoice_item($customer->id);
        $checkout = create_checkout();
        // var_dump($invoice);
        // pay_an_invoice($invoice);
    } catch (\Throwable $th) {
        var_dump(4444);
        var_dump($th);
    }

    $stripe = new \Stripe\StripeClient(SECRET_KEY);

    $response = $stripe->paymentMethods->create([
        'type' => 'card',
        'card' => [
            'number' => '4242424242424242',
            'exp_month' => 11,
            'exp_year' => 2023,
            'cvc' => '314',
        ],
    ]);

}
add_action('wp_ajax_nopriv_payment_method_ajax', 'payment_method_ajax');
add_action('wp_ajax_payment_method_ajax', 'payment_method_ajax');


add_action('wp_enqueue_scripts', function () {
    wp_localize_script('jquery', 'config_secret_key', SECRET_KEY);
});

add_action('wp_enqueue_scripts', function () {
    wp_localize_script('jquery', 'config_public_key', PUBLISHABLE_KEY);
});
// ====================================================






// function get_product_by_id(int $id):object{
//     $args = array(
//         'post_type' => 'product',
//         'ids' => '13'
//     );
//     $product = new WP_Query($args);

//     return $product;
// }

// function get_active_subscribers_ids()
// {
//     global $wpdb;

//     // Return an array of user Ids active subscribers
//     return $wpdb->get_col("
//         SELECT DISTINCT pm.meta_value
//         FROM {$wpdb->prefix}posts as p
//         JOIN {$wpdb->prefix}postmeta as pm
//             ON p.ID = pm.post_id
//         WHERE p.post_type = 'shop_subscription'
//         AND p.post_status = 'wc-active'
//         AND pm.meta_key = '_customer_user'
//     ");
// }
