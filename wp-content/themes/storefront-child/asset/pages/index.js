import WooCommerceRestApi from "@woocommerce/woocommerce-rest-api"; // Supports ESM

const WooCommerce = new WooCommerceRestApi({
  url: 'https://example.com',
  consumerKey: 'consumer_key',
  consumerSecret: 'consumer_secret',
  version: 'wc/v3',
  queryStringAuth: true // Force Basic Authentication as query string true and using under HTTPS
});

console.log(WooCommerce);

console.log(123);

// const stripe = Stripe('pk_test_51M9L1TAguxiPvYxjsmddqPaC97DxpMh4neE3p2WMhfDNM7hpvAEbhWvkRPjkuCbBdpLbtFDu06RgqV0Zs8PdmL7600p9XTlvjq', {
//     apiVersion: "2022-11-15",
//   });


//   const paymentRequest = stripe.paymentRequest({
//     country: 'US',
//     currency: 'usd',
//     total: {
//       label: 'Demo total',
//       amount: 1099,
//     },
//     requestPayerName: true,
//     requestPayerEmail: true,
//   });

//   const elements = stripe.elements();
// const prButton = elements.create('paymentRequestButton', {
//   paymentRequest,
// });

// (async () => {
//   // Check the availability of the Payment Request API first.
//   const result = await paymentRequest.canMakePayment();
//   if (result) {
//     prButton.mount('#payment-request-button');
//   } else {
//     document.getElementById('payment-request-button').style.display = 'none';
//   }
// })();
