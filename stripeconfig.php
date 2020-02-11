<?php
    require_once "stripe-php-master/init.php";


	$stripeDetails = array(
		"secretKey" => "sk_test_IJwQs6mA0FCdhcUVL8RGYo8900wNsILu40",
		"publishableKey" => "pk_test_W20HElwGRLvWc26WxWczuwFc00mqQ67ey8"
	);

	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here: https://dashboard.stripe.com/account/apikeys
	\Stripe\Stripe::setApiKey($stripeDetails['secretKey']);
?>
