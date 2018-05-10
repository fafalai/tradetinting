<?php
  require_once ("remedyshared.php");
  require_once ("remedyerrcodes.php");

  $id = 0;
  $rc = REMEDY_ERR_DBQUERY;
  try
  {
    if (isset($_POST["uid"]))
    {
      $uid = SharedCleanString($_POST['uid'], AT_MAXNAME);
      $dblink = SharedConnect();
      $dbselect = "select " .
                  "u1.id " .
                  "from " .
                  "users u1 " .
                  "where " .
                  "upper(u1.uid)=upper('$uid') " .
                  "and " .
                  "u1.dateexpired is null";
      if ($dbresult = mysql_query($dbselect, $dblink))
      {
        if ($numrows = mysql_num_rows($dbresult))
        {
          while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
            $id = $dbrow['id'];
        }
        //
        $rc = REMEDY_ERR_NONE;
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
