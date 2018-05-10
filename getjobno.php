<?php
  require_once ("remedyshared.php");
  require_once ("remedyerrcodes.php");

  $id = 0;
  $rc = REMEDY_ERR_DBQUERY;
  try
  {
    if (isset($_POST["uuid"]) && isset($_POST["custid"]))
    {
      $uuid = SharedCleanString($_POST['uuid'], AT_MAXNAME);
      $custid = SharedCleanString($_POST['custid'], AT_MAXBIGINT);

      $dblink = SharedConnect();
      if ($dblink)
      {
        $dbinsert = "insert into jobs (cust_id,userscreated_id) select $custid,id from users where uuid=\"$uuid\"";
        if (mysql_query($dbinsert, $dblink))
        {
          $id = mysql_insert_id($dblink);
          $rc = REMEDY_ERR_NONE;
        }
      }
    }
  }

  catch (Exception $e)
  {
    error_log("Exception in [" . $e->getFile() . "] on line [" . $e->getLine() . "]: " . $e->getMessage());
  }
  //
  $response = array("rc" => $rc, "id" => $id);
  $json = json_encode($response);
  echo $json;
?>
