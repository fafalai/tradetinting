<?php
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/contact.php');
    //exit;
  }
  require_once("remedyshared.php");
  require_once("class.phpmailer.php");
  SharedInit();

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
            <h2 class="text-dark mt-5">
                <b>PLAN SELECTION</b>
            </h2>
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
                <button id="signup_plan_button" type="submit" class="btn-danger btn-lg" name="signup_button" style="cursor: pointer;"
                    >SIGN UP FOR ANNUAL PLAN</button>

                <script>
                    
                    document.getElementById("signup_plan_button").addEventListener("click", function (event) {
                        $("#loading-overlay").show();

                        event.preventDefault()
                        console.log("payment plan");
                        document.getElementById('signup_plan_button').disabled = true;
                        var originalText = document.getElementById('signup_plan_button').innerText;
                        document.getElementById('signup_plan_button').innerText = "please wait....";
                       
                        var radios = document.getElementsByName('plan_opt');
                        var amount = 0;
                        var description = "";

                        for (var i = 0, length = radios.length; i < length; i++) {
                            // console.log(i);
                            if (radios[i].checked) {
                                // do whatever you want with the checked radio
                                if (i == 1) {
                                    description = "Annual Plan";
                                } else if (i == 2) {
                                    description = "3 Years Plan";
                                }
                                amount = radios[i].value
                                console.log(amount);
                                console.log(description);

                                // only one radio can be logically checked, don't check the rest
                                break;
                            }
                        }

                        var handler = StripeCheckout.configure({
                            key: 'pk_test_iGsAvPJtLoZmJPd1cwFZ2wES',
                            image: 'images/icon.png',
                            name: 'Tinting',
                            locale: 'auto',
                            currency: 'usd',
                            token: function (token) {
                                // You can access the token ID with `token.id`.
                                // Get the token ID to your server-side code for use.
                                // window.onbeforeunload = function () {
                                //     return "";
                                // }

                                // Dynamically create a form element to submit the results
                                // to your backend server


                                // Add the token ID as a hidden field to the form payment-form
                                var inputToken = document.createElement("input");
                                inputToken.setAttribute('type', "hidden");
                                inputToken.setAttribute('name', "stripeToken");
                                // inputDescription.setAttribute('id', "stripeToken");
                                inputToken.setAttribute('value', token.id);
                                // console.log(token.id);
                                //form.appendChild(inputToken);

                                // Add the email as a hidden field to the form
                                var inputEmail = document.createElement("input");
                                inputEmail.setAttribute('type', "hidden");
                                inputEmail.setAttribute('name', "stripeEmail");
                                // inputDescription.setAttribute('id', "stripeEmail");
                                inputEmail.setAttribute('value', token.email);
                                //form.appendChild(inputEmail);

                                // Add the description as a hidden field to the form
                                var inputDescription = document.createElement("input");
                                inputDescription.setAttribute('type', "hidden");
                                inputDescription.setAttribute('name', "description");
                                // inputDescription.setAttribute('id', "description");
                                inputDescription.setAttribute('value', description);
                                //form.appendChild(inputDescription);

                                //Artificial 0.5 second delay for testing
                                // setTimeout(function () {
                                //     console.log("Artificial 0.5 second.......");
                                //     window.onbeforeunload = null;
                                    
                                //     // document.getElementById('loading-overlay').style.display = "block";
                                //     $("#loading-overlay").show();
                                //     // document.getElementById('loading-message').style.display = "block";
                                //     $("#loading-message").show('fade');
                                // }, 500);
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
        </div>
       
    </body>

    </html>