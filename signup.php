<!-- 
     1 ===  Successfull
     2 ===  Fail 
    
-->
<?php
  include("remedyshared.php");
  include("remedyuuid.php");
  require_once("remedyerrcodes.php");
  SharedInit();
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/index.php');
    //exit;
  }
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
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("meta.php");?>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBqCHDj475c_6YSc9yqwBH3eN1bYovqtUE&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var message = "";
            var notification = "";
            message = "<?php if ($signupmsg != "
            ") echo $signupmsg; else echo 123;?>";
            notification = "<?php if ($notification != "
            ") echo $notification; else echo 123;?>";
            console.log(message);
            console.log(notification);
            if (notification == 1) {
                noty({
                    text: message,
                    type: 'success',
                    timeout: 6000
                });
            } else if (notification == 2) {
                noty({
                    text: message,
                    type: 'error',
                    timeout: 3000
                });
            }
        });

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            console.log("I am in");
            autocomplete = new google.maps.places.Autocomplete( /** @type {!HTMLInputElement} */ (document.getElementById(
                'sign_address')), {
                types: ['geocode']
            });

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            google.maps.event.addListener(
                autocomplete,
                'place_changed',
                function () {
                    var place = autocomplete.getPlace();

                    if (!_.isUndefined(place.address_components)) {
                        if (place.address_components.length == 8) {
                            console.log("length 8");
                            console.log(place.address_components);
                            //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                            document.getElementById('sign_address').value = place.name
                            //$('#fldCity').textbox('setValue', place.address_components[3].short_name);
                            document.getElementById('sign_city').value = place.address_components[3].short_name;
                            //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[7].short_name);
                            document.getElementById('sign_state').value = place.address_components[5].short_name;
                            // $('#fldState').combobox('setValue', place.address_components[5].short_name);
                            document.getElementById('sign_country').value = place.address_components[6].long_name;
                            document.getElementById('sign_pcode').value = place.address_components[7].short_name;
                        } else if (place.address_components.length == 9) {
                            console.log("length 9");
                            console.log(place.address_components);
                            //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                            document.getElementById('sign_address').value = place.name
                            //$('#fldCity').textbox('setValue', place.address_components[3].short_name);
                            document.getElementById('sign_city').value = place.address_components[3].short_name;
                            //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[7].short_name);
                            document.getElementById('sign_state').value = place.address_components[5].short_name;
                            // $('#fldState').combobox('setValue', place.address_components[5].short_name);
                            document.getElementById('sign_country').value = place.address_components[6].long_name;
                            document.getElementById('sign_pcode').value = place.address_components[7].short_name;
                        } else {
                            console.log("other");
                            console.log(place.address_components);
                            //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                            document.getElementById('sign_address').value = place.name;
                            //$('#fldNewBookingCustCity').textbox('setValue', place.address_components[2].short_name);
                            document.getElementById('sign_city').value = place.address_components[2].short_name;
                            //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[6].short_name);
                            document.getElementById('sign_state').value = place.address_components[4].short_name;
                            document.getElementById('sign_country').value = place.address_components[5].long_name;
                            document.getElementById('sign_pcode').value = place.address_components[6].short_name;
                        }
                    }
                }
            );
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }

        function CheckUserId() {
            var uid = $('#sign_id').val();
            var data = {
                uid: uid
            };
            $.ajax({
                url: 'checkuidavail.php',
                type: 'POST',
                data: data,
                cache: false,
                success: function (rc) {
                    var response = JSON.parse(rc);
                    if (response.rc == <?php echo REMEDY_ERR_NONE; ?>) {
                        if (response.id != 0) {
                            alert('This User ID has been taken, please use another one');
                            //$('#fldUid').val('');
                            //$('#fldUid').focus();
                        }
                    }
                }
            });
        }

    </script>
    <title>Sign Up</title>
</head>

<body>
    <?php include("top.php");?>

    <div class="container" style="width:70%">
        <h2 class="text-dark mb-2" style="font-family: Arial, Helvetica, sans-serif;font-weight: bold;font-size: 20pt;">Sign Up</h2>
        <form style="background-color:#f0f0f0;" action="payment.php" method="post" id="frmSignup" class="p-4 form-group">
            <div class="row">
                <input required id="sign_id" name="sign_id" class="form-control" type="text" placeholder="User ID" onchange="CheckUserId();">
            </div>
            <div class="row">
                <input required id="sign_name" name="sign_name" class="form-control" type="text" placeholder="User Name">
            </div>
            <div class="row">
                <input id="sign_phone" name="sign_phone" class="form-control col-sm-5" type="text" placeholder="Phone (Must be at least 5 digits)"
                    required pattern="^[0-9]{5,}$" title="Invalid Phone number">
                <input id="sign_email" name="sign_email" class="form-control col" type="text" placeholder="EMAIL" required pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                    title="Invalid Email address">
            </div>
                <div class="row">
            </div>
            <div class="row">
                <input id="sign_address" name="sign_address" class="form-control" type="text" placeholder="ADDRESS" onFocus="geolocate()">
            </div>
            <div class="row">
                <input id="sign_city" name="sign_city" class="form-control col-sm" type="text" placeholder="CITY">
                <input id="sign_state" name="sign_state" class="form-control col-sm" type="text" placeholder="STATE">
                <input id="sign_pcode" name="sign_pcode" class="form-control col-sm" type="text" placeholder="P/CODE">
                <input id="sign_country" name="sign_country" class="form-control col-sm" type="text" placeholder="COUNTRY">
            </div>
            <span class="myhr"></span>
            <div class="row">
                <input id="sign_password" name="sign_password" class="form-control col-sm-5" type="password" placeholder="Password (Must be at least 5 characters and not too simple)"
                    required pattern="^(\w|\W){5,}$">
                <input id="sign_secondPwd" class="form-control col" type="password" placeholder="RE-ENTER PASSWORD" required pattern="^(\w|\W){5,}$">
            </div>
            <div class="row">
                <span id="error_message" class="text-danger col" style="display:none">* Two passwords are different</span>
            </div>

            <span class="myhr"></span>

            <h2 class="text-dark mt-5">
                <b>PLAN SELECTION</b>
            </h2>
            <div class="form-group text-dark" id="plan_options">
                <div class="radio">
                    <h6>
                        <input type="radio" name="plan_opt" value="0" checked>30 day free trial</h6>
                </div>
                <div class="radio">
                    <h6>
                        <input type="radio" name="plan_opt" value="99">Annual plan - USD $99 per year
                        <span class="text-danger">(save 17% *)</span>
                    </h6>
                </div>
                <div class="radio">
                    <h6>
                        <input type="radio" name="plan_opt" value="250">3 Year plan - USD $250
                        <span class="text-danger">(save 30% *)</span>
                    </h6>
                </div>
                <label class="ml-5">* in comparison to purchasing a monthly plan</label>
            </div>              
            <div>
                <button id="signup_noplan_button" type="submit" class="btn-danger btn-lg" name="signup_button">SIGN UP FOR FREE TRIAL</button>
                <!-- <input type="submit" value="SIGN UP" name="signup_button" id="signup_button" class="btn-danger btn-lg"> -->
                <button id="signup_plan_button" type="submit" class="btn-danger btn-lg" name="signup_button" style="display:none" onclick="openPayment()"></button>

                <script>
                    

                    function openPayment()
                    {
                        $("#frmSignup").submit(function(e){
                            e.preventDefault(); // don't submit multiple times
                            //this.submit(); // use the native submit method of the form element
                            var radios = document.getElementsByName('plan_opt');
                            var amount = 0;
                            var description = "";

                            for (var i = 0, length = radios.length; i < length; i++) {
                                if (radios[i].checked) {
                                    // do whatever you want with the checked radio
                                    // alert(radios[i].value);
                                   
                                    if(i == 1)
                                    {
                                        description = "Annual Plan";
                                    }
                                    else if (i == 2)
                                    {
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
                                name:'Tinting',
                                locale: 'auto',
                                token: function(token) {
                                    // You can access the token ID with `token.id`.
                                    // Get the token ID to your server-side code for use.
                                    window.onbeforeunload = function() {
                                    return "";
                                    }

                                    // Dynamically create a form element to submit the results
                                    // to your backend server
                                    var form = document.getElementById("frmSignup");

                                    // Add the token ID as a hidden field to the form payment-form
                                    var inputToken = document.createElement("input");
                                    inputToken.setAttribute('type', "hidden");
                                    inputToken.setAttribute('name', "stripeToken");
                                    inputToken.setAttribute('value', token.id);
                                    form.appendChild(inputToken);

                                    // Add the email as a hidden field to the form
                                    var inputEmail = document.createElement("input");
                                    inputEmail.setAttribute('type', "hidden");
                                    inputEmail.setAttribute('name', "stripeEmail");
                                    inputEmail.setAttribute('value', token.email);
                                    form.appendChild(inputEmail);

                                    // Add the description as a hidden field to the form
                                    var inputDescription = document.createElement("input");
                                    inputDescription.setAttribute('type', "hidden");
                                    inputDescription.setAttribute('name', "description");
                                    inputDescription.setAttribute('value', description);
                                    form.appendChild(inputDescription);

                                    //Artificial 5 second delay for testing
                                    setTimeout(function() {
                                        window.onbeforeunload = null;
                                        document.forms["frmSignup"].submit()
                                    }, 5000);
                                        }
                            });
                            handler.open({
                                name: 'Tinting',
                                description: description,
                                currency: 'usd',
                                amount: amount*100,
                                //email:document.getElementById('sign_email').value,
                                locale:'auto',
                                //zipCode:true,
                                //billingAddress:true
                                
                            });
                            //alert("hello");
                            // setTimeout(() => {
                            //     this.submit();
                            // }, timeout);
                            //this.submit();
                        })
                        //document.getElementById('signup_plan_button').click();
                        //Open Checkout with further options:
                        // handler.open({
                        //     name: 'Tinting',
                        //     description: '2 widgets',
                        //     currency: 'aud',
                        //     amount: amount*100
                        // });
                        //e.preventDefault();
                    }

                    // document.getElementById('signup_plan_button').addEventListener('click', function(e) {
                    //     var radios = document.getElementsByName('plan_opt');
                    //     var amount = 0;
                    //     var description = "";

                    //     for (var i = 0, length = radios.length; i < length; i++) {
                    //         if (radios[i].checked) {
                    //             // do whatever you want with the checked radio
                    //             // alert(radios[i].value);
                    //             amount = radios[i].value
                    //             console.log(amount);

                    //             // only one radio can be logically checked, don't check the rest
                    //             break;
                    //         }
                    //     }

                    //     // $("#frmSignup").submit(function(){
                    //     //     handler.open({
                    //     //         name: 'Tinting',
                    //     //         description: '2 widgets',
                    //     //         currency: 'aud',
                    //     //         amount: amount*100
                    //     //     });
                    //     // e.preventDefault();
                    //     // })
                    //     //document.getElementById('signup_plan_button').click();
                    //     //Open Checkout with further options:
                    //     handler.open({
                    //         name: 'Tinting',
                    //         description: '2 widgets',
                    //         currency: 'aud',
                    //         amount: amount*100
                    //     });
                    //     e.preventDefault();
                    // });

                    // Close Checkout on page navigation:
                    window.addEventListener('popstate', function() {
                        handler.close();
                    });

                </script>
            </div>
        </form>
        <div id="DIV_Message">
            <p>Want to get in touch?
                <a href="contact.php">Click here</a> to message us.</p>
        </div>
    </div>
    <?php include("bottom.php");?>
    <script src="js/signup.js"></script>
</body>

</html>