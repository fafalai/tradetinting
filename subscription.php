<?php
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/contact.php');
    //exit;
  }
  require_once("remedyshared.php");
  require_once("class.phpmailer.php");
  SharedInit();
  
  $dblink = SharedConnect();
  $c_id=$_SESSION['custid'];
  $dbselect = "select " .
	"u1.period, " .
	"u1.licexpired " .
	"from " .
	"users u1 " .
	"where " .
	"u1.cust_id='$c_id'";
  error_log($dbselect);
  $licexpire = "";
  $period = "";
  if ($dbresult = SharedQuery($dbselect, $dblink)){

	if ($numrows = SharedNumRows($dbresult)){
		while ($dbrow = SharedFetchArray($dbresult))
		{
			$period = $dbrow['period'];

			$licexpire = new DateTime($dbrow['licexpired']);
			
			$licexpire = $licexpire->format('Y-m-d');
			if($period == 1){
				$periodText = "Free Subscription";
			}elseif($period == 12){
				$periodText = "Annual Plan";
			}elseif($period == 36){
				$periodText = "3 Years Plan";
			}
		}
	}else{
	error_log("error");
  }
}else{
  error_log("error");
}
error_log($licexpire);
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->
        <?php include("meta.php");?>
        <script>
            function planOption_Select()
            {
                $('#plan_options input[type=radio]').change(function(){
                    console.log ($(this).val()) 
                    var plan = $(this).val();
                    if (plan == 99) 
                    {
                        document.getElementById('signup_plan_button').innerText = "SIGN UP FOR ANNUAL PLAN";
                    } 
                    else 
                    {
                        document.getElementById('signup_plan_button').innerText = "SIGN UP FOR 3 YEAR PLAN";
                    }
                });
            };
            $(document).ready(function () {
                planOption_Select();
            });
        </script>
        <title>Subscription</title>
    </head>

    <body>
        <div id="loading-overlay"></div>
        <div id="loading-message">Loading page, please wait...</div>
        <?php include("top.php");?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
        <hr />
        <div class="container" style="width:70%">
            <label>
                <?php echo date("l, F j, Y"); ?>
            </label>
            <h2 class="clientTitle mb-2">SUBSCRIPTION</h2>
			<p style="font-size:12pt">
				<span style="color:#747474">Your current subscription is ending on <?= $licexpire ?> </span>
				<br/>
				<span style="color:#747474">Your current subscription plan is <?= $periodText?></span>
			</p>
            <h2 class="text-dark mt-5">
                <b>PLAN CHANGING SELECTION</b>
            </h2>
            <form  action="exisitingUserPayment.php" method="post" id="frmSignup" name="signupForm" >
				<div class="form-group text-dark" id="plan_options">
					<div class="radio" style="margin-top:20px">
						<h5>
							<input type="radio" name="plan_opt" value="99" checked>&nbsp;&nbsp;Annual plan - USD $99 per year
							<span class="text-danger">(save 17% *)</span>
						</h5>
					</div>
					<div class="radio" style="margin-top:30px">
						<h5>
							<input type="radio" name="plan_opt" value="250">&nbsp;&nbsp;3 Year plan - USD $250
							<span class="text-danger">(save 30% *)</span>
						</h5>
					</div>
				</div>
				<div style="margin-top:50px">
					<button id="signup_plan_button" type="submit" class="btn-danger btn-lg" name="signup_button" style="cursor: pointer;">
						SIGN UP FOR ANNUAL PLAN
					</button>
                    <script>
                        document.getElementById("signup_plan_button").addEventListener("click", function (event) {
                            event.preventDefault()
							$("#loading-overlay").show();
							document.getElementById('signup_plan_button').disabled = true;
							var originalText = document.getElementById('signup_plan_button').innerText;
							document.getElementById('signup_plan_button').innerText = "please wait....";
							var radios = document.getElementsByName('plan_opt');
							var amount = 0;
							var description = "";
							for (var i = 0, length = radios.length; i < length; i++) {
								if (radios[i].checked) {
									if (i == 1) {
										description = "Annual Plan";
									} else if (i == 2) {
										description = "3 Years Plan";
									}
									break;
								}
							}

							var handler = StripeCheckout.configure({
								key: 'pk_test_W20HElwGRLvWc26WxWczuwFc00mqQ67ey8',
								image: 'images/icon.png',
								name: 'Tinting',
								locale: 'auto',
								currency: 'usd',
								token: function (token) {
									var form = document.getElementById("frmSignup");
									var inputToken = document.createElement("input");
									inputToken.setAttribute('type', "hidden");
									inputToken.setAttribute('name', "stripeToken");
									// inputDescription.setAttribute('id', "stripeToken");
									inputToken.setAttribute('value', token.id);
									// console.log(token.id);
									form.appendChild(inputToken);

									// Add the email as a hidden field to the form
									var inputEmail = document.createElement("input");
									inputEmail.setAttribute('type', "hidden");
									inputEmail.setAttribute('name', "stripeEmail");
									// inputDescription.setAttribute('id', "stripeEmail");
									inputEmail.setAttribute('value', token.email);
									form.appendChild(inputEmail);

									// Add the description as a hidden field to the form
									var inputDescription = document.createElement("input");
									inputDescription.setAttribute('type', "hidden");
									inputDescription.setAttribute('name', "description");
									// inputDescription.setAttribute('id', "description");
									inputDescription.setAttribute('value', description);
									form.appendChild(inputDescription);

									//Artificial 0.5 second delay for testing
									setTimeout(function () {
										console.log("Artificial 0.5 second.......");
										window.onbeforeunload = null;
										
										// document.getElementById('loading-overlay').style.display = "block";
										$("#loading-overlay").show();
										// document.getElementById('loading-message').style.display = "block";
										$("#loading-message").show('fade');
										document.forms["frmSignup"].submit();
									}, 500);
								}
							});


							handler.open({
								//name: 'Tinting',
								description: description,
								amount: amount * 100,
								//email:document.getElementById('sign_email').value,
								// locale: 'auto',
								//zipCode:true,
								//billingAddress:true

								// Close Checkout on page navigation:
								closed: function () {
									console.log("close the checkout");
									$("#loading-overlay").hide('fade');
									// $("#loading-message").show('fade');
									document.getElementById('signup_plan_button').disabled =
										false;
									document.getElementById('signup_plan_button').innerText =
										originalText;
								}

							});
                        });


                        window.addEventListener('popstate', function () {
                            handler.close();
                        });
                    </script>
                </div>
            </form>
        </div>
       
    </body>

    </html>