<?php
include("logincheck.php");
if (!isset($_SERVER['HTTPS']))
{
    //header('location: https://www.adtalk.services/testtag/profile.php');
    //exit;
}
$dblink = SharedConnect();
$profilemsg = "";
$detailmsg = "";
define('AT_MAXIDENTIFICATIONNO', 50);
define('AT_MAXCOUNTRY', 50);
define('AT_MAXCURRENCY', 10);
//in remedyshared.php, it defines the AT_MAXSTATE is 3, but we don't only have Australian states, it will exceeds 3 words limit, so use AT_MAXCOUNTRY instead.

//
if (isset($_POST['fldName']) || isset($_POST['fldContact']) || isset($_POST['fldMobile']))
{
    $fldname = SharedCleanString($_POST['fldName'], AT_MAXNAME);
    $flddesc = SharedCleanString($_POST['fldDesc'], AT_MAXNOTE);
    $fldidentificationno = SharedCleanString($_POST['fldidentificationno'], AT_MAXIDENTIFICATIONNO);
    $fldcontact = SharedCleanString($_POST['fldContact'], AT_MAXNAME);
    $fldphone = SharedCleanString($_POST['fldPhone'], AT_MAXPHONE);
    $fldmobile = SharedCleanString($_POST['fldMobile'], AT_MAXPHONE);
    $fldemail = SharedCleanString($_POST['fldEmail'], AT_MAXEMAIL);
    $fldcountry = SharedCleanString($_POST['fldCountry'], AT_MAXCOUNTRY);
    //error_log($fldcountry);
    $fldaddress = SharedCleanString($_POST['fldAddress'], AT_MAXADDRESS);
    $fldcity = SharedCleanString($_POST['fldCity'], AT_MAXADDRESS);
    $fldstate = SharedCleanString($_POST['fldState'], AT_MAXCOUNTRY);
    $fldpostcode = SharedCleanString($_POST['fldPostcode'], AT_MAXPOSTCODE);

    $fldunits = SharedCleanString($_POST['fldUnits'], AT_MAXNAME);
    $fldcurrency = SharedCleanString($_POST['fldcurrency'], AT_MAXCURRENCY);
    // Cust record is always already created...
    $dbupdate = "update " .
        "cust " .
        "set " .
        "cust.name=" .SharedNullOrQuoted($fldname,50, $dblink) . "," .
        "cust.desc=" .SharedNullOrQuoted($flddesc,1000, $dblink) . "," .
        "cust.identificationno=" .SharedNullOrQuoted($fldidentificationno,50, $dblink) . "," .
        "contact=" .SharedNullOrQuoted($fldcontact,50, $dblink) . "," .
        "phone=" .SharedNullOrQuoted($fldphone,50, $dblink) . "," .
        "mobile=" .SharedNullOrQuoted($fldmobile, 50,$dblink) . "," .
        "email=" .SharedNullOrQuoted($fldemail,50, $dblink) . "," .
        "address=" .SharedNullOrQuoted($fldaddress,50, $dblink) . "," .
        "city=" .SharedNullOrQuoted($fldcity,50, $dblink) . "," .
        "state=" .SharedNullOrQuoted($fldstate,50, $dblink) . "," .
        "postcode=" .SharedNullOrQuoted($fldpostcode,50, $dblink) . "," .
        "country=" .SharedNullOrQuoted($fldcountry,50, $dblink) . "," .
        "units=" .SharedNullOrQuoted($fldunits,50, $dblink) . "," .
        "currency=" .SharedNullOrQuoted($fldcurrency,50, $dblink) . "," .
        "datemodified=CURRENT_TIMESTAMP " .
        "where " .
        "id=" . $_SESSION['custid'];
    error_log($dbupdate);
    if (SharedQuery($dbupdate, $dblink))
        $detailmsg = "Your details have been updated.";
    else
        $detailmsg = "Unable to save your details. Please try again or contact support.";
}
if($_POST['saveTemplate'])
{
    if(isset($_POST[editor]))
    {
        $text = $_POST['editor'];
        $custid = $_SESSION['custid'];
        echo "$text";
        if (file_exists("quoteEmailTemplate/$custid.html") == true)
        {
            echo "quoteEmailTemplate/$custid.html exits";
        }
        $myfile = fopen("quoteEmailTemplate/$custid.html", "w") or die("Unable to open file!");
        fwrite($myfile, $text);
        // $txt = "Jane Doe\n";
        // fwrite($myfile, $txt);
        fclose($myfile);
    }
}
//
$fldname = "";
$flddesc = "";
$fldidentificationno = "";
$fldcontact = "";
$fldphone = "";
$fldmobile = "";
$fldemail = "";
$fldaddress = "";
$fldcity = "";
$fldstate = "";
$fldpostcode = "";
$fldcountry = "";
$fldunits = "";
$fldcurrency = "";
$flddatecreated = "";
$flddatemodified = "";
// Load current values...
$dbselect = "select " .
    "c1.name," .
    "c1.desc," .
    "c1.identificationno," .
    "DATE_FORMAT(c1.datecreated,\"%Y-%m-%d %H:%i\") datecreated," .
    "DATE_FORMAT(c1.datemodified,\"%Y-%m-%d %H:%i\") datemodified," .
    "c1.contact," .
    "c1.phone," .
    "c1.mobile," .
    "c1.email," .
    "c1.address," .
    "c1.city," .
    "c1.state," .
    "c1.postcode," .
    "c1.country," .
    "c1.currency," .
    "c1.units " .
    "from " .
    "cust c1 " .
    "where " .
    "c1.id=" . $_SESSION['custid'];
if ($dbresult = SharedQuery($dbselect, $dblink))
{
    if ($numrows = SharedNumRows($dbresult))
    {
        while ($dbrow = SharedFetchArray($dbresult))
        {
            $fldname = $dbrow['name'];
            $flddesc = $dbrow['desc'];
            $fldidentificationno = $dbrow['identificationno'];
            $fldcontact = $dbrow['contact'];
            $fldphone = $dbrow['phone'];
            $fldmobile = $dbrow['mobile'];
            $fldemail = $dbrow['email'];
            $fldaddress = $dbrow['address'];
            $fldcity = $dbrow['city'];
            $fldstate = $dbrow['state'];
            $fldcountry = $dbrow['country'];
            $fldpostcode = $dbrow['postcode'];
            $fldunits= $dbrow['units'];
            $fldcurrency = $dbrow['currency'];
            $flddatecreated = $dbrow['datecreated'];
            $flddatemodified = $dbrow['datemodified'];
            //populateCountries("fldCountry","fldState",$fldcountry,$fldstate);
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- <script src="countries.js"></script> -->
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBqCHDj475c_6YSc9yqwBH3eN1bYovqtUE&libraries=places&callback=initAutocomplete" async defer></script>
    <script type="text/javascript">
    function initAutocomplete() 
    {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        console.log("I am in");
        autocomplete = new google.maps.places.Autocomplete(/** @type {!HTMLInputElement} */(document.getElementById('fldAddress')),{types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        google.maps.event.addListener
        (
            autocomplete,
            'place_changed',
            function()
            {
                var place = autocomplete.getPlace();

                if (!_.isUndefined(place.address_components))
                {
                    if (place.address_components.length == 8)
                    {
                        console.log("length 8");
                        console.log(place.address_components);
                        //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                        document.getElementById('fldAddress').value = place.name
                        //$('#fldCity').textbox('setValue', place.address_components[3].short_name);
                        document.getElementById('fldCity').value = place.address_components[3].short_name;
                        //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[7].short_name);
                        document.getElementById('fldState').value = place.address_components[5].short_name;
                        // $('#fldState').combobox('setValue', place.address_components[5].short_name);
                        document.getElementById('fldCountry').value = place.address_components[6].long_name;
                        document.getElementById('fldPostcode').value = place.address_components[7].short_name;  
                    }
                    else if (place.address_components.length == 9)
                    {
                        console.log("length 9");
                        console.log(place.address_components);
                        //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                        document.getElementById('fldAddress').value = place.name
                        //$('#fldCity').textbox('setValue', place.address_components[3].short_name);
                        document.getElementById('fldCity').value = place.address_components[3].short_name;
                        //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[7].short_name);
                        document.getElementById('fldState').value = place.address_components[5].short_name;
                        // $('#fldState').combobox('setValue', place.address_components[5].short_name);
                        document.getElementById('fldCountry').value = place.address_components[6].long_name;
                        document.getElementById('fldPostcode').value = place.address_components[7].short_name;
                    }
                    else
                    {
                        console.log("other");
                        console.log(place.address_components);
                        //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                        document.getElementById('fldAddress').value = place.name;
                        //$('#fldNewBookingCustCity').textbox('setValue', place.address_components[2].short_name);
                        document.getElementById('fldCity').value = place.address_components[2].short_name;
                        //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[6].short_name);
                        document.getElementById('fldState').value = place.address_components[4].short_name;
                        document.getElementById('fldCountry').value = place.address_components[5].long_name;
                        document.getElementById('fldPostcode').value = place.address_components[6].short_name;
                    }
                }
            }
        );
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() 
    {
        if (navigator.geolocation) 
        {
            navigator.geolocation.getCurrentPosition(function(position) {
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
    <?php
        include ("meta.php");
    ?>
    <title>Remedy Test & Tag - Company</title>
</head>
<body>
    <?php
    include("top.php");
    ?>
    <hr />

    <div class="profileDIV form-group container">
        <label><?php if ($clientmsg != "") echo $clientmsg; else echo date("l, F j, Y"); ?></label>
        <h2 class="clientTitle">BUSINESS DETAILS</h2>
        <!--                                <div>-->
        <form action="profile.php" method="post" id="frmDetails">
            <table id="table_BusinessDetails" class="col table table-borderless">
                <tr>
                    <!-- <td align="left" valign="top">Company Name:</td> -->
                    <td align="left" valign="top" colspan="4">
                        <input id="fldName" name="fldName" type="text" size="20" placeholder="COMPANY NAME" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldname); ?>" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <!-- <td align="left" valign="top">Trading Name:</td> -->
                    <td align="left" valign="top" colspan="4">
                        <input id="fldDesc" name="fldDesc" type="text" size="40" placeholder="TRADING NAME" maxlength="<?php echo AT_MAXNOTE; ?>" value="<?php echo SharedPrepareDisplayString($flddesc); ?>" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <!-- <td align="left" valign="top">Business Identification Number:</td> -->
                    <td align="left" valign="top" colspan="2" style="width: 50%">
                        <input id="fldidentificationno" name="fldidentificationno" type="text" size="40" placeholder="BUSINESS ID NUMBER(ABN/EIN/VAT)" maxlength="<?php echo AT_MAXIDENTIFICATIONNO; ?>" value="<?php echo SharedPrepareDisplayString($fldidentificationno); ?>" class="form-control" />
                    </td>
                    <td align="left" valign="top" colspan="2">
                        <input id="fldContact" name="fldContact" type="text" size="20" placeholder="CONTACT NAME" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldcontact); ?>" class="form-control" />
                    </td>
                </tr>

                <tr>
                    <!-- <td align="left" valign="top">Phone:</td> -->
                    <td align="left" valign="top" colspan="2">
                        <input id="fldPhone" name="fldPhone" type="text" size="20" placeholder="PHONE" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldphone); ?>" class="form-control" />
                    </td>
                    <td align="left" valign="top" colspan="2">
                        <input id="fldMobile" name="fldMobile" type="text" size="20" placeholder="MOBILE (Number only and no less than 6 digi)" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>" class="form-control" required pattern="^[0-9]{6,}$"/>
                        <div id="frmDetails_fldMobile_errorloc" class="error_strings"></div>
                    </td>
                </tr>
                <tr>
                    <!-- <td align="left" valign="top">Email:</td> -->
                    <td align="left" valign="top" style="width: 25%">
                        <input id="fldEmail" name="fldEmail" type="text" size="20" placeholder="EMAIL" maxlength="<?php echo AT_MAXEMAIL; ?>" value="<?php echo SharedPrepareDisplayString($fldemail); ?>" class="form-control" />
                        <div id="frmDetails_fldEmail_errorloc" class="error_strings"></div>
                    </td>
                </tr>
                <!-- <tr>
                    <!-- <td align="left" valign="top">Country:</td> -->
                    <!-- <td align="left" valign="top" colspan="2">
                        <select id="fldCountry" name="fldCountry" class="form-control"></select>
                    </td> -->
                <!-- </tr>  -->
                <tr>
                    <!-- <td align="left" valign="top">Address:</td> -->
                    <td align="left" valign="top" colspan="4">
                        <input id="fldAddress" name="fldAddress" type="text" size="40" placeholder="ADDRESS" maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldaddress); ?>" class="form-control" onFocus="geolocate()" />
                    </td>
                </tr>
                <tr>
                    <!-- <td align="left" valign="top">City:</td> -->
                    <td style="width:25%">
                        <input id="fldCity" name="fldCity" type="text" size="40" placeholder="CITY" maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldcity); ?>" class="form-control" />
                    </td>
                    <td align="left" style="width:25%">
                        <!-- <select id="fldState" name="fldState" class="form-control"></select> -->
                        <input class="form-control" id="fldState" name="fldState" type="text"  placeholder="STATE" size="40"  value="<?php echo SharedPrepareDisplayString($fldstate); ?>" onchange="ShowMap();" />
                    </td>
                    <td align="left" valign="top" style="width:25%">
                        <input id="fldPostcode" name="fldPostcode" type="text" size="8" placeholder="P/CODE" maxlength="<?php echo AT_MAXPOSTCODE; ?>" value="<?php echo SharedPrepareDisplayString($fldpostcode); ?>" class="form-control" />
                        <div id="frmDetails_fldPostcode_errorloc" class="error_strings"></div>
                    </td>
                    <td align="left" valign="top" style="width: 25%">
                        <input class="form-control" id="fldCountry" name="fldCountry" type="text"  placeholder="COUNTRY" size="40" value="<?php echo SharedPrepareDisplayString($fldcountry); ?>" />
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" colspan="4"><span class="myhr"></span></td>
                </tr>
                <tr>
                    <td>Units:

                            <select id="fldUnits" name="fldUnits" class="custom-select mt-0">
                                <option value="mm" <?php if ($fldunits == "mm" or $fldunits == "") echo "selected=\"selected\""; ?>>mm</option>
                                <option value="inches" <?php if ($fldunits == "inches") echo "selected=\"selected\""; ?>>inches</option>
                            </select>

                    </td>
                    <td>
                        Currency:
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span id="span_symbol" class="input-group-text"></span>
                            </div>
                            <select name="fldcurrency" id="fldcurrency" class="custom-select" onchange="showCurrencySymbol(this);">
                                <option value="0">Please select</option>
                            </select>
                        </div>

                        <!--                            </div>-->
                        <div style="display:none;">
                            <script type="text/javascript">
                                var fldcurrency = "<?php echo SharedPrepareDisplayString($fldcurrency); ?>";

                            </script>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <!-- <td align="left" valign="top">&nbsp;</td> -->
                    <td align="right" valign="top" colspan="4">
                        <input id="btnSave2" type="submit" value="SAVE" />
                    </td>

                </tr>
            </table>
        </form>
        <script type="text/javascript">
            var frmvalidator = new Validator("frmDetails");
            frmvalidator.EnableOnPageErrorDisplay();
            //frmvalidator.addValidation("fldPostCode", "regexp=^[0-9]{4}$", "Postcode must be 4 digits");
            // frmvalidator.addValidation("fldMobile", "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$", "Must be in 04xxyyyzzz or xxxxyyyy format");
            frmvalidator.addValidation("fldMobile", "regex=^(?=\d)\S{6,}", "Invalid Phone number"); //numbers only, at least six digits
        </script>
        <form action="#" method="post">
            <textarea class="ckeditor" name="editor" id="editor">
                <?php
                //echo file_get_contents("default.html");
                $custid = $_SESSION['custid'];
                if (file_exists("quoteEmailTemplate/$custid.html") == true)
                {
                    echo file_get_contents("quoteEmailTemplate/$custid.html");
                }
                else
                {
                    echo file_get_contents("quoteEmailTemplate/generalTemplate.html");
                }
                ?>
            </textarea>
            <input type="submit" value="save Template" name="saveTemplate">
        </form>

    </div>
    <!-- <script language="javascript">
        $country = "<?php echo SharedPrepareDisplayString($fldcountry); ?>"
        $state = "<?php echo SharedPrepareDisplayString($fldstate); ?>"
        //  console.log($country);
        //  console.log($state);
        populateCountries("fldCountry", "fldState", $country, $state);

    </script> -->
    <!-- end #content -->
    <?php
    include("left.php");
    ?>

    <div style="clear: both;">&nbsp;</div>
    <?php
    include("bottom.php");
    ?>
</body>
</html>
