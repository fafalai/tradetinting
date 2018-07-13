<?php
    require_once "stripe-php-master/init.php";
   

	$stripeDetails = array(
		"secretKey" => "sk_test_V0oPAcqML1GLnB6WnRKSwWHV",
		"publishableKey" => "pk_test_iGsAvPJtLoZmJPd1cwFZ2wES"
	);

	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here: https://dashboard.stripe.com/account/apikeys
	\Stripe\Stripe::setApiKey($stripeDetails['secretKey']);
?>