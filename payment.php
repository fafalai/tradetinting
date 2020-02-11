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
    $dblink = SharedConnect();
    $signupmsg = "";
    $notification = 0;
    $signuid = "";
    $signname = "";
    $signpwd = "";
    $signmobile = "";
    $signemail = "";
    $address = "";
    $city = "";
    $state = "";
    $city = "";
    $country = "";
    $period = 0;
    $numberUsers = 0;
    $stripe_customer_id = null;
	// //send an email
    // //store information to the database

    //error_log($_POST);
   
    $token = $_POST['stripeToken'];
    $email = $_POST["stripeEmail"];
    $address = SharedCleanString($_POST['sign_address'],AT_MAXADDRESS);
    $city = SharedCleanString($_POST['sign_city'],AT_MAXADDRESS);
    $state = SharedCleanString($_POST['sign_state'],AT_MAXADDRESS);
    $city = SharedCleanString($_POST['sign_city'],AT_MAXADDRESS);
    $country = SharedCleanString($_POST['sign_country'],AT_MAXADDRESS);
    $plan = SharedCleanString($_POST['plan_opt'],AT_MAXADDRESS);//This is for knowing how many users this customer could create, the numberUsers column in user table
    if($plan == 99)
    {
        $period = 12;
        $numberUsers = 5;
    }
    else if ($plan == 250)
    {
        $period = 36;
        $numberUsers = 5;
    }
    error_log($period);
    error_log($numberUsers);
    $description = SharedCleanString($_POST['description'],AT_MAXADDRESS);
    error_log("address: " . $address);
    error_log("state: ". $state);
    error_log("city: " . $city);
    error_log("country: ". $country);
    error_log("selected plan: " . $plan);
    error_log($token);
    error_log($email);
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
        //error_log($charge->created);
       
        //error_log($charge);
        // error_log($charge->source);
        // $stripeid = $customer ->id;
        // error_log("the stripe id for the customer is ". $stripeid);
        // $paymentid = $charge ->id; 
        // $datecreated = date("Y-m-d H:i:s", $charge->created);
        // error_log($datecreated);
        // $cardid = $charge ->source ->fingerprint;
        // error_log("the card id ".$cardid);
        // $amount = ($charge ->amount)/100;
        // error_log("the charge amount is ". $amount);
        // $currency = $charge ->currency;
        // error_log("the currecy is ".$currency); 
        // $description = $charge ->description;
        // error_log("the description is ".$description);
        //check wether payment is successfull 
        if($charge->paid == true)
        {
            //1st, create a new cust with the uuid
            $custuuid = RemedyUuid();
            $dbinsertcust = "INSERT INTO cust ".
                        "(" .
                        "uuid,".
                        "address,".
                        "city,".
                        "state,".
                        "postcode,".
                        "country".
                        ") ".
                        "VALUES ".
                        "(" .
                        "'$custuuid',".
                        "'$address',".
                        "'$city',".
                        "'$state',".
                        "'$city',".
                        "'$country'".
                        ")";
            // error_log($dbinsert);
            error_log("creating a new cust");
            error_log($dbinsertcust);
            if (SharedQuery($dbinsertcust, $dblink))
            {
            //2nd Successful create the cust, use the uuid to get the id. 
            $dbcustselect = "select ".
                        "c1.id ".
                        "from ".
                        "cust c1 ".
                        "where ".
                        "c1.uuid='$custuuid'";
                error_log($dbcustselect);
                if ($dbcustresult = SharedQuery($dbcustselect,$dblink))
                {
                    if ($numrows = SharedNumRows($dbcustresult))
                    {
                        while($dbcustrow = SharedFetchArray($dbcustresult))
                        {
                            //3rd, use the cust id to create the user
                            $custid = $dbcustrow['id'];
                            error_log("the new customer id is ");
                            error_log($custid);
                            $useruuid = RemedyUuid();
                            error_log("the new user uuid");
                            error_log($useruuid);
                            $signuid = SharedCleanString($_POST['sign_id'],AT_MAXNAME);
                            $signname = SharedCleanString($_POST['sign_name'],AT_MAXNAME);
                            $signpwd = SharedCleanString($_POST['sign_password'],AT_MAXPWD);
                            $signmobile = SharedCleanString($_POST['sign_phone'],AT_MAXPHONE);
                            $signemail = SharedCleanString($_POST['sign_email'],AT_MAXEMAIL);

                            $dbuserinset = "INSERT INTO users ".
                                            "(" .
                                            "cust_id," .
                                            "uid," .
                                            "pwd," .
                                            "uuid," .
                                            "stripe_id," .
                                            "users.name," .
                                            "email," .
                                            "mobile," .
                                            "numberUsers," .
                                            "period," .
                                            "users.admin," .
                                            "active," . 
                                            "monthValue".
                                            ") " .
                                            "VALUES " .
                                            "(" .
                                            "'$custid'," .
                                            "'$signuid'," .
                                            "'$signpwd'," .
                                            "'$useruuid'," .
                                            "'$stripe_customer_id'," .
                                            "'$signname'," .
                                            "'$signemail'," .
                                            "'$signmobile'," .
                                            "'$numberUsers'," .
                                            "'$period'," .
                                            "1,".
                                            "1,".
                                            "1".
                                            ")";
                            error_log($dbuserinset);
                            if (SharedQuery($dbuserinset, $dblink))
                            {
                                // Successful save, clear form... insert into transactions table
                                // used the $useruuid to get the user id from users table
                                if($token != null && $email != null)
                                {
                                    $dbuserselect = "select ".
                                                "u1.id ".
                                                "from ".
                                                "users u1 ".
                                                "where ".
                                                "u1.uuid='$useruuid'";
                                    if($dbuserresult = SharedQuery($dbuserselect,$dblink))
                                    {
                                        if ($numrows = SharedNumRows($dbuserresult))
                                        {
                                            while($dbuserrow = SharedFetchArray($dbuserresult))
                                            {
                                                $userid =  $dbuserrow['id'];
                                                error_log("the user id " . $userid);
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
                                                                        "'$custid'," .
                                                                        "'$userid'," .
                                                                        "'$stripeid'," .
                                                                        "'$paymentid'," .
                                                                        "'$datecreated'," .
                                                                        "'$cardid'," .
                                                                        "'$amount'," .
                                                                        "'$currency'," .
                                                                        "'$description'" .
                                                                        ")";
                                                error_log($dbtransactioninsert);
                                                if (SharedQuery($dbtransactioninsert, $dblink))
                                                {
                                                    error_log("here 1");
                                                    $notification = 1;
                                                    $signupmsg =  "You have signed up successfully.Directing you to home page. Don't forget to complete your business details after log in";
                                                }
                                                else
                                                {
                                                    error_log("here 2");
                                                    $notification = 2;
                                                    $signupmsg = "Unable to sign up Please try again or contact support.";
                                                }

                                            }
                                        }
                                        else
                                        {
                                            //could not insert into transations table
                                            $notification = 2;
                                            $signupmsg = "Unable to sign up Please try again or contact support.";
                                        }
                                    }
                                    else
                                    {
                                        $notification = 2;
                                        $signupmsg = "Unable to sign up Please try again or contact support.";
                                    }
                                }
                                else
                                {
                                    error_log("no payment, ends");
                                    $notification = 1;
                                    $signupmsg =  "You have signed up successfully.Directing you to home page. Don't forget to complete your business details after log in";
                                }
                                
                                
                            }
                            else
                            {
                                //could not insert to user table
                                $notification = 2;
                                $signupmsg = "Unable to sign up Please try again or contact support.";
                            }
                        }
                    }
                }
                else
                {
                    $notification = 2;
                    $signupmsg = "Unable to sign up. Please try again or contact support.";
                }
            }
            else
            {
                //could not insert into cust table
            $notification = 2;
            $signupmsg = "Unable to sign up. Please try again or contact support.";
            }
        }
        else
        {
            $notification = 2;
            $signupmsg = "Unable to process the charge. Please try again or use another card.";
        }
    }
    else
    {
        error_log("free trial, creat customer no charges, just create the customer with not price");
        //1st, create a new cust with the uuid
        $custuuid = RemedyUuid();
        $dbinsertcust = "INSERT INTO cust ".
                    "(" .
                    "uuid,".
                    "address,".
                    "city,".
                    "state,".
                    "postcode,".
                    "country".
                    ") ".
                    "VALUES ".
                    "(" .
                    "'$custuuid',".
                    "'$address',".
                    "'$city',".
                    "'$state',".
                    "'$city',".
                    "'$country'".
                    ")";
        // error_log($dbinsert);
        error_log("creating a new cust");
        error_log($dbinsertcust);
        if (SharedQuery($dbinsertcust, $dblink))
        {
        //2nd Successful create the cust, use the uuid to get the id. 
        $dbcustselect = "select ".
                    "c1.id ".
                    "from ".
                    "cust c1 ".
                    "where ".
                    "c1.uuid='$custuuid'";
            error_log($dbcustselect);
            if ($dbcustresult = SharedQuery($dbcustselect,$dblink))
            {
                if ($numrows = SharedNumRows($dbcustresult))
                {
                    while($dbcustrow = SharedFetchArray($dbcustresult))
                    {
                        //3rd, use the cust id to create the user
                        $custid = $dbcustrow['id'];
                        error_log("the new customer id is ");
                        error_log($custid);
                        $useruuid = RemedyUuid();
                        error_log("the new user uuid");
                        error_log($useruuid);
                        $signuid = SharedCleanString($_POST['sign_id'],AT_MAXNAME);
                        $signname = SharedCleanString($_POST['sign_name'],AT_MAXNAME);
                        $signpwd = SharedCleanString($_POST['sign_password'],AT_MAXPWD);
                        $signmobile = SharedCleanString($_POST['sign_phone'],AT_MAXPHONE);
                        $signemail = SharedCleanString($_POST['sign_email'],AT_MAXEMAIL);

                        $dbuserinset = "INSERT INTO users ".
                                        "(" .
                                        "cust_id," .
                                        "uid," .
                                        "pwd," .
                                        "uuid," .
                                        "stripe_id," .
                                        "users.name," .
                                        "email," .
                                        "mobile," .
                                        "numberUsers," .
                                        "period," .
                                        "users.admin," .
                                        "active," . 
                                        "monthValue".
                                        ") " .
                                        "VALUES " .
                                        "(" .
                                        "'$custid'," .
                                        "'$signuid'," .
                                        "'$signpwd'," .
                                        "'$useruuid'," .
                                        "'$stripe_customer_id'," .
                                        "'$signname'," .
                                        "'$signemail'," .
                                        "'$signmobile'," .
                                        "'$numberUsers'," .
                                        "'$period'," .
                                        "1,".
                                        "1,".
                                        "1".
                                        ")";
                        error_log($dbuserinset);
                        if (SharedQuery($dbuserinset, $dblink))
                        {
                            // Successful save, clear form
                            // used the $useruuid to get the user id from users table
                            error_log("no payment, ends");
                            $notification = 1;
                            $signupmsg =  "You have signed up successfully.Directing you to login page. Don't forget to complete your business details after log in";
                        }
                        else
                        {
                            //could not insert to user table
                            $notification = 2;
                            $signupmsg = "Unable to sign up Please try again or contact support.";
                        }
                    }
                }
            }
            else
            {
                $notification = 2;
                $signupmsg = "Unable to sign up. Please try again or contact support.";
            }
        }
        else
        {
            $notification = 2;
            $signupmsg = "Unable to sign up. Please try again or contact support.";
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
                        // window.location.replace("/tint/login.php");// for local path
                        window.location.replace("/login.php"); // for production path
                    }, 3000);
                } else if (notification == 2) {
                    noty({
                        text: message,
                        type: 'error',
                        timeout: 3000
                    });
                    setTimeout(() => {
                        // window.location.replace("/tint/signup.php");// for local path
                        window.location.replace("/signup.php");// for production path
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