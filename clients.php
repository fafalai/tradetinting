<?php
  include("logincheck.php");
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/clients.php');
    //exit;
  }
  $dblink = SharedConnect();
  $clientmsg = "";
  $cmd = AT_CMDCREATE;
  $clientid = 0;
  //
  $fldcode = "";
  $fldname = "";
  $flddesc = "";
  $fldcontact = "";
  $fldemail1 = "";
  $fldmobile = "";
  $fldaddress = "";
  $fldcity = "";
  $fldstate = "";
  $fldpostcode = "";
  //
  if (isset($_GET['cmd']))
  {
    $cmd = intval(SharedCleanString($_GET['cmd'], AT_MAXBIGINT));
    $clientid = intval(SharedCleanString(isset($_GET['id']) ? $_GET['id'] : 0, AT_MAXBIGINT));

    if ($cmd == AT_CMDMODIFY)
    {
      // Double check dateexpired is null and this belongs to this customer...
      $dbselect = "select " .
                  "cl1.code," .
                  "cl1.name," .
                  "cl1.notes as 'desc'," .
                  "cl1.contact," .
                  "cl1.email1," .
                  "cl1.mobile," .
                  "cl1.address," .
                  "cl1.city," .
                  "cl1.state," .
                  "cl1.postcode " .
                  "from " .
                  "clients cl1 " .
                  "where " .
                  "cl1.id=" . $clientid . " " .
                  "and " .
                  "cl1.cust_id=" . $_SESSION['custid'] . " " .
                  "and " .
                  "cl1.dateexpired is null";
      if ($dbresult = mysql_query($dbselect, $dblink))
      {
        if ($numrows = mysql_num_rows($dbresult))
        {
          $url = "";
          while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
          {
            $fldcode = $dbrow['code'];
            $fldname = $dbrow['name'];
            $flddesc = $dbrow['desc'];
            $fldcontact = $dbrow['contact'];
            $fldemail1 = $dbrow['email1'];
            $fldmobile = $dbrow['mobile'];
            $fldaddress = $dbrow['address'];
            $fldcity = $dbrow['city'];
            $fldstate = $dbrow['state'];
            $fldpostcode = $dbrow['postcode'];
          }
        }
      }
    }
    else if ($cmd == AT_CMDDELETE)
    {
      $dbupdate = "update " .
                  "clients " .
                  "set " .
                  "dateexpired=CURRENT_TIMESTAMP," .
                  "usersexpired_id=" . $_SESSION['loggedin'] . " " .
                  "where " .
                  "id=" . $clientid . " " .
                  "and " .
                  "cust_id=" . $_SESSION['custid'];
      if (mysql_query($dbupdate, $dblink))
        $clientmsg = "Client " . $fldcode . " has been deleted.";
      else
        $clientmsg = "Unable to delete " . $fldcode . ". Please try again or contact support.";
      //
      $cmd = AT_CMDCREATE;
      $clientid = 0;
    }
    else
      $clientid = 0;
  }
  else if (isset($_POST['fldCode']))
  {
    // Hidden field - are we creating or modifying?
    $clientid = strtoupper(SharedCleanString($_POST['fldClientId'], AT_MAXBIGINT));
    //
    $fldcode = strtoupper(SharedCleanString($_POST['fldCode'], AT_MAXCODE));
    $fldname = SharedCleanString($_POST['fldName'], AT_MAXNAME);
    $flddesc = SharedCleanString($_POST['fldDesc'], AT_MAXNOTE);
    $fldcontact = SharedCleanString($_POST['fldContact'], AT_MAXNAME);
    $fldemail1 = SharedCleanString($_POST['fldEmail1'], AT_MAXEMAIL);
    $fldmobile = SharedNormaliseMobile(SharedCleanString($_POST['fldMobile'], AT_MAXPHONE));
    $fldaddress = SharedCleanString($_POST['fldAddress'], AT_MAXADDRESS);
    $fldcity = SharedCleanString($_POST['fldCity'], AT_MAXADDRESS);
    $fldstate = strtoupper(SharedCleanString($_POST['fldState'], AT_MAXSTATE));
    $fldpostcode = SharedCleanString($_POST['fldPostcode'], AT_MAXPOSTCODE);
    //
    if ($clientid == 0)
    {
      $dbinsert = "insert into " .
                  "clients " .
                  "(" .
                  "cust_id," .
                  "clients.code," .
                  "clients.name," .
                  "clients.desc," .
                  "contact," .
                  "email1," .
                  "mobile," .
                  "address," .
                  "city," .
                  "state," .
                  "postcode," .
                  "userscreated_id" .
                  ") " .
                  "values " .
                  "(" .
                  $_SESSION['custid'] . "," .
                  SharedNullOrQuoted($fldcode, $dblink) . "," .
                  SharedNullOrQuoted($fldname, $dblink) . "," .
                  SharedNullOrQuoted($flddesc, $dblink) . "," .
                  SharedNullOrQuoted($fldcontact, $dblink) . "," .
                  SharedNullOrQuoted($fldemail1, $dblink) . "," .
                  SharedNullOrQuoted($fldmobile, $dblink) . "," .
                  SharedNullOrQuoted($fldaddress, $dblink) . "," .
                  SharedNullOrQuoted($fldcity, $dblink) . "," .
                  SharedNullOrQuoted($fldstate, $dblink) . "," .
                  SharedNullOrQuoted($fldpostcode, $dblink) . "," .
                  $_SESSION['loggedin'] .
                  ")";
      if (mysql_query($dbinsert, $dblink))
      {
        $clientmsg = "Client " . $fldcode . " has been added.";
        // Successful save, clear form...
        $fldcode = "";
        $fldname = "";
        $flddesc = "";
        $fldcontact = "";
        $fldemail1 = "";
        $fldmobile = "";
        $fldaddress = "";
        $fldcity = "";
        $fldstate = "";
        $fldpostcode = "";
      }
      else
        $clientmsg = "Unable to add " . $fldcode . ". Please try again or contact support.";
    }
    else
    {
      $dbupdate = "update " .
                  "clients " .
                  "set " .
                  "clients.code=" . SharedNullOrQuoted($fldcode, $dblink) . "," .
                  "clients.name=" . SharedNullOrQuoted($fldname, $dblink) . "," .
                  "clients.notes=" . SharedNullOrQuoted($flddesc, $dblink) . "," .
                  "contact=" .SharedNullOrQuoted($fldcontact, $dblink) . "," .
                  "email1=" .SharedNullOrQuoted($fldemail1, $dblink) . "," .
                  "mobile=" . SharedNullOrQuoted($fldmobile, $dblink) . "," .
                  "address=" . SharedNullOrQuoted($fldaddress, $dblink) . "," .
                  "city=" . SharedNullOrQuoted($fldcity, $dblink) . "," .
                  "state=" . SharedNullOrQuoted($fldstate, $dblink) . "," .
                  "postcode=" . SharedNullOrQuoted($fldpostcode, $dblink) . "," .
                  "datemodified=CURRENT_TIMESTAMP," .
                  "usersmodified_id=" . $_SESSION['loggedin'] . " " .
                  "where " .
                  "id=" . $clientid . " " .
                  "and " .
                  "cust_id=" . $_SESSION['custid'];
      if (mysql_query($dbupdate, $dblink))
        $clientmsg = "Client " . $fldcode . " has been updated.";
      else
        $clientmsg = "Unable to save " . $fldcode . ". Please try again or contact support.";
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php
    include("meta.php");
  ?>
  <script type="text/javascript">
    function OnFormLoad()
    {
      $('#fldCode').focus();
      <?php
        if ($cmd == AT_CMDMODIFY)
        {
      ?>
          ShowMap();
      <?php
        }
      ?>
    }

    function ShowMap()
    {
      var address = $('#fldAddress').val() + ',' +  $('#fldCity').val() + ',' + $('#fldState').val();
      var encodedaddress = encodeURI(address);
      var googlemapurl = 'http://maps.googleapis.com/maps/api/staticmap?center=' + encodedaddress + '&zoom=13&size=280x280&maptype=roadmap&sensor=false&markers=color:red%7Clabel:S%7C' + encodedaddress + '&apikey=<?php echo AT_GOOGLESTATICMAP_APIKEY; ?>';
      $('#fldGoogleMap').attr('src', googlemapurl);
    }
    onload=OnFormLoad;
  </script>
  <title>Remedy Tinting - Clients</title>
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
            <p class="meta"><span class="date"><?php if ($clientmsg != "") echo $clientmsg; else echo date("l, F j, Y"); ?></span></p>
            <h2 class="title">Add/Modify Clients</h2>
            <div class="entry">

              <form action="clients.php" method="post" id="frmClients">
                <table>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><a href="clients.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0">Create New</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Code:</td>
                    <td align="left" valign="top"><input id="fldCode" name="fldCode" type="text" size="20" maxlength="<?php echo AT_MAXCODE; ?>" value="<?php echo SharedPrepareDisplayString($fldcode); ?>" /><div id="frmClients_fldCode_errorloc" class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Name:</td>
                    <td align="left" valign="top"><input id="fldName" name="fldName" type="text" size="20" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldname); ?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Desc:</td>
                    <td align="left" valign="top"><input id="fldDesc" name="fldDesc" type="text" size="40" maxlength="<?php echo AT_MAXNOTE; ?>" value="<?php echo SharedPrepareDisplayString($flddesc); ?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Contact:</td>
                    <td align="left" valign="top"><input id="fldContact" name="fldContact" type="text" size="20" maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldcontact); ?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Email:</td>
                    <td align="left" valign="top"><input id="fldEmail1" name="fldEmail1" type="text" size="20" maxlength="<?php echo AT_MAXEMAIL; ?>" value="<?php echo SharedPrepareDisplayString($fldemail1); ?>" /><div id="frmClients_fldEmail1_errorloc" class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Mobile:</td>
                    <td align="left" valign="top"><input id="fldMobile" name="fldMobile" type="text" size="20" maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>" /><div id="frmClients_fldMobile_errorloc" class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Address:</td>
                    <td align="left" valign="top"><input id="fldAddress" name="fldAddress" type="text" size="40" maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldaddress); ?>" onchange="ShowMap();" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">City:</td>
                    <td align="left" valign="top"><input id="fldCity" name="fldCity" type="text" size="40" maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldcity); ?>" onchange="ShowMap();" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">State:</td>
                    <td align="left" valign="top">
                      <select id="fldState" name="fldState" onchange="ShowMap();">
                        <option value="VIC" <?php if ($fldstate == "VIC" or $fldstate == "") echo "selected=\"selected\""; ?>>VIC</option>
                        <option value="NSW" <?php if ($fldstate == "NSW") echo "selected=\"selected\""; ?>>NSW</option>
                        <option value="SA" <?php if ($fldstate == "SA") echo "selected=\"selected\""; ?>>SA</option>
                        <option value="WA" <?php if ($fldstate == "WA") echo "selected=\"selected\""; ?>>WA</option>
                        <option value="QLD" <?php if ($fldstate == "QLD") echo "selected=\"selected\""; ?>>QLD</option>
                        <option value="TAS" <?php if ($fldstate == "TAS") echo "selected=\"selected\""; ?>>TAS</option>
                        <option value="ACT" <?php if ($fldstate == "ACT") echo "selected=\"selected\""; ?>>ACT</option>
                        <option value="NT" <?php if ($fldstate == "NT") echo "selected=\"selected\""; ?>>NT</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Postcode:</td>
                    <td align="left" valign="top"><input id="fldPostcode" name="fldPostcode" type="text" size="8" maxlength="4" class="required" value="<?php echo SharedPrepareDisplayString($fldpostcode); ?>" /><div id="frmClients_fldPostcode_errorloc" class="error_strings"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"><input id="btnSave" type="submit" value="Save" /></td>
                  </tr>
                </table>
                <input name="fldClientId" type="hidden" value="<?php echo $clientid; ?>" />
              </form>
              <script type="text/javascript">
                var frmvalidator  = new Validator("frmClients");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.addValidation("fldCode", "req", "Please enter a unique client code");
                //frmvalidator.addValidation("fldPostCode", "req", "Please enter your PostCode");
                //frmvalidator.addValidation("fldPostCode", "regexp=^[0-9]{4}$", "Postcode must be 4 digits");
                frmvalidator.addValidation("fldMobile", "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$", "Must be in 04xxyyyzzz or xxxxyyyy format");
                frmvalidator.addValidation("fldEmail1", "email", "Invalid email address format");
              </script>
            </div>
          </div>

          <div class="post">
            <p class="meta"><span class="date">Move mouse over links for tips. Click on table header to sort by that column.</span></p>
            <h2 class="title">Existing Clients</h2>
            <div class="entry">

              <table border="0" align="center" id="tblClients" rules="cols" frame="box" class="sortable">
                <tr>
                  <th align="left">Code</th>
                  <th align="left">Name</th>
                  <th align="left">Contact</th>
                  <th align="right">Date Modified</th>
                  <th align="center" class="unsortable">Action</th>
                </tr>
                <?php
                  $dbselect = "select " .
                              "cl1.id," .
                              "cl1.code," .
                              "cl1.name," .
                              "cl1.notes as 'desc'," .
                              "cl1.contact," .
                              "cl1.mobile," .
                              "cl1.address," .
                              "cl1.city," .
                              "cl1.state," .
                              "DATE_FORMAT(cl1.datecreated,\"%Y-%m-%d %H:%i\") datecreated," .
                              "DATE_FORMAT(cl1.datemodified,\"%Y-%m-%d %H:%i\") datemodified," .
                              "cl1.gpslat," .
                              "cl1.gpslon " .
                              "from " .
                              "clients cl1 " .
                              "where " .
                              "cl1.cust_id=" . $_SESSION['custid'] . " " .
                              "and " .
                              "cl1.dateexpired is null";
                  if ($dbresult = mysql_query($dbselect, $dblink))
                  {
                    if ($numrows = mysql_num_rows($dbresult))
                    {
                      $url = "";
                      while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
                      {
                        $deletetip = "Delete Client: <strong>" . $dbrow['code'] . "</strong>";
                        $contacttip = "<strong>Name:</strong>" . $dbrow['name'] . "<br />" .
                                      "<strong>Mobile:</strong>" . $dbrow['mobile'] . "<br />" .
                                      "<strong>Address:</strong>" . $dbrow['address'] . "<br />" .
                                      "<strong>City:</strong>" . $dbrow['city'] . ", " . $dbrow['state'] . "<br />" .
                                      $dbrow['desc'];
                        $deletetip = SharedPrepareToolTip($deletetip);
                        $contacttip = SharedPrepareToolTip($contacttip);
                ?>
                        <tr>
                          <td align="left"><a href="clients.php?cmd=<?php echo AT_CMDMODIFY; ?>&id=<?php echo $dbrow['id']; ?>"><?php echo SharedAddEllipsis($dbrow['code'], 20); ?></a></td>
                          <td align="left"><span class="hotspot" onmouseover="tooltip.show('<?php echo $contacttip; ?>');" onmouseout="tooltip.hide();"><?php echo SharedAddEllipsis($dbrow['name'], 20); ?></span></td>
                          <td align="left"><?php echo SharedAddEllipsis($dbrow['contact'], 20); ?></td>
                          <td align="right"><?php if ($dbrow['datemodified'] == "") echo $dbrow['datecreated']; else echo $dbrow['datemodified']; ?></td>
                          <td align="center"><a href="clients.php?cmd=<?php echo AT_CMDDELETE; ?>&id=<?php echo $dbrow['id']; ?>"><span onmouseover="tooltip.show('<?php echo $deletetip; ?>');" onmouseout="tooltip.hide();"><img src="images/icon-delete.png" width="25" height="17" alt="Delete" /></span></a></td>
                        </tr>
                <?php
                      }
                    }
                  }
                ?>
              </table>

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
