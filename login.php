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
  <div>
     <div class="loginBackground">
        <div style="margin:0 auto;width:700px;padding-top: 30pt">
            <p class="meta"><span class="date"><?php echo date("l, F j, Y");?></span></p>
            <h1 class="loginTitle">LOGIN</h1>
            <div class="entry">
                    <form action="login.php" method="post" id="frmLogin" style="margin-top: 20px;">
                      <table align="left" style="width:85%">
                        <tr>
                          <!-- <td align="left" valign="top">User name:</td> -->
                          <td align="left" valign="top" style="width:100%">
                            <input id="fldUid" name="fldUid"  placeholder="USERNAME" type="text"  maxlength="<?php echo AT_MAXNAME; ?>" />
                            <div id="frmLogin_fldUid_errorloc" class="error_strings"></div>
                          </td>
                        </tr>
                        <tr>
                          <!-- <td align="left" valign="top">Password:</td> -->
                          <td align="left" valign="top" style="width:100%">
                            <input id="fldPwd" name="fldPwd" placeholder="PASSWORD" type="password" class="loginInput" maxlength="<?php echo AT_MAXPWD; ?>" style="width:100%" />
                            <div id="frmLogin_fldPwd_errorloc" class="error_strings"></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" style="width: 50%">
                            <input id="btnLogin" type="submit" value="Login"/>
                          </td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                      </table>
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
    <?php
//      include("feature.php");
    ?>

    <div style="clear: both;">&nbsp;</div>
    <?php
      include("bottom.php");
    ?>
    <!-- end #footer -->
  </div>
</body>
</html>
