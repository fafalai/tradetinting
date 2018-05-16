<?php
  include("logincheck.php");
  include("remedyerrcodes.php");
  include("class.phpmailer.php");
  $dblink = SharedConnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php
    require_once("meta.php");
  ?>
  <title>Remedy Tinting - Login</title>
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
            <p class="meta"><span class="date"><?php echo date("l, F j, Y"); ?></span></p>
            <h2 class="title">Login</h2>
            <div class="entry">
              <form action="login.php" method="post" id="frmLogin">
                <table align="left">
                  <tr>
                    <td align="left" valign="top">User name:</td>
                    <td align="left" valign="top"><input id="fldUid" name="fldUid" type="text" size="20" maxlength="<?php echo AT_MAXNAME; ?>" /><div id="frmLogin_fldUid_errorloc" class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Password:</td>
                    <td align="left" valign="top"><input id="fldPwd" name="fldPwd" type="password" size="20" maxlength="<?php echo AT_MAXPWD; ?>" /><div id="frmLogin_fldPwd_errorloc" class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><input id="btnLogin" type="submit" value="Login" /></td>
                  </tr>
                </table>
                <a href="http://www.positivessl.com" target="_blank"><img src="images/PositiveSSL_tl_trans.gif" width="98" height="98" alt="Secured by Comodo" longdesc="http://www.positivessl.com" /></a>
              </form>
              <script type="text/javascript">
                var frmvalidator  = new Validator("frmLogin");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.addValidation("fldUid", "req", "Please enter your User ID");
                frmvalidator.addValidation("fldUid", "maxlen=<?php echo AT_MAXNAME; ?>", "Max length is <?php echo AT_MAXNAME; ?>");
                frmvalidator.addValidation("fldPwd", "req", "Please enter your Password");
                frmvalidator.addValidation("fldPwd", "maxlen=<?php echo AT_MAXPWD; ?>", "Max length is <?php echo AT_MAXPWD; ?>");
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      include("feature.php");
    ?>

    <div style="clear: both;">&nbsp;</div>
    <?php
      include("bottom.php");
    ?>
    <!-- end #footer -->
  </div>
</body>
</html>
