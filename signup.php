<?php
  include("remedyshared.php");
  SharedInit();
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/index.php');
    //exit;
  }
  $dblink = SharedConnect();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBqCHDj475c_6YSc9yqwBH3eN1bYovqtUE&libraries=places&callback=initAutocomplete"
            async defer></script>
        <script type="text/javascript">
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
        </script>
        <?php include("meta.php");?>
        <title>Sign Up</title>
    </head>

    <body>
        <?php include("top.php");?>

        <div class="m-auto container" style="width:60%">
            <h1 class="text-dark">Sign Up</h1>
            <form style="background-color:#f0f0f0;" action="#" method="post" id="frmSignup" class="p-4">
                <div class="row">
                    <input id="sign_id" class="form-control" type="text" placeholder="NAME" required>
                </div>
                <div class="row">
                    <input id="sign_phone" class="form-control col-sm-5" type="text" placeholder="MOBILE (Number only)" required pattern="^[0-9]{6,}$"
                        title="Invalid Phone number">
                    <input id="sign_email" class="form-control col" type="text" placeholder="EMAIL" required pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                        title="Invalid Email address">
                </div>
                <!-- <div class="row">
                    <input id="sign_country" class="form-control" type="text" placeholder="COUNTRY">
                </div> -->
                <div class="row">
                    <input id="sign_address" class="form-control" type="text" placeholder="ADDRESS" onFocus="geolocate()">
                </div>
                <div class="row">
                    <input id="sign_city" class="form-control col-sm" type="text" placeholder="CITY">
                    <input id="sign_state" class="form-control col-sm" type="text" placeholder="STATE">
                    <input id="sign_pcode" class="form-control col-sm" type="text" placeholder="P/CODE">
                    <input id="sign_country" class="form-control col-sm" type="text" placeholder="COUNTRY">
                </div>
                <span class="myhr"></span>
                <div class="row">
                    <input id="sign_password" class="form-control col-sm-5" type="password" placeholder="PASSWORD" required>
                    <input id="sign_secondPwd" class="form-control col" type="password" placeholder="RE-ENTER PASSWORD" required onchange="validatePwd()">
                </div>
                <div class="row">
                    <span id="error_message" class="text-danger col" style="display:none">Two passwords are different</span>
                </div>

                <span class="myhr"></span>

                <h2 class="text-dark mt-5">
                    <b>PLAN SELECTION</b>
                </h2>
                <div class="form-group text-dark">
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="opt_1">30 day free trial</h6>
                    </div>
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="opt_2">Annual plan - USD $99 per year
                            <span class="text-danger">(save 17% *)</span>
                        </h6>
                    </div>
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="opt_3">3 Year plan - USD $250
                            <span class="text-danger">(save 30% *)</span>
                        </h6>
                    </div>
                    <label class="ml-5">* in comparison to purchasing a monthly plan</label>
                </div>
                <div>
                    <button id="signup_button" type="submit" class="btn-danger btn-lg">SIGN UP</button>
                </div>
            </form>
            <div id="DIV_Message">
                <p>Want to get in touch?
                    <a href="contact.php">Click here</a> to message us.</p>
            </div>
        </div>
        <?php include("bottom.php");?>
        
    </body>

    </html>