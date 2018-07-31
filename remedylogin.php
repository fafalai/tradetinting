<?php
  require_once ("remedyshared.php");
  require_once ("remedyuuid.php");
  require_once ("remedyerrcodes.php");
  $errcode = REMEDY_ERR_NONE;
  $uuid = "";
  $custuuid = "";
  $custurl = "http://www.remedyappserver.sales";
  $isadmin = 0;
  $licenseno = "";
  $units = "";
  if (isset($_POST['uid']) && isset($_POST['pwd']))
  {
    $loginuid = SharedCleanString($_POST['uid'], 50);
    $loginpwd = SharedCleanString($_POST['pwd'], 50);
    $dblink = SharedConnect();

    error_log("UID: $loginuid, PWD: $loginpwd");
    if ($dblink !== false)
    {
      $dbselect = "select " .
                  "u1.id," .
                  "u1.pwd," .
                  "u1.admin," .
                  "u1.licenseno," .
                  "c1.url," .
                  "c1.units," .
                  "c1.uuid cust_uuid " .
                  "from " .
                  "users u1 left join cust c1 on (u1.cust_id=c1.id) " .
                  "where " .
                  "uid='$loginuid' ".
                  "and ".
                  "u1.dateexpired is null";
      if ($dbresult = SharedQuery($dbselect, $dblink))
      {
        if ($numrows = SharedNumRows($dbresult))
        {
          $dbuid = 0;
          $dbpwd = "";
          while ($dbrow = SharedFetchArray($dbresult))
          {
            $dbuid = $dbrow['id'];
            $dbpwd = $dbrow['pwd'];
            $custurl = $dbrow['url'];
            $custuuid = $dbrow['cust_uuid'];
            $isadmin = $dbrow['admin'];
            $licenseno = $dbrow['licenseno'];
            $units = $dbrow['units'];

            error_log("Cust UUID: $custuuid");
          }

          if ($dbpwd == $loginpwd)
          {
            $uuid = RemedyUuid(20);
            $dbupdate = "update " .
                        "users " .
                        "set " .
                        "uuid='$uuid' " .
                        "where " .
                        "id=$dbuid";
            SharedQuery($dbupdate, $dblink);
          }
          else
            $errcode = REMEDY_ERR_INVALIDLOGIN;
        }
        else
          $errcode = REMEDY_ERR_NODATA;
      }
      else
        $errcode = REMEDY_ERR_DBQUERY;
    }
    else
        $errcode = REMEDY_ERR_DBCONNECT;
  }
  else
    $errcode = REMEDY_ERR_MISSINGPARAM;

  $response = array("errcode" => $errcode, "uuid" => $uuid, "custuuid" => $custuuid, "custurl" => $custurl, "admin" => $isadmin, "licenseno" => $licenseno, "units" => $units);
  $json = json_encode($response);
  echo $json;
?>
