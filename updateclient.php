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

              // Update new client entry...
              $dbupdate = "update " .
                          "clients " .
                          "set " .
                          "name=" . SharedNullOrQuoted($data["name"], $dblink) . "," .
                          "address=" . SharedNullOrQuoted($data["address"], $dblink) . "," .
                          "city=" . SharedNullOrQuoted($data["city"], $dblink) . "," .
                          "state=" . SharedNullOrQuoted($data["state"], $dblink) . "," .
                          "postcode=" . SharedNullOrQuoted($data["postcode"], $dblink) . "," .
                          "mobile=" . SharedNullOrQuoted($data["mobile"], $dblink) . "," .
                          "email1=" . SharedNullOrQuoted($data["email"], $dblink) . "," .
                          "notes=" . SharedNullOrQuoted($data["descr"], $dblink) . "," .
                          "datemodified=CURRENT_TIMESTAMP," .
                          "usersmodified_id=$userid " .
                          "where " .
                          "cust_id=$custid " .
                          "and " .
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

