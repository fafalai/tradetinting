<?php
    require_once "stripeconfig.php";
    include("remedyshared.php");
    include("remedyuuid.php");
    require_once("remedyerrcodes.php");
    SharedInit();

	\Stripe\Stripe::setVerifySslCerts(false);

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
	// //send an email
    // //store information to the database
   
    $token = $_POST['stripeToken'];
    $email = $_POST["stripeEmail"];
    $address = SharedCleanString($_POST['sign_address'],AT_MAXADDRESS);
    $city = SharedCleanString($_POST['sign_city'],AT_MAXADDRESS);
    $state = SharedCleanString($_POST['sign_state'],AT_MAXADDRESS);
    $city = SharedCleanString($_POST['sign_city'],AT_MAXADDRESS);
    $country = SharedCleanString($_POST['sign_country'],AT_MAXADDRESS);
    $plan = SharedCleanString($_POST['plan_opt'],AT_MAXADDRESS);//This is for knowing how many users this customer could create, the numberUsers column in user table
    error_log("address: " . $address);
    error_log("state: ". $state);
    error_log("city: " . $city);
    error_log("country: ". $country);
    error_log("selected plan: " . $plan);
    error_log($token);
    error_log($email);
    // // Charge the user's card:
	$charge = \Stripe\Charge::create(array(
		"amount" =>($plan*100),
		"currency" => "usd",
		"description" => "test",
		"source" => $token,
    ));
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
                                    "name," .
                                    "email," .
                                    "mobile," .
                                    "admin," .
                                    "active" .
                                    ") " .
                                    "VALUES " .
                                    "(" .
                                    "'$custid'," .
                                    "'$signuid'," .
                                    "'$signpwd'," .
                                    "'$useruuid'," .
                                    "'$signname'," .
                                    "'$signemail'," .
                                    "'$signmobile'," .
                                    "1,".
                                    "1".
                                    ")";
                        error_log($dbuserinset);
                        if (SharedQuery($dbuserinset, $dblink))
                        {
                          // Successful save, clear form...
                          $notification = 1;
                          $signupmsg =  "You have signed up successfully.Directing you to home page. Don't forget to complete your business details after log in";
                        }
                        else
                        {
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
                    window.location.replace("/tint/index.php");
                }, 3000);
            } else if (notification == 2) {
                noty({
                    text: message,
                    type: 'error',
                    timeout: 3000
                });
                setTimeout(() => {
                    window.location.replace("/tint/signup.php");
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
  <title>Sign Up</title>
</head>
<body>
</body>
</html>