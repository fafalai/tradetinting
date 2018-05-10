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
  $contactmsg = "";
  if (isset($_POST['fldName']) && isset($_POST['fldPhone']))
  {
    $name = SharedCleanString($_POST['fldName'], AT_MAXNAME);
    $phone = SharedCleanString($_POST['fldPhone'], AT_MAXMOBILE);
    $email = SharedCleanString($_POST['fldEmail'], AT_MAXEMAIL);
    $enquiry = SharedCleanString($_POST['fldEnquiry'], AT_MAXCOMMENTS);
    $body = "<strong>Name:</strong> " . $name . "<br />" .
            "<strong>Mobile:</strong> " . $phone . "<br />" .
            "<strong>Email:</strong> " . $email . "<br />" .
            $enquiry;
    if (SharedSendSimpleHtmlMail($gConfig['smtp-user'], "Remedy Quick Tag Contact Request", "sales@adtalk.com.au", "Remedy Quick Tag", "Remedy Quick Tag Contact", $body))
      $contactmsg = "Thank you for registering. We will notify you ASAP";
    else
      $contactmsg = "There was a problem sending your request, please try again later...";
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php
    include("meta.php");
  ?>
  <title>Remedy Test & Tag - Contact</title>
</head>
<body>
  <?php
    include("top.php");
  ?>
  <hr />
  <div id="page">
    <div id="content">
      <div id="content-bgtop">
        <div id="content-bgbtm">

          <div class="post">
            <p class="meta"><span class="date"><?php if ($contactmsg != "") echo $contactmsg; else echo date("l, F j, Y"); ?></span></p>
            <h2 class="title">Contact Us</h2>
            <div class="entry">

              <form action="contact.php" method="post" id="frmContact">
                <table>
                  <tr>
                    <td align="left" valign="top">Name:</td>
                    <td align="left" valign="top"><input id="fldName" name="fldName" type="text" size="20" maxlength="<?php echo AT_MAXNAME; ?>" /><div id='frmContact_fldName_errorloc' class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Mobile:</td>
                    <td align="left" valign="top"><input id="fldPhone" name="fldPhone" type="text" size="20" maxlength="<?php echo AT_MAXPHONE; ?>" /><div id='frmContact_fldPhone_errorloc' class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Email:</td>
                    <td align="left" valign="top"><input id="fldEmail" name="fldEmail" type="text" size="40" maxlength="<?php echo AT_MAXEMAIL; ?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Enquiry:</td>
                    <td align="left" valign="top"><textarea id="fldEnquiry" name="fldEnquiry" cols="40" rows="5" resize="none"></textarea></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><input id="btnContact" type="submit" value="Submit" /></td>
                  </tr>
                </table>
              </form>
              <script type="text/javascript">
                var frmvalidator  = new Validator("frmContact");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.addValidation("fldName", "req", "Please enter your Name");
                frmvalidator.addValidation("fldName", "alnum_s", "Alpha/numeric and space chars only");
                frmvalidator.addValidation("fldEmail", "email", "Invalid email address format");
                frmvalidator.addValidation("fldPhone", "req", "Please enter your Mobile No.");
                frmvalidator.addValidation("fldPhone", "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$", "Must be in 04xxyyyzzz or xxxxyyyy format");
              </script>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- end #content -->

    <?php
      include("left.php");
    ?>

    <div style="clear: both;">&nbsp;</div>

    <?php
      include("bottom.php");
    ?>
    <!-- end #footer -->
  </div>
</body>
</html>
