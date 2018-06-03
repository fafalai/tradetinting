<?php
  include("logincheck.php");
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/users.php');
    //exit;
  }
  require_once("remedyerrcodes.php");
  $dblink = SharedConnect();
  $usermsg = "";
  $cmd = AT_CMDCREATE;
  $userid = 0;
  //
  $flduid = "";
  $fldname = "";
  $fldemail = "";
  $fldlicense = "";
  $fldmobile = "";
  $c_id=$_SESSION['custid'];
  $usr_id=$_SESSION['loggedin'];
  //

  $dateday= date("Y-m-d H:i:s");
  $dbselect = "select " .
              "u1.id " .
              "from " .
              "users u1 " .
              "where " .
              "u1.cust_id='$c_id'";
  if ($dbresult = SharedQuery($dbselect, $dblink))
    $numrows = SharedNumRows($dbresult);
  //
  if (isset($_GET['cmd']))
  {
    $cmd = intval(SharedCleanString($_GET['cmd'], AT_MAXBIGINT));
    $userid = isset($_GET['id']) ? intval(SharedCleanString($_GET['id'], AT_MAXBIGINT)) : 0;

    if ($cmd == AT_CMDMODIFY)
    {
      // Double check licexpired is null and this belongs to this customer...
      $dateday = date("Y-m-d H:i:s");
      $dbselect = "select " .
                  "u1.uid," .
                  "u1.name," .
                  "u1.email," .
                  "u1.mobile " .
                  "from " .
                  "users u1 " .
                  "where " .
                  "u1.id=" . $userid . " " .
                  "and " .
                  "u1.cust_id=" . $_SESSION['custid'];
      if ($dbresult = SharedQuery($dbselect, $dblink))
      {
        if ($numrows = SharedNumRows($dbresult))
        {
          $url = "";
          while ($dbrow = SharedFetchArray($dbresult))
          {
            $flduid = $dbrow['uid'];
            $fldname = $dbrow['name'];
            $fldemail = $dbrow['email'];
            $fldmobile = $dbrow['mobile'];
          }
        }
      }
    }
    else if ($cmd == AT_CMDDELETE)
    {
      $dbupdate = "update " .
                  "users " .
                  "set " .
                  "dateexpired=CURRENT_TIMESTAMP," .
                  "licexpired=CURRENT_TIMESTAMP," .
                  "usersexpired_id=" . $_SESSION['loggedin'] . " " .
                  "where " .
                  "id=" . $userid . " " .
                  "and " .
                  "cust_id=" . $_SESSION['custid'];
        SharedQuery($dbupdate, $dblink);
      //
      $cmd = AT_CMDCREATE;
      $userid = 0;
    }
    else
      $clientid = 0;
  }
  else if (isset($_POST['fldUid']))
  {
    $flduid = SharedCleanString($_POST['fldUid'], AT_MAXNAME);
    $fldname = SharedCleanString($_POST['fldName'], AT_MAXNAME);
    $fldpwd = SharedCleanString($_POST['fldPwd'], AT_MAXPWD);
    $fldemail = SharedCleanString(isset($_POST['fldEmail']) ? $_POST['fldEmail'] : "", AT_MAXEMAIL);
    $fldmobile = SharedCleanString(isset($_POST['fldMobile']) ? $_POST['fldMobile'] : "", AT_MAXPHONE);
    $active = 1;
    $c_id = $_SESSION['custid'];
    $usr_id = $_SESSION['loggedin'];
    $dt_expired = $_SESSION['dateexpired'];
    //

    $dateday = date("Y-m-d H:i:s");
    $dbselect = "select " .
                "u1.id " .
                "from " .
                "users u1 " .
                "where " .
                "u1.cust_id='$c_id'";
    if ($dbresult = SharedQuery($dbselect, $dblink))
      $numrows = SharedNumRows($dbresult);

    if ($_SESSION['numberUsers'] > $numrows)
    {
      $dbinsert = "INSERT INTO users " .
                  "(" .
                  "cust_id," .
                  "uid," .
                  "pwd," .
                  "name," .
                  "email," .
                  "mobile," .
                  "active," .
                  "licenseno," .
                  "userscreated_id," .
                  "licexpired" .
                  ") " .
                  "VALUES " .
                  "(" .
                  "'$c_id'," .
                  "'$flduid'," .
                  "'$fldpwd'," .
                  "'$fldname'," .
                  "'$fldemail'," .
                  "'$fldmobile'," .
                  "'$active'," .
                  "'$fldlicense'," .
                  "'$usr_id'," .
                  "'$dt_expired'" .
                  ")";

      if (SharedQuery($dbinsert, $dblink))
      {
        // Successful save, clear form...
        $usermsg =  "User " . $fldname . " has been added."  ;
        $flduid = "";
        $fldname = "";
        $fldemail = "";
        $fldmobile = "";
        $fldlicense = "";
      }
      else
        $usermsg = "Unable to add " . $fldname . ". Please try again or contact support.";
    }
    else
      $usermsg = "Unable to add " . $fldname . ". Numbers of users exceded. Click  <a  href='profile.php#myplan' class='myButton'>here</a> to upgrade users";
  }
  else if (isset($_POST['fldModName']))
  {
    // Hidden field so we know who we're modifying...
    $userid = intval(SharedCleanString($_POST['fldModUserId'], AT_MAXNAME));
    $flduid = SharedCleanString($_POST['fldModUid'], AT_MAXNAME);
    //
    $fldname = SharedCleanString($_POST['fldModName'], AT_MAXNAME);
    $fldemail = SharedCleanString($_POST['fldModEmail'], AT_MAXEMAIL);
    $fldmobile = SharedCleanString($_POST['fldModMobile'], AT_MAXPHONE);
    $fldlicense = SharedCleanString($_POST['fldModLicense'], AT_MAXCODE);
    //
    $dbupdate = "update " .
                "users " .
                "set " .
                "users.name=" . SharedNullOrQuoted($fldname,50, $dblink) . "," .
                "users.email=" . SharedNullOrQuoted($fldemail, 50,$dblink) . "," .
                "users.mobile=" . SharedNullOrQuoted($fldmobile,50, $dblink) . "," .
                "users.licenseno=" . SharedNullOrQuoted($fldlicense,50, $dblink) . "," .
                "datemodified=CURRENT_TIMESTAMP," .
                "usersmodified_id=" . $_SESSION['loggedin'] . " "  .
                "where " .
                "id=" . $userid . " " .
                "and " .
                "cust_id=" . $_SESSION['custid'];
    if (SharedQuery($dbupdate, $dblink))
      $usermsg = "User " . $usermsg . " has been updated.";
    else
      $usermsg = "Unable to save " . $fldname . ". Please try again or contact support.";
    // Stay in modify mode...
    $cmd = AT_CMDMODIFY;
  }
  else if (isset($_POST['fldPwd']))
  {
    // Hidden field so we know who we're modifying...
    $userid = intval(SharedCleanString($_POST['fldPwdUserId'], AT_MAXNAME));
    $flduid = SharedCleanString($_POST['fldPwdUid'], AT_MAXNAME);
    $fldname = SharedCleanString($_POST['fldPwdName'], AT_MAXNAME);
    //
    $fldpwd = SharedCleanString($_POST['fldPwd'], AT_MAXPWD);
    //
    $dbupdate = "update " .
                "users " .
                "set " .
                "pwd=" . SharedNullOrQuoted($fldpwd,50, $dblink) . "," .
                "datemodified=CURRENT_TIMESTAMP," .
                "usersmodified_id=" . $_SESSION['loggedin'] . " "  .
                "where " .
                "id=" . $userid . " " .
                "and " .
                "cust_id=" . $_SESSION['custid'];
    if (SharedQuery($dbupdate, $dblink))
      $usermsg = "User " . $usermsg . "'s password has been updated.";
    else
      $usermsg = "Unable to save " . $fldname . "'s password. Please try again or contact support.";
    // Stay in modify mode...
    $cmd = AT_CMDMODIFY;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php
    include ("meta.php");
  ?>
  <script type="text/javascript">
    function OnFormLoad()
    {
      <?php
        if ($cmd == AT_CMDCREATE)
        {
      ?>
          $('#fldName').focus();
      <?php
        }
        else
        {
      ?>
          $('#fldModName').focus();
      <?php
        }
      ?>
    }

    function DeleteUser(id, itemname)
    {
      if (confirm('Are you sure you wish to delete ' + itemname))
      {
        window.location = 'users.php?cmd=<?php echo AT_CMDDELETE; ?>&id=' + id;
      }
    }

    function CheckUserId()
    {
      var uid = $('#fldUid').val();
      var data = {uid: uid};

      $.ajax
      (
        {
          url: 'checkuidavail.php',
          type: 'POST',
          data: data,
          cache: false,
          success: function(rc)
          {
            var response = JSON.parse(rc);
            if (response.rc == <?php echo REMEDY_ERR_NONE; ?>)
            {
              if (response.id != 0)
              {
                alert('That User ID is not available, please choose another');
                $('#fldUid').val('');
                $('#fldUid').focus();
              }
            }
          }
        }
      );
    }

    onload=OnFormLoad;
  </script>
  <title>Remedy Tinting - Users</title>
</head>
<body>
  <?php
    include("top.php");
  ?>
  <hr />
  <div>
    <div>
      <div>
        <div style="margin-top: 30pt">
          <div class="existingUsersDIV">
            <label><?php if ($clientmsg != "") echo $clientmsg; else echo date("l, F j, Y"); ?></label>
            <h2 class="clientTitle">Existing Users</h2>
            <label>Move mouse over links for tips. Click on table header to sort by that column.</label>
            <div style="margin-bottom: 30px">
              <table border="0" align="center" id="tblUsers" rules="cols" frame="box" class="sortable">
                <tr>
                  <th align="left">User ID</th>
                  <th align="left">Name</th>
                  <th align="right">Date Modified</th>
                  <th align="center" class="unsortable">Action</th>
                </tr>
                <?php
                  $dateday= date("Y-m-d H:i:s");
                  $dbselect = "select " .
                              "u1.id," .
                              "u1.uid," .
                              "u1.name," .
                              "u1.email," .
                              "u1.mobile," .
                              "u1.admin," .
                              "DATE_FORMAT(u1.datecreated,\"%Y-%m-%d %H:%i\") datecreated," .
                              "DATE_FORMAT(u1.datemodified,\"%Y-%m-%d %H:%i\") datemodified " .
                              "from " .
                              "users u1 " .
                              "where " .
                              "u1.cust_id=" . $_SESSION['custid'];

                  if ($dbresult = SharedQuery($dbselect, $dblink))
                  {
                    if ($numrows = SharedNumRows($dbresult))
                    {
                      while ($dbrow = SharedFetchArray($dbresult))
                      {
                        $emailtip = "";
                        $email = $dbrow['email'];
                        $mobile = $dbrow['mobile'];
                        $name = $dbrow['name'];
                        $admin= $dbrow['admin'];
                        if (($email != "") || ($mobile != ""))
                          $emailtip = SharedPrepareToolTip("<ul><li>Email: $email</li><li>Mobile: $mobile</li></ul>");
                        $deletetip = SharedPrepareToolTip("Delete user: <strong>" . $dbrow['name'] . "</strong>");
                ?>
                <tr>
                  <td align="left"><a href="users.php?cmd=<?php echo AT_CMDMODIFY; ?>&id=<?php echo $dbrow['id']; ?>"><?php echo SharedPrepareDisplayString($dbrow['uid']); ?></a></td>
                  <td align="left"><a href="users.php?cmd=<?php echo AT_CMDMODIFY; ?>&id=<?php echo $dbrow['id']; ?>"><span onmouseover="tooltip.show('<?php echo $emailtip; ?>');" onmouseout="tooltip.hide();"><?php echo SharedAddEllipsis($name, 30); ?></span></a></td>
                  <td align="right"><?php if ($dbrow['datemodified'] == "") echo $dbrow['datecreated']; else echo $dbrow['datemodified']; ?></td>
                  <td align="center">
                    <?php
                      if ($admin == 1)
                      {
                    ?>
                        <a href="javascript:void(0);" onclick="DeleteUser(<?php echo $dbrow['id'] . ",'" . $name . "'"; ?>);"><span onmouseover="tooltip.show('<?php echo $deletetip; ?>');" onmouseout="tooltip.hide();"><img src="images/icon-delete.png" width="25" height="17" alt="Delete" /></span></a>
                    <?php
                      }
                    ?>
                  </td>
                </tr>
                  <?php
                        }
                      }
                    }
                  ?>
              </table>

            </div>
          </div>
          <div class="usersDIV">
            <h2 class="clientTitle">Add/Modify Users</h2>
            <div class="entry">
              <?php
                if ($cmd == AT_CMDCREATE)
                {
              ?>
                  <form action="users.php" method="post" id="frmUsers">
                    <table style="width: 100%">
                      <tr>
                        <td  colspan="2"> <span id="msgerr1"></span></td>
                      </tr>
                      <tr>
                          <!-- <td align="left" valign="top">&nbsp;</td> -->
                        <td align="left" valign="top"><a href="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" class="myButton">Create New</a></td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Name:</td> -->
                        <td align="left" valign="top">
                          <input id="fldName" name="fldName" type="text" size="20" placeholder="Name" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldname); ?>"  />
                          <div id="frmUsers_fldName_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">User ID:</td> -->
                        <td align="left" valign="top">
                          <input id="fldUid" name="fldUid" type="text" size="20" placeholder="User ID" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($flduid); ?>" onchange="CheckUserId();" />
                          <div id="frmUsers_fldUid_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Password:</td> -->
                        <td align="left" valign="top">
                          <input id="fldPwd" name="fldPwd" type="password" size="20" placeholder="password" maxlength="<?php echo AT_MAXPWD; ?>" />
                          <div id="frmUsers_fldPwd_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Confirm:</td> -->
                        <td align="left" valign="top">
                          <input id="fldConfirmPwd" name="fldConfirmPwd" type="password" size="20" placeholder="Repeat Password" maxlength="<?php echo AT_MAXPWD; ?>" />
                          <div id="frmUsers_fldConfirmPwd_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Email:</td> -->
                        <td align="left" valign="top">
                          <input id="fldEmail" name="fldEmail" type="text" size="20" placeholder="Email" maxlength="<?php echo AT_MAXEMAIL; ?>" value="<?php echo SharedPrepareDisplayString($fldemail); ?>" />
                          <div id="frmUsers_fldEmail_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Mobile:</td> -->
                        <td align="left" valign="top">
                          <input id="fldMobile" name="fldMobile" type="text" size="20" placeholder="Mobile" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>" />
                          <div id="frmUsers_fldMobile_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">&nbsp;</td> -->
                        <td align="left" valign="top"><input id="btnSave" type="submit" value="Save"  /></td>
                      </tr>
                    </table>
                  </form>
                  <script type="text/javascript">
                    var frmvalidator  = new Validator("frmUsers");
                    frmvalidator.EnableOnPageErrorDisplay();
                    frmvalidator.addValidation("fldName", "req", "Please enter your real Name");
                    frmvalidator.addValidation("fldName", "maxlen=<?php echo AT_MAXNAME; ?>", "Max length is <?php echo AT_MAXNAME; ?>");
                    frmvalidator.addValidation("fldUid", "req", "Please enter your preferred User ID");
                    frmvalidator.addValidation("fldUid", "maxlen=<?php echo AT_MAXNAME; ?>", "Max length is <?php echo AT_MAXNAME; ?>");
                    frmvalidator.addValidation("fldPwd", "req", "Please enter your password");
                    frmvalidator.addValidation("fldPwd", "maxlen=<?php echo AT_MAXPWD; ?>", "Max length is <?php echo AT_MAXPWD; ?>");
                    frmvalidator.addValidation("fldPwd", "minlen=5", "Must be at least 5 characters and not too simple");
                    frmvalidator.addValidation("fldConfirmPwd", "req", "Please re-enter your password");
                    frmvalidator.addValidation("fldConfirmPwd", "maxlen=<?php echo AT_MAXPWD; ?>", "Max length is <?php echo AT_MAXPWD; ?>");
                    frmvalidator.addValidation("fldConfirmPwd", "eqelmnt=fldPwd", "Passwords don't match, please try again");
                    frmvalidator.addValidation("fldEmail", "maxlen=<?php echo AT_MAXEMAIL; ?>", "Max length is <?php echo AT_MAXEMAIL; ?>");
                    frmvalidator.addValidation("fldEmail", "email", "Please enter a valid email address");
                    frmvalidator.addValidation("fldMobile","maxlen=<?php echo AT_MAXPHONE;?>",	"Max length is <?php echo AT_MAXPHONE;?>");
                    frmvalidator.addValidation("fldMobile","regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$","Must be in 04xxyyyzzz or xxxxyyyy format");
                  </script>
              <?php
                }
                else if ($cmd == AT_CMDMODIFY)
                {
              ?>
                  <form action="users.php" method="post" id="frmUsers">
                    <table style="width: 100%">
                      <tr>
                        <!-- <td align="left" valign="top">&nbsp;</td> -->
                        <td align="left" valign="top"><a href="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" class="myButton">Create New</a></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" colspan="2" id-"msgerr" ></td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">User ID:</td> -->
                        <td align="left" valign="top"><?php echo SharedPrepareDisplayString($flduid); ?></td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Name:</td> -->
                        <td align="left" valign="top">
                          <input id="fldModName" name="fldModName" type="text" size="20" placeholder="Name" maxlength="50" class="required" value="<?php echo SharedPrepareDisplayString($fldname); ?>" />
                          <div id="frmUsers_fldModName_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Email:</td> -->
                        <td align="left" valign="top">
                          <input id="fldModEmail" name="fldModEmail" type="text" size="20" placeholder="Email" maxlength="<?php echo AT_MAXEMAIL; ?>" value="<?php echo SharedPrepareDisplayString($fldemail); ?>" />
                          <div id="frmUsers_fldModEmail_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Mobile:</td> -->
                        <td align="left" valign="top">
                          <input id="fldModMobile" name="fldModMobile" type="text" size="20" placeholder="Mobile" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>" />
                          <div id="frmUsers_fldModMobile_errorloc" class="error_strings"></div>
                        </td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">&nbsp;</td> -->
                        <td align="left" valign="top"><input id="btnSaveUser" type="submit" value="Save" /></td>
                      </tr>
                    </table>
                    <input name="fldModUserId" type="hidden" value="<?php echo SharedPrepareDisplayString($userid); ?>" />
                    <input name="fldModUid" type="hidden" value="<?php echo SharedPrepareDisplayString($flduid); ?>" />
                  </form>
                  <script type="text/javascript">
                    var frmvalidator  = new Validator("frmUsers");
                    frmvalidator.EnableOnPageErrorDisplay();
                    frmvalidator.addValidation("fldModName", "req", "Please enter your real Name");
                    frmvalidator.addValidation("fldModName", "maxlen=<?php echo AT_MAXNAME; ?>", "Max length is <?php echo AT_MAXNAME; ?>");
                    frmvalidator.addValidation("fldModEmail", "maxlen=<?php echo AT_MAXEMAIL; ?>", "Max length is <?php echo AT_MAXEMAIL; ?>");
                    frmvalidator.addValidation("fldModEmail", "email", "Please enter a valid email address");
                    frmvalidator.addValidation("fldModMobile","maxlen=<?php echo AT_MAXPHONE;?>",	"Max length is <?php echo AT_MAXPHONE;?>");
                    frmvalidator.addValidation("fldModMobile","regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$","Must be in 04xxyyyzzz or xxxxyyyy format");
                  </script>

                  <form action="users.php" method="post" id="frmPwd">
                    <table style="width: 100%">
                      <tr>
                        <!-- <td align="left" valign="top" width="80px">&nbsp;</td> -->
                        <td align="left" valign="top">Reset password</td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Password:</td> -->
                        <td align="left" valign="top"><input id="fldPwd" name="fldPwd" type="password" size="20" placeholder="Password" maxlength="50" class="required validate-password" /></td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">Confirm:</td> -->
                        <td align="left" valign="top"><input id="fldConfirmPwd" name="fldConfirmPwd" type="password" placeholder="Repeat Password" size="20" maxlength="50" class="required validate-confirm" /></td>
                      </tr>
                      <tr>
                        <!-- <td align="left" valign="top">&nbsp;</td> -->
                        <td align="left" valign="top"><input id="btnSavePwd" type="submit" value="Save" /></td>
                      </tr>
                    </table>
                    <input name="fldPwdUserId" type="hidden" value="<?php echo SharedPrepareDisplayString($userid); ?>" />
                    <input name="fldPwdUid" type="hidden" value="<?php echo SharedPrepareDisplayString($flduid); ?>" />
                    <input name="fldPwdName" type="hidden" value="<?php echo SharedPrepareDisplayString($fldname); ?>" />
                  </form>
              <?php
                }
              ?>

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
