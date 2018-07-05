<!-- 
     1 ===  Successfull
     2 ===  Fail 
    
-->
<?php
  include("remedyshared.php");
  include ("remedyuuid.php");
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
  if($_POST['signup_button'])
  {
    //1st, create a new cust with the uuid
    $custuuid = RemedyUuid();
    $address = SharedCleanString($_POST['sign_address'],AT_MAXADDRESS);
    $city = SharedCleanString($_POST['sign_city'],AT_MAXADDRESS);
    $state = SharedCleanString($_POST['sign_state'],AT_MAXADDRESS);
    $city = SharedCleanString($_POST['sign_city'],AT_MAXADDRESS);
    $country = SharedCleanString($_POST['sign_country'],AT_MAXADDRESS);
    $plan = SharedCleanString($_POST['plan_opt'],AT_MAXADDRESS);//This is for knowing how many users this customer could create, the numberUsers column in user table
    error_log("selected plan:");
    error_log($plan);

    // $dbinsertcust = "INSERT INTO cust ".
    //             "(" .
    //             "uuid,".
    //             "address,".
    //             "city,".
    //             "state,".
    //             "postcode,".
    //             "country".
    //             ") ".
    //             "VALUES ".
    //             "(" .
    //             "'$custuuid',".
    //             "'$address',".
    //             "'$city',".
    //             "'$state',".
    //             "'$city',".
    //             "'$country'".
    //             ")";
    // // error_log($dbinsert);
    // error_log("creating a new cust");
    // error_log($dbinsertcust);
    // if (SharedQuery($dbinsertcust, $dblink))
    // {
    //   //2nd Successful create the cust, use the uuid to get the id. 
    //   $dbcustselect = "select ".
    //             "c1.id ".
    //             "from ".
    //             "cust c1 ".
    //             "where ".
    //             "c1.uuid='$custuuid'";
    //     error_log($dbcustselect);
    //     if ($dbcustresult = SharedQuery($dbcustselect,$dblink))
    //     {
    //         if ($numrows = SharedNumRows($dbcustresult))
    //         {
    //             while($dbcustrow = SharedFetchArray($dbcustresult))
    //             {
    //                 //3rd, use the cust id to create the user
    //                 $custid = $dbcustrow['id'];
    //                 error_log("the new customer id is ");
    //                 error_log($custid);
    //                 $useruuid = RemedyUuid();
    //                 error_log("the new user uuid");
    //                 error_log($useruuid);
    //                 $signuid = SharedCleanString($_POST['sign_id'],AT_MAXNAME);
    //                 $signname = SharedCleanString($_POST['sign_name'],AT_MAXNAME);
    //                 $signpwd = SharedCleanString($_POST['sign_password'],AT_MAXPWD);
    //                 $signmobile = SharedCleanString($_POST['sign_phone'],AT_MAXPHONE);
    //                 $signemail = SharedCleanString($_POST['sign_email'],AT_MAXEMAIL);

    //                 $dbuserinset = "INSERT INTO users ".
    //                                 "(" .
    //                                 "cust_id," .
    //                                 "uid," .
    //                                 "pwd," .
    //                                 "uuid," .
    //                                 "name," .
    //                                 "email," .
    //                                 "mobile," .
    //                                 "admin," .
    //                                 "active" .
    //                                 ") " .
    //                                 "VALUES " .
    //                                 "(" .
    //                                 "'$custid'," .
    //                                 "'$signuid'," .
    //                                 "'$signpwd'," .
    //                                 "'$useruuid'," .
    //                                 "'$signname'," .
    //                                 "'$signemail'," .
    //                                 "'$signmobile'," .
    //                                 "1,".
    //                                 "1".
    //                                 ")";
    //                     error_log($dbuserinset);
    //                     if (SharedQuery($dbuserinset, $dblink))
    //                     {
    //                       // Successful save, clear form...
    //                       $notification = 1;
    //                       $signupmsg =  "You have signed up successfully. Don't forget to complete your business details after log in";
    //                     }
    //                     else
    //                     {
    //                       $notification = 2;
    //                       $signupmsg = "Unable to sign up Please try again or contact support.";
    //                     }
    //             }
    //         }
    //     }
    //     else
    //     {
    //         $notification = 2;
    //         $signupmsg = "Unable to sign up. Please try again or contact support.";
    //     }
    // }
    // else
    // {
    //   $notification = 2;
    //   $signupmsg = "Unable to sign up. Please try again or contact support.";
    // }
  }
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

        <div class="m-auto container" style="width:60%">
            <h1 class="text-dark">Sign Up</h1>
            <form style="background-color:#f0f0f0;" action="#" method="post" id="frmSignup" class="p-4">
                <div class="row">
                    <input required id="sign_id" name="sign_id" class="form-control" type="text" placeholder="User ID"  onchange="CheckUserId();">
                </div>
                <div class="row">
                    <input required id="sign_name" name="sign_name" class="form-control" type="text" placeholder="User Name">
                </div>
                <div class="row">
                    <input id="sign_phone" name="sign_phone" class="form-control col-sm-5" type="text" placeholder="Mobile (Must be at least 5 digits)" required pattern="^[0-9]{5,}$"
                        title="Invalid Phone number">
                    <input id="sign_email" name="sign_email" class="form-control col" type="text" placeholder="EMAIL" required pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                        title="Invalid Email address">
                </div>
                <!-- <div class="row">
                <input id="sign_country" class="form-control" type="text" placeholder="COUNTRY">
            </div> -->
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
                    <input id="sign_password" name="sign_password" class="form-control col-sm-5" type="password" placeholder="Password (Must be at least 5 characters and not too simple)" required pattern="^(\w|\W){5,}$">
                    <input id="sign_secondPwd" class="form-control col" type="password" placeholder="RE-ENTER PASSWORD" required pattern="^(\w|\W){5,}$">
                </div>
                <div class="row">
                    <span id="error_message" class="text-danger col" style="display:none">* Two passwords are different</span>
                </div>

                <span class="myhr"></span>

                <h2 class="text-dark mt-5">
                    <b>PLAN SELECTION</b>
                </h2>
                <div class="form-group text-dark">
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="10">30 day free trial</h6>
                    </div>
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="20">Annual plan - USD $99 per year
                            <span class="text-danger">(save 17% *)</span>
                        </h6>
                    </div>
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="30">3 Year plan - USD $250
                            <span class="text-danger">(save 30% *)</span>
                        </h6>
                    </div>
                    <label class="ml-5">* in comparison to purchasing a monthly plan</label>
                </div>
                <div>
                    <!-- <button id="signup_button" type="submit" class="btn-danger btn-lg" name="signup_button">SIGN UP</button> -->
                    <input type="submit" value = "SIGN UP" name="signup_button" id="signup_button" class="btn-danger btn-lg">
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