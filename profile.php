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
    error_log($fldcountry);
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
                "cust.name=" .SharedNullOrQuoted($fldname, $dblink) . "," .
                "cust.desc=" .SharedNullOrQuoted($flddesc, $dblink) . "," .
                "cust.identificationno=" .SharedNullOrQuoted($fldidentificationno, $dblink) . "," .
                "contact=" .SharedNullOrQuoted($fldcontact, $dblink) . "," .
                "phone=" .SharedNullOrQuoted($fldphone, $dblink) . "," .
                "mobile=" .SharedNullOrQuoted($fldmobile, $dblink) . "," .
                "email=" .SharedNullOrQuoted($fldemail, $dblink) . "," .
                "address=" .SharedNullOrQuoted($fldaddress, $dblink) . "," .
                "city=" .SharedNullOrQuoted($fldcity, $dblink) . "," .
                "state=" .SharedNullOrQuoted($fldstate, $dblink) . "," .
                "postcode=" .SharedNullOrQuoted($fldpostcode, $dblink) . "," .
                "country=" .SharedNullOrQuoted($fldcountry, $dblink) . "," .
                "units=" .SharedNullOrQuoted($fldunits, $dblink) . "," .
                "currency=" .SharedNullOrQuoted($fldcurrency, $dblink) . "," .
                "datemodified=CURRENT_TIMESTAMP " .
                "where " .
                "id=" . $_SESSION['custid'];
    error_log($dbupdate);
    if (mysql_query($dbupdate, $dblink))
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
  if ($dbresult = mysql_query($dbselect, $dblink))
  {
    if ($numrows = mysql_num_rows($dbresult))
    {
      while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
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
        <script src="countries.js"></script>
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

        <div class="profileDIV form-group">
            <label><?php if ($clientmsg != "") echo $clientmsg; else echo date("l, F j, Y"); ?></label>
            <h2 class="clientTitle">BUSINESS DETAILS</h2>
            <!--                                <div>-->
            <form action="profile.php" method="post" id="frmDetails">
                <table id="table_BusinessDetails">
                    <tr>
                        <!-- <td align="left" valign="top">Company Name:</td> -->
                        <td align="left" valign="top" colspan="4">
                            <input id="fldName" name="fldName" type="text" size="20" placeholder="COMPANY NAME" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldname); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <!-- <td align="left" valign="top">Trading Name:</td> -->
                        <td align="left" valign="top" colspan="4">
                            <input id="fldDesc" name="fldDesc" type="text" size="40" placeholder="TRADING NAME" maxlength="<?php echo AT_MAXNOTE; ?>" value="<?php echo SharedPrepareDisplayString($flddesc); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <!-- <td align="left" valign="top">Business Identification Number:</td> -->
                        <td align="left" valign="top" colspan="2" style="width: 50%">
                            <input id="fldidentificationno" name="fldidentificationno" type="text" size="40" placeholder="BUSINESS ID NUMBER(ABN/EIN/VAT)" maxlength="<?php echo AT_MAXIDENTIFICATIONNO; ?>" value="<?php echo SharedPrepareDisplayString($fldidentificationno); ?>" />
                        </td>
                        <td align="left" valign="top" colspan="2">
                            <input id="fldContact" name="fldContact" type="text" size="20" placeholder="CONTACT NAME" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldcontact); ?>" />
                        </td>
                    </tr>
    
                    <tr>
                        <!-- <td align="left" valign="top">Phone:</td> -->
                        <td align="left" valign="top" colspan="2">
                            <input id="fldPhone" name="fldPhone" type="text" size="20" placeholder="PHONE" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldphone); ?>" />
                        </td>
                        <td align="left" valign="top" colspan="2">
                            <input id="fldMobile" name="fldMobile" type="text" size="20" placeholder="MOBILE" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>" />
                            <div id="frmDetails_fldMobile_errorloc" class="error_strings"></div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td align="left" valign="top">Email:</td> -->
                        <td align="left" valign="top" style="width: 25%">
                            <input id="fldEmail" name="fldEmail" type="text" size="20" placeholder="EMAIL" maxlength="<?php echo AT_MAXEMAIL; ?>" value="<?php echo SharedPrepareDisplayString($fldemail); ?>" />
                            <div id="frmDetails_fldEmail_errorloc" class="error_strings"></div>
                        </td>
                    </tr>
                    <tr>
                                        <!-- <td align="left" valign="top">Country:</td> -->
                        <td align="left" valign="top" colspan="2">
                            <select id="fldCountry" name="fldCountry" style="width: 100%"></select>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <!-- <td align="left" valign="top">Address:</td> -->
                        <td align="left" valign="top" colspan="4">
                            <input id="fldAddress" name="fldAddress" type="text" size="40" placeholder="ADDRESS" maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldaddress); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <!-- <td align="left" valign="top">City:</td> -->
                        <td align="left" valign="top" colspan="2">
                            <input id="fldCity" name="fldCity" type="text" size="40" placeholder="CITY" maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldcity); ?>" />
                        </td>
                        <td align="left" valign="top">
                            <select id="fldState" name="fldState" style="width: 100%;margin-top: 8px"></select>
                        </td>
                        <td align="left" valign="top">
                            <input id="fldPostcode" name="fldPostcode" type="text" size="8" placeholder="P/CODE" maxlength="<?php echo AT_MAXPOSTCODE; ?>" value="<?php echo SharedPrepareDisplayString($fldpostcode); ?>" />
                            <div id="frmDetails_fldPostcode_errorloc" class="error_strings"></div>
                        </td>
                    </tr>              
                    <tr>
                        <td align="left" valign="top" colspan="4"><span class="myhr"></span></td>
                    </tr>
                    <tr>
                        <td>Units:
                            <select id="fldUnits" name="fldUnits" style="width: 60%">
                                <option value="mm" <?php if ($fldunits == "mm" or $fldunits == "") echo "selected=\"selected\""; ?>>mm</option>
                                <option value="inches" <?php if ($fldunits == "inches") echo "selected=\"selected\""; ?>>inches</option>
                            </select>
                        </td>
                        <td colspan="3">
                            Currency:
                            <input id="fldcurrency" name="fldcurrency" type="text" size="40" placeholder="CURRENCY" style="width: 20%" maxlength="<?php echo AT_MAXCURRENCY; ?>" value="<?php echo SharedPrepareDisplayString($fldcurrency); ?>" />
                        </td>
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
                frmvalidator.addValidation("fldMobile", "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$", "Must be in 04xxyyyzzz or xxxxyyyy format");

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
        <script language="javascript">
            $country = "<?php echo SharedPrepareDisplayString($fldcountry); ?>"
            $state = "<?php echo SharedPrepareDisplayString($fldstate); ?>"
            //  console.log($country);
            //  console.log($state);
            populateCountries("fldCountry", "fldState", $country, $state);
        </script>
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
