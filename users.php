<!-- 
     1 ===  Successfull
     2 ===  Fail 
    
-->
<?php
  include("logincheck.php");
  include ("remedyuuid.php");
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/users.php');
    //exit;
  }
  require_once("remedyerrcodes.php");
  $dblink = SharedConnect();
  $usermsg = "";
  $notification = 0;
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
    error_log($cmd);
    if ($cmd == AT_CMDMODIFY)
    {
      error_log("I am in modify");
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
      error_log("I am in delete");
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
        if (SharedQuery($dbupdate, $dblink))
        {
          $notification = 1;
          $usermsg = "Client " . $fldname . " has been deleted."; 
        }
        else
        {
            $notification = 2;
            $usermsg = "Unable to delete " . $fldname . ". Please try again or contact support.";
        }
      //
      $cmd = AT_CMDCREATE;
      $userid = 0;
    }
    else
      $clientid = 0;
  }
  if (isset($_POST['userfldUid']))
  {
    error_log("I AM IN create");
    $flduid = SharedCleanString($_POST['userfldUid'], AT_MAXNAME);
    $fldname = SharedCleanString($_POST['userfldUid'], AT_MAXNAME);
    $fldpwd = SharedCleanString($_POST['userfldPwd'], AT_MAXPWD);
    $fldemail = SharedCleanString(isset($_POST['fldEmail']) ? $_POST['fldEmail'] : "", AT_MAXEMAIL);
    $fldmobile = SharedCleanString(isset($_POST['fldMobile']) ? $_POST['fldMobile'] : "", AT_MAXPHONE);
    $active = 1;
    $c_id = $_SESSION['custid'];
    $usr_id = $_SESSION['loggedin'];
    // $dt_expired = $_SESSION['dateexpired'];
    $dt_expired = date ('Y-m-d H:i:s', strtotime ( '+1 year' ));
    $numberUsers = $_SESSION['numberUsers'];
    $monthValue = 1;
    $period = 0;
    //

    $dateday = date("Y-m-d H:i:s");
    $dbselect = "select " .
                "u1.id " .
                "from " .
                "users u1 " .
                "where " .
                "u1.cust_id='$c_id'";
    error_log($dbselect);
    if ($dbresult = SharedQuery($dbselect, $dblink))
      $numrows = SharedNumRows($dbresult);
    error_log($numberUsers);
    error_log($numrows);
    if ($numberUsers > $numrows)
    {
      $uuid = RemedyUuid();
      error_log("can create");
      
      $dbinsert = "INSERT INTO users " .
                  "(" .
                  "cust_id," .
                  "uid," .
                  "pwd," .
                  "uuid," .
                  "name," .
                  "email," .
                  "mobile," .
                  "active," .
                  "licenseno," .
                  "userscreated_id," .
                  "licexpired," .
                  "numberUsers," .
                  "monthValue," .
                  "period".
                  ") " .
                  "VALUES " .
                  "(" .
                  "'$c_id'," .
                  "'$flduid'," .
                  "'$fldpwd'," .
                  "'$uuid'," .
                  "'$fldname'," .
                  "'$fldemail'," .
                  "'$fldmobile'," .
                  "'$active'," .
                  "'$fldlicense'," .
                  "'$usr_id'," .
                  "'$dt_expired'," .
                  "'$numberUsers',".
                  "'$monthValue'," .
                  "'$period'".
                  ")";
      error_log($dbinsert);

      if (SharedQuery($dbinsert, $dblink))
      {
        // Successful save, clear form...
        $notification = 1;
        $usermsg =  "User " . $fldname . " has been added."  ;
        $flduid = "";
        $fldname = "";
        $fldemail = "";
        $fldmobile = "";
        $fldlicense = "";
      }
      else
      {
        $notification = 2;
        $usermsg = "Unable to add " . $fldname . ". Please try again or contact support.";
      }
    }
    else
    {
      $notification = 2;
      $usermsg = "Unable to add " . $fldname . ". Numbers of users exceded."; //Click  <a  href='profile.php#myplan' class='myButton'>here</a> to upgrade users
      error_log("numbers of users exceded");
    }
  }
  else if (isset($_POST['fldModName']))
  {
    error_log('fldModName');
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
    error_log($dbupdate);
    if (SharedQuery($dbupdate, $dblink))
    {
      $notification = 1;
      $usermsg = "User " . $usermsg . " has been updated.";
    }
      
    else
    {
      $notification = 2;
      $usermsg = "Unable to update " . $fldname . ". Please try again or contact support.";
    }
     
    // Stay in modify mode...
    $cmd = AT_CMDMODIFY;
  }
  else if (isset($_POST['userfldPwd']))
  {
    // Hidden field so we know who we're modifying...
    error_log("modifyng password");
    $userid = intval(SharedCleanString($_POST['fldPwdUserId'], AT_MAXNAME));
    $flduid = SharedCleanString($_POST['fldPwdUid'], AT_MAXNAME);
    $fldname = SharedCleanString($_POST['fldPwdName'], AT_MAXNAME);
    //
    $fldpwd = SharedCleanString($_POST['userfldPwd'], AT_MAXPWD);
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
    {
      $notification = 1;
      $usermsg = "User " . $usermsg . "'s password has been updated.";
    }
    else
    {
      $notification = 2;
      $usermsg = "Unable to save " . $fldname . "'s password. Please try again or contact support.";
    }
    // Stay in modify mode...
    $cmd = AT_CMDMODIFY;
    error_log($flduid);
  }
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <?php
      include ("meta.php");
    ?>
      <script type="text/javascript">
        $(document).ready(function () {
          var message = "";
          var notification = "";
          message = "<?php if ($usermsg != "
          ") echo $usermsg; else echo 123;?>";
          notification = "<?php if ($notification != "
          ") echo $notification; else echo 123;?>";
          console.log(message);
          console.log(notification);
          if (notification == 1) {
            noty({
              text: message,
              type: 'success',
              timeout: 3000
            });
          } else if (notification == 2) {
            noty({
              text: message,
              type: 'error',
              timeout: 3000
            });
          }
        });

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

        function DeleteUser(id, itemname) {
          if (confirm('Are you sure you wish to delete ' + itemname)) {
            window.location = 'users.php?cmd=<?php echo AT_CMDDELETE; ?>&id=' + id;
          }
        }

        function CheckUserId() {
          var uid = $('#userfldUid').val();
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
                  // alert('This User ID has been taken, please use another one');
                  noty
                  ({
                      text: "This User ID has been taken, please use another one",
                      type: 'error',
                      timeout: 2000
                  });
                  $('#userfldUid').val('');
                  $('#userfldUid').focus();
                }
              }
            }
          });
        }

        onload = OnFormLoad;
      </script>
      <title>Remedy Tinting - Users</title>
  </head>

  <body>
    <?php
      include("top.php");
    ?>
      <div class="container" style="width:70%">
        <div class="existingUsersDIV">
          <label><?php echo date("l, F j, Y"); ?></label>
          <h2 class="clientTitle mb-2">Existing Users</h2>
          <label>Move mouse over links for tips. Click on table header to sort by that column.</label>
          <!-- <div class="container" style="margin-bottom: 30px"> -->
            <div class="container" style="padding:0px">
              <table id="tblUsers" rules="cols" frame="box" class="sortable table table-bordered" style="width:100%">
                <tr>
                  <th style="width:30%" align="left">User ID</th>
                  <th style="width:30%" align="left">Name</th>
                  <th style="width:30%" align="right">Date Modified</th>
                  <?php
                    if ($_SESSION['admin'] == 1)
                    {
                  ?>
                    <th align="center" class="unsortable"style="width:10%">Action</th>
                    <?php
                    }
                  ?>
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
                              "u1.cust_id=" . $_SESSION['custid'] . " " .
                              "and " .
                              "u1.dateexpired is null";

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
                    <td align="left">
                      <a href="users.php?cmd=<?php echo AT_CMDMODIFY; ?>&id=<?php echo $dbrow['id']; ?>">
                        <?php echo SharedPrepareDisplayString($dbrow['uid']); ?>
                      </a>
                    </td>
                    <td align="left">
                      <a href="users.php?cmd=<?php echo AT_CMDMODIFY; ?>&id=<?php echo $dbrow['id']; ?>">
                        <span onmouseover="tooltip.show('<?php echo $emailtip; ?>');" onmouseout="tooltip.hide();">
                          <?php echo SharedAddEllipsis($name, 30); ?>
                        </span>
                      </a>
                    </td>
                    <td align="right">
                      <?php if ($dbrow['datemodified'] == "") echo $dbrow['datecreated']; else echo $dbrow['datemodified']; ?>
                    </td>
                    <td align="center">
                      <?php
                      if ($_SESSION['admin'] == 1)
                      {
                    ?>
                        <a href="javascript:void(0);" onclick="DeleteUser(<?php echo $dbrow['id'] . " , '" . $name . "' "; ?>);">
                          <span onmouseover="tooltip.show('<?php echo $deletetip; ?>');" onmouseout="tooltip.hide();">
                            <img src="images/icon-delete.png" width="25" height="17" alt="Delete" />
                          </span>
                        </a>
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
          <!-- </div> -->
        </div>
        <div class="usersDIV">
          
          <div class="entry" style="width:100%">
            <?php
                if ($cmd == AT_CMDCREATE)
                {
              ?>
              <h2 class="clientTitle">Add Users</h2>
              <form action="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" method="post" id="frmUsers">
                <table style="width: 100%">
                  <tr>
                    <td colspan="2">
                      <span id="msgerr1"></span>
                    </td>
                  </tr>
                  <tr>
                    <!-- <td align="left" valign="top">&nbsp;</td> -->
                    <td align="left" valign="top">
                      <a href="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" class="myButton">Clear fields</a>
                    </td>
                  </tr>

                  <tr>
                    <!-- <td align="left" valign="top">User ID:</td> -->
                    <td align="left" valign="top">
                      <input required id="userfldUid" name="userfldUid" type="text" size="20" placeholder="User ID" maxlength="<?php echo AT_MAXNAME; ?>"
                        value="<?php echo SharedPrepareDisplayString($flduid); ?>"/>
                      <div id="frmUsers_fldUid_errorloc" class="error_strings"></div>
                    </td>
                  </tr>
                  <tr>
                    <tr>
                      <!-- <td align="left" valign="top">Name:</td> -->
                      <td align="left" valign="top">
                        <input required id="fldName" name="fldName" type="text" size="20" placeholder="Name" maxlength="<?php echo AT_MAXNAME; ?>"
                          value="<?php echo SharedPrepareDisplayString($fldname); ?>" />
                        <div id="frmUsers_fldName_errorloc" class="error_strings"></div>
                      </td>
                    </tr>
                    <!-- <td align="left" valign="top">Password:</td> -->
                    <td align="left" valign="top">
                      <input required pattern="^(\w|\W){5,}$" id="userfldPwd" name="userfldPwd" type="password" size="20" placeholder="Password (Must be at least 5 characters and not too simple)"
                        maxlength="<?php echo AT_MAXPWD; ?>" />
                      <div id="frmUsers_fldPwd_errorloc" class="error_strings"></div>
                    </td>
                  </tr>
                  <tr>
                    <!-- <td align="left" valign="top">Confirm:</td> -->
                    <td align="left" valign="top">
                      <input required pattern="^(\w|\W){5,}$" id="fldConfirmPwd" name="fldConfirmPwd" type="password" size="20" placeholder="Repeat Password"
                        maxlength="<?php echo AT_MAXPWD; ?>" />
                      <div id="frmUsers_fldConfirmPwd_errorloc" class="error_strings"></div>
                    </td>
                  </tr>
                  <tr>
                    <!-- <td align="left" valign="top">Email:</td> -->
                    <td align="left" valign="top">
                      <input required pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" title="Invalid Email address"
                        id="fldEmail" name="fldEmail" type="text" size="20" placeholder="Email" maxlength="<?php echo AT_MAXEMAIL; ?>"
                        value="<?php echo SharedPrepareDisplayString($fldemail); ?>" />
                      <div id="frmUsers_fldEmail_errorloc" class="error_strings"></div>
                    </td>
                  </tr>
                  <tr>
                    <!-- <td align="left" valign="top">Mobile:</td> -->
                    <td align="left" valign="top">
                      <input required pattern="^\d{5,}$" title="Invalid Phone number" id="fldMobile" name="fldMobile" type="text" size="20" placeholder="Mobile (Must be at least 5 digits)"
                        maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>"
                      />
                      <div id="frmUsers_fldMobile_errorloc" class="error_strings"></div>
                    </td>
                  </tr>
                  <tr>
                    <!-- <td align="left" valign="top">&nbsp;</td> -->
                    <td align="left" valign="top">
                      <input id="btnSave" type="submit" value="Add" />
                      <br>
                      <span id="error_message" class="text-danger col" style="display:none">* Two passwords are different</span>
                    </td>
                  </tr>
                </table>
              </form>
              <script type="text/javascript">
                var frmvalidator = new Validator("frmUsers");
                frmvalidator.EnableOnPageErrorDisplay();
                // frmvalidator.addValidation("fldName", "req", "Please enter your real Name");
                // frmvalidator.addValidation("fldName", "maxlen=<?php echo AT_MAXNAME; ?>",
                //   "Max length is <?php echo AT_MAXNAME; ?>");
                frmvalidator.addValidation("userfldUid", "req", "Please enter your preferred User ID");
                frmvalidator.addValidation("userfldUid", "maxlen=<?php echo AT_MAXNAME; ?>",
                  "Max length is <?php echo AT_MAXNAME; ?>");
                frmvalidator.addValidation("userfldPwd", "req", "Please enter your password");
                frmvalidator.addValidation("userfldPwd", "maxlen=<?php echo AT_MAXPWD; ?>",
                  "Max length is <?php echo AT_MAXPWD; ?>");
                frmvalidator.addValidation("userfldPwd", "minlen=5",
                  "Must be at least 5 characters and not too simple");
                frmvalidator.addValidation("fldConfirmPwd", "req", "Please re-enter your password");
                frmvalidator.addValidation("fldConfirmPwd", "maxlen=<?php echo AT_MAXPWD; ?>",
                  "Max length is <?php echo AT_MAXPWD; ?>");
                frmvalidator.addValidation("fldConfirmPwd", "eqelmnt=userfldPwd",
                  "Passwords don't match, please try again");
                frmvalidator.addValidation("fldEmail", "maxlen=<?php echo AT_MAXEMAIL; ?>",
                  "Max length is <?php echo AT_MAXEMAIL; ?>");
                frmvalidator.addValidation("fldEmail", "email", "Please enter a valid email address");
                frmvalidator.addValidation("fldMobile", "maxlen=<?php echo AT_MAXPHONE;?>",
                  "Max length is <?php echo AT_MAXPHONE;?>");
                // frmvalidator.addValidation("fldMobile",
                //   "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$",
                //   "Must be in 04xxyyyzzz or xxxxyyyy format");
              </script>

              <?php
                }
                else if ($cmd == AT_CMDMODIFY)
                {
              ?>
                <h2 class="clientTitle">Modify Users</h2>
                <form action="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" method="post" id="frmUsers">
                  <table style="width: 100%">
                    <tr>
                      <!-- <td align="left" valign="top">&nbsp;</td> -->
                      <td align="left" valign="top">
                        <a href="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" class="myButton">Return</a>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" colspan="2" id="msgerr"></td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">User ID:</td> -->
                      <td align="left" valign="top">
                        <label style="margin-top:10px;color:black;font-weight:bold;font-size:13pt">User ID: <?php echo SharedPrepareDisplayString($flduid); ?> </label> 
                      </td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">Name:</td> -->
                      <td align="left" valign="top">
                        <input required id="fldModName" name="fldModName" type="text" size="20" placeholder="Name" maxlength="50" class="required"
                          value="<?php echo SharedPrepareDisplayString($fldname); ?>" />
                        <div id="frmUsers_fldModName_errorloc" class="error_strings"></div>
                      </td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">Email:</td> -->
                      <td align="left" valign="top">
                        <input required pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" id="fldModEmail" name="fldModEmail"
                          type="text" size="20" placeholder="Email" maxlength="<?php echo AT_MAXEMAIL; ?>" value="<?php echo SharedPrepareDisplayString($fldemail); ?>"
                        />
                        <div id="frmUsers_fldModEmail_errorloc" class="error_strings"></div>
                      </td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">Mobile:</td> -->
                      <td align="left" valign="top">
                        <input required pattern="^\d{6,}$" id="fldModMobile" name="fldModMobile" type="text" size="20" placeholder="Mobile (Must be at least 5 digits)"
                          maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>"
                        />
                        <div id="frmUsers_fldModMobile_errorloc" class="error_strings"></div>
                      </td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">&nbsp;</td> -->
                      <td align="left" valign="top">
                        <input id="btnSaveUser" type="submit" value="Save" />
                      </td>
                    </tr>
                  </table>
                  <input name="fldModUserId" type="hidden" value="<?php echo SharedPrepareDisplayString($userid); ?>" />
                  <input name="fldModUid" type="hidden" value="<?php echo SharedPrepareDisplayString($flduid); ?>" />
                </form>

                <!-- <script type="text/javascript">
                        var frmvalidator = new Validator("frmUsers");
                        frmvalidator.EnableOnPageErrorDisplay();
                        frmvalidator.addValidation("fldModName", "req", "Please enter your real Name");
                        frmvalidator.addValidation("fldModName", "maxlen=<?php echo AT_MAXNAME; ?>",
                          "Max length is <?php echo AT_MAXNAME; ?>");
                        frmvalidator.addValidation("fldModEmail", "maxlen=<?php echo AT_MAXEMAIL; ?>",
                          "Max length is <?php echo AT_MAXEMAIL; ?>");
                        frmvalidator.addValidation("fldModEmail", "email", "Please enter a valid email address");
                        frmvalidator.addValidation("fldModMobile", "maxlen=<?php echo AT_MAXPHONE;?>",
                          "Max length is <?php echo AT_MAXPHONE;?>");
                        frmvalidator.addValidation("fldModMobile",
                          "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$",
                          "Must be in 04xxyyyzzz or xxxxyyyy format");
                      </script> -->

                <form action="users.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" method="post" id="frmPwd">
                  <table class="table table-borderless">
                    <tr>
                      <!-- <td align="left" valign="top" width="80px">&nbsp;</td> -->
                      <td align="left" valign="top">Reset password</td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">Password:</td> -->
                      <td align="left" valign="top">
                        <input id="userfldPwd" pattern="^(\w|\W){5,}$" name="userfldPwd" type="password" size="20" placeholder="Password (Must be at least 5 characters and not too simple)"
                          maxlength="50" class="required validate-password" />
                      </td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">Confirm:</td> -->
                      <td align="left" valign="top">
                        <input id="fldConfirmPwd" pattern="^(\w|\W){5,}$" name="fldConfirmPwd" type="password" placeholder="Repeat Password" size="20"
                          maxlength="50" class="required validate-confirm" />
                      </td>
                    </tr>
                    <tr>
                      <!-- <td align="left" valign="top">&nbsp;</td> -->
                      <td align="left" valign="top">
                        <input id="btnSavePwd" type="submit" value="Save" style="background-color:gray;" disabled/>
                        <br>
                        <span id="error_message" class="text-danger col" style="display:none">* Two passwords are different</span>
                      </td>
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
        <script src="js/users.js"></script>
      </div>
  </body>

  </html>