<?php
  require_once("remedyshared.php");
  require_once("remedyuuid.php");
  require_once("remedyerrcodes.php");
  require_once("remedyutils.php");

  $errcode = REMEDY_ERR_NONE;
  $resultsetCust = array();
  try
  {
    if (isset($_POST['uuid']) && isset($_POST['lastsync']) && isset($_POST['data']))
    {
      $uuid = SharedCleanString($_POST['uuid'], 50);
      $lastsync = SharedCleanString($_POST['lastsync'], 50);
      $data = JSON_decode(SharedCleanString($_POST['data'], 16384), true);

      if ($lastsync == "")
        $lastsync = "2000-01-01 0:0";

      $dblink = SharedConnect();
      if ($dblink !== false)
      {
        $user = RemedyUserFromUuid($uuid, $dblink);

        if ($user !== false)
        {
          $userid = $user['user_id'];
          $custid = $user['cust_id'];
          // Always fetch cust info...
          $dbselect = "select " .
                      "c1.name," .
                      "c1.desc," .
                      "c1.contact," .
                      "c1.phone," .
                      "c1.mobile," .
                      "c1.email," .
                      "c1.address," .
                      "c1.city," .
                      "c1.state," .
                      "c1.postcode," .
                      "c1.url," .
                      "c1.licenseno " .
                      "from " .
                      "cust c1 " .
                      "where " .
                      "c1.id=$custid";
          if ($dbresult = mysql_query($dbselect, $dblink))
          {
            if ($numrows = mysql_num_rows($dbresult))
            {
              while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
                $resultsetCust[] = $dbrow;

              // Update jobdetail entry...
              $dbupdate = "update " .
                          "jobdetails " .
                          "set " .
                          "name=" . SharedNullOrQuoted($data["name"], $dblink) . "," .
                          "altname=" . SharedNullOrQuoted($data["altname"], $dblink) . "," .
                          "filmtype=" . SharedNullOrQuoted($data["filmtype"], $dblink) . "," .
                          "frametype=" . SharedNullOrQuoted($data["frametype"], $dblink) . "," .
                          "direction=" . SharedNullOrQuoted($data["direction"], $dblink) . "," .
                          "glasstype=" . SharedNullOrQuoted($data["glasstype"], $dblink) . "," .
                          "notes=" . SharedNullOrQuoted($data["notes"], $dblink) . "," .
                          "width=" . $data["width"] . "," .
                          "height=" . $data["height"] . "," .
                          "salerate=" . $data["salerate"] . "," .
                          "totalprice=" . $data["totalprice"] . "," .
                          "totalarea=" . $data["totalarea"] . " " .
                          "where " .
                          "id=" . $data["id"];

              error_log($dbupdate);
              mysql_query($dbupdate, $dblink);
            }
            else
              $errcode = REMEDY_ERR_MISSINGPARAM;
          }
          else
            $errcode = REMEDY_ERR_NOTLOGGEDIN;
        }
        else
          $errcode = REMEDY_ERR_NOTLOGGEDIN;
      }
      else
          $errcode = REMEDY_ERR_DBCONNECT;
    }
    else
      $errcode = REMEDY_ERR_MISSINGPARAM;
  }

  catch (Exception $e)
  {
    error_log('Exception ['. $e->getFile() . ':' . $e->getLine() . ']: ' . $e->getMessage());
    $errcode = REMEDY_ERR_DBQUERY;

    if ($dblink)
      mysql_query("rollback", $dblink);
  }

  $response = array("errcode" => $errcode);
  $json = json_encode($response);
  echo $json;
?>

