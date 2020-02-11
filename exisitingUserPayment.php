<?php
    require_once "stripeconfig.php";
    include("remedyshared.php");
    include("remedyuuid.php");
    require_once("remedyerrcodes.php");
    SharedInit();

    \Stripe\Stripe::setVerifySslCerts(false);
    \Stripe\Stripe::setApiKey("sk_test_IJwQs6mA0FCdhcUVL8RGYo8900wNsILu40");

	// Token is created using Checkout or Elements!
	// Get the payment token ID submitted by the form:

	// if (!isset($_POST['stripeToken'])) {
	// 	header("Location: signup.php");
	// 	exit();
    // }
    
    //echo "<pre>";
    //var_dump($_POST);
    // exit();
    //$plan = SharedCleanString($_POST['plan_opt'],AT_MAXADDRESS);
	/* Used period from the database to store the plan option. if it is a free trial, 0; annual plan, 12; 3 years plan, 36*/
	$signupmsg = "";
    $dblink = SharedConnect();
	$c_id=$_SESSION['custid'];
	$dbselect = "select " .
	"u1.id, " .
	"u1.uuid " .
	"from " .
	"users u1 " .
	"where " .
	"u1.cust_id='$c_id'";

	if ($dbresult = SharedQuery($dbselect, $dblink)){

		if ($numrows = SharedNumRows($dbresult)){
			while ($dbrow = SharedFetchArray($dbresult))
			{
				$uid = $dbrow['id'];
				$useruuid = $dbrow['uuid'];
			}
		}else{
		error_log("error");
	  }
	}else{
	  error_log("error");
	}
	
    $notification = 0;
    $signemail = "";
	$stripe_customer_id = null;   
    $token = $_POST['stripeToken'];
	$email = $_POST["stripeEmail"];
	$plan = SharedCleanString($_POST['plan_opt'],AT_MAXADDRESS);//This is for knowing how many users this customer could create, the numberUsers column in user table

	// error_log("uuid".$useruuid."-----------uid".$uid);
	
	if($plan == 99)
    {
        $period = 12;
		$numberUsers = 5;
		$description = "Annual Plan";
    }
    else if ($plan == 250)
    {
        $period = 36;
		$numberUsers = 5;
		$description = "3 Years Plan";
    }
    if ($token != null && $email != null)
    {
        //1. create the customer in Stripe first
        $customer = \Stripe\Customer::create(array(
            'card' => $token,
            'email' => $email
            )
        );
        // error_log($customer);
        // $stripe_customer_id = $customer->id;
        // error_log($stripe_customer_id);
        //2. Charge the user's card:
        $charge = \Stripe\Charge::create(array(
            "amount" =>($plan*100),
            "currency" => "usd",
            "description" => $description,
            "customer" => $customer->id
            //"source" => $token
        ));
        if($charge->paid === true)
        {
			$dbupdate = "update " .
                "users " .
                "set " .
                "numberUsers=" . $numberUsers .", ". 
				"period=" . $period . " " .
                "where " .
				"cust_id=" . $c_id;
			if(	SharedQuery($dbupdate, $dblink)){
				if($token != null && $email != null)
				{
					$stripeid = $customer ->id;
					error_log("the stripe id for the customer is ". $stripeid);
					$paymentid = $charge ->id; 
					$datecreated = date("Y-m-d H:i:s", $charge->created);
					error_log($datecreated);
					$cardid = $charge ->source ->fingerprint;
					error_log("the card id ".$cardid);
					$amount = ($charge ->amount)/100;
					error_log("the charge amount is ". $amount);
					$currency = $charge ->currency;
					error_log("the currecy is ".$currency); 
					$description = $charge ->description;
					error_log("the description is ".$description);
					$dbtransactioninsert = "INSERT INTO transactions ".
											"(" .
											"cust_id," .
											"user_id," .
											"stripe_id," .
											"payment_id," .
											"date_created," .
											"card_id," .
											"amount," .
											"currency," .
											"description" .
											") " .
											"VALUES " .
											"(" .
											"'$c_id'," .
											"'$uid'," .
											"'$stripeid'," .
											"'$paymentid'," .
											"'$datecreated'," .
											"'$cardid'," .
											"'$amount'," .
											"'$currency'," .
											"'$description'" .
											")";
					// error_log($dbtransactioninsert);
					if (SharedQuery($dbtransactioninsert, $dblink))
					{
						// error_log(strtotime($charge->created,'+5 years'));
						if($period == 12){
						
							$newDate = strtotime('+1 years',$charge->created);
						}elseif($period == 36){
							$newDate = strtotime('+3 years',$charge->created);
						}
						$licexpired = date("Y-m-d H:i:s", $newDate);
						
						$dbupdate = "update " .
							"users " .
							"set " .
							"licexpired=" . "'$licexpired'" ." ". 
							"where " .
							"cust_id=" . $c_id;

						error_log($dbupdate);
						if(	SharedQuery($dbupdate, $dblink)){
							$notification = 1;
							$signupmsg =  "You have subscribe successfully. Directing you back to Subscription Page.";
						}
						else
						{
							$notification = 2;
							$signupmsg = "Unable to subscribe Please try again or contact support.";
						}
					}
					else
					{
						$notification = 2;
						$signupmsg = "Unable to subscribe Please try again or contact support.";
					}
				}
			}else{
				$notification = 2;
				$signupmsg = "Unable to subscribe Please try again or contact support.";
			}
		}
		else
		{
			//could not insert into transations table
			$notification = 2;
			$signupmsg = "Unable to subscribe Please try again or contact support.";
		}
	}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
            require_once("meta.php");
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                var message = "";
                var notification = "";
                message = "<?php if ($signupmsg != "") echo $signupmsg; else echo 123;?>";
                notification = "<?php if ($notification != "") echo $notification; else echo 123;?>";
                console.log(message);
                console.log(notification);
                if (notification == 1) {
                    noty({
                        text: message,
                        type: 'success',
                        timeout: 6000
                    });
                    setTimeout(() => {
                        // window.location.replace("/tradetinting/subscription.php");// for local path
                        window.location.replace("/subscription.php"); // for production path
                    }, 3000);
                } else if (notification == 2) {
                    noty({
                        text: message,
                        type: 'error',
                        timeout: 3000
                    });
                    setTimeout(() => {

                        // window.location.replace("/tradetinting/subscription.php");// for local path
                        window.location.replace("/subscription.php");// for production path
                    }, 2000);
                }
            });

            function loading()
            {
                // noty({
                //         text: "Creating Your account, please wait",
                //         type: 'info',
                //         timeout: 1000
                //     });
            }
        </script>
    <title>Payment</title>
    </head>
    <body>
    </body>
</html>