<?php
  require_once("remedyshared.php");
  require_once("remedyuuid.php");
  require_once("remedyerrcodes.php");
  require_once("remedyutils.php");

  $rc = "";
  $files = [];
  $resultsetCust = array();
  $errcode = REMEDY_ERR_NONE;

  $lastsync = $_POST["lastsync"];
  $uuid = $_POST["uuid"];
  $jobid = $_POST["jobId"];

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
      $photos = [];

      // Find existing photos...
      $dbselect = "select photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,photo9,photo10 from jobs where id=$jobid";
      if ($dbresult = SharedQuery($dbselect, $dblink))
      {
        if ($numrows = SharedNumRows($dbresult))
        {
          while ($dbrow = SharedFetchArray($dbresult))
            $photos = $dbrow;

          foreach ($_FILES as $key => $value)
          {
            if (is_array($value))
            {
              $filename = $value["name"];
              $filetype = $value["type"];
              $tmpfilename = $value["tmp_name"];
              $filesize = $value["size"];
          
              $ext = pathinfo($filename, PATHINFO_EXTENSION);
              $newname = tempnam("photos", $jobid);
              $newnameext = $newname . "." . $ext;
          
              if (move_uploaded_file($tmpfilename, $newnameext))
              {
                // Find empty photo slot...
                for ($p = 1; $p <= 10; $p++)
                {
                  if ($photos["photo$p"] == "")
                  {
                    $dbupdate = "update jobs set photo$p = " . SharedNullOrQuoted(pathinfo($newnameext, PATHINFO_BASENAME),1000, $dblink) . " where id=$jobid";
                    error_log($dbupdate);
                    SharedQuery($dbupdate, $dblink);
                    // Mark this as now used...
                    $photos["photo$p"] = "**";
                    break;
                  }
                }

                $files[] = ["filename" => $filename, "filesize" => $filesize, "filetype" => $filetype];
              }
            }
          }
        }
      }
    }
    else
      $errcode = REMEDY_ERR_NOTLOGGEDIN;
  }  
  else
      $errcode = REMEDY_ERR_DBCONNECT;

  $rc = json_encode(["errcode" => $errcode, "files" => $files]);
  //error_log($rc);
  header("Content-Type: application/json");
  echo $rc;
?>
