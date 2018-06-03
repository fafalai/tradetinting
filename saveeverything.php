<?php
  require_once("remedyshared.php");
  require_once("remedyuuid.php");
  require_once("remedyerrcodes.php");
  require_once("remedyutils.php");

  $errcode = REMEDY_ERR_NONE;
  $count = 0;
  $resultsetCust = array();
  $clientid = 0;
  $jobid = 0;
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
          if ($dbresult = SharedQuery($dbselect, $dblink))
          {
            if ($numrows = SharedNumRows($dbresult))
            {
              while ($dbrow = SharedFetchArray($dbresult))
                $resultsetCust[] = $dbrow;

              if (sizeof($data) > 0)
              {
                $client = $data["clients"][0];
                // New client or existing?
                if ($client["status"] == 0)
                {
                  // Create new client entry...
                  $dbinsert = "insert into " .
                              "clients " .
                              "(cust_id,code,name,address,city,state,postcode,mobile,email1,notes,userscreated_id) " .
                              "values " .
                              "(" .
                              $custid . "," .
                              SharedNullOrQuoted($client["name"],50, $dblink) . "," .
                              SharedNullOrQuoted($client["name"], 50,$dblink) . "," .
                              SharedNullOrQuoted($client["address"], 200,$dblink) . "," .
                              SharedNullOrQuoted($client["city"], 50,$dblink) . "," .
                              SharedNullOrQuoted($client["state"],50, $dblink) . "," .
                              SharedNullOrQuoted($client["postcode"],50, $dblink) . "," .
                              SharedNullOrQuoted($client["mobile"],50, $dblink) . "," .
                              SharedNullOrQuoted($client["email"],100, $dblink) . "," .
                              SharedNullOrQuoted($client["descr"],1000, $dblink) . "," .
                              $userid .
                              ")";

                  error_log($dbinsert);
                  if (SharedQuery($dbinsert, $dblink))
                    $clientid = SharedGetInsertId($dblink);
                }
                else
                  $clientid = $client["id"];

                if ($clientid !== 0)
                {
                  $job = $data["jobs"][0];

                  // New job or existing?
                  if ($job["status"] == 0)
                  {
                    // Save job...
                    $dbinsert = "insert into " .
                                "jobs " .
                                "(cust_id,clients_id,jobname,contact,address,city,state,postcode,mobile,gpslat,gpslon,totalprice,notes,datejob,discount,tax,userscreated_id) " .
                                "values " .
                                "(" .
                                $custid . "," .
                                $clientid . "," .
                                SharedNullOrQuoted($job["jobname"],50, $dblink) . "," .
                                SharedNullOrQuoted($job["contact"],50, $dblink) . "," .
                                SharedNullOrQuoted($job["address"],200, $dblink) . "," .
                                SharedNullOrQuoted($job["city"],50, $dblink) . "," .
                                SharedNullOrQuoted($job["state"],50, $dblink) . "," .
                                SharedNullOrQuoted($job["postcode"],50, $dblink) . "," .
                                SharedNullOrQuoted($job["mobile"],50, $dblink) . "," .
                                $job["gpslat"] . "," .
                                $job["gpslong"] . "," .
                                $job["totalprice"] . "," .
                                SharedNullOrQuoted($job["desc"],1000, $dblink) . "," .
                                SharedNullOrQuoted($job["datejob"],50, $dblink) . "," .
                                $job["discount"] . "," .
                                $job["tax"] . "," .
                                $userid  .
                                ")";
                    error_log($dbinsert);
                    if (SharedQuery($dbinsert, $dblink))
                      $jobid = SharedGetInsertId($dblink);
                  }
                  else
                  {
                    $jobid = $job["jobid"];
                    $dbupdate = "update " .
                                "jobs " .
                                "set " .
                                "jobname=" . SharedNullOrQuoted($job["jobname"],50, $dblink) . "," .
                                "contact=" . SharedNullOrQuoted($job["contact"],50, $dblink) . "," .
                                "address=" . SharedNullOrQuoted($job["address"],50, $dblink) . "," .
                                "city=" . SharedNullOrQuoted($job["city"],50, $dblink) . "," .
                                "state=" . SharedNullOrQuoted($job["state"], 50,$dblink) . "," .
                                "postcode=" . SharedNullOrQuoted($job["postcode"],50, $dblink) . "," .
                                "mobile=" . SharedNullOrQuoted($job["mobile"],50, $dblink) . "," .
                                "totalprice=" . $job["totalprice"] . "," .
                                "notes=" . SharedNullOrQuoted($job["desc"],1000, $dblink) . "," .
                                "discount=" . $job["discount"] . "," .
                                "tax=" . $job["tax"] . "," .
                                "datemodified=CURRENT_TIMESTAMP," .
                                "usersmodified_id=" . $userid . " " .
                                "where " .
                                "id=" . $jobid;
                    error_log($dbupdate);
                    SharedQuery($dbupdate, $dblink);
                  }

                  if ($jobid !== 0)
                  {
                    $dbdelete = "delete from jobdetails where jobs_id=" . $jobid;
                    error_log($dbdelete);
                    if (SharedQuery($dbdelete, $dblink))
                    {
                      foreach ($data["jobdetails"] as $jd)
                      {
                        // Save job details...
                        $dbinsert = "insert into " .
                                    "jobdetails " .
                                    "(jobs_id,name,altname,filmtype,frametype,glasstype,width,height,direction,totalarea,salerate,totalprice,notes) " .
                                    "values " .
                                    "(" .
                                    $jobid . "," .
                                    SharedNullOrQuoted($jd["name"], 50,$dblink) . "," .
                                    SharedNullOrQuoted($jd["altname"], 50,$dblink) . "," .
                                    SharedNullOrQuoted($jd["filmtype"],50, $dblink) . "," .
                                    SharedNullOrQuoted($jd["frametype"],50, $dblink) . "," .
                                    SharedNullOrQuoted($jd["glasstype"],50, $dblink) . "," .
                                    $jd["width"] . "," .
                                    $jd["height"] . "," .
                                    SharedNullOrQuoted($jd["direction"],50, $dblink) . "," .
                                    $jd["totalarea"] . "," .
                                    $jd["salerate"] . "," .
                                    $jd["totalprice"] . "," .
                                    SharedNullOrQuoted($jd["notes"],10000, $dblink) .
                                    ")";
                        error_log($dbinsert);
                        if (SharedQuery($dbinsert, $dblink))
                          $count++;
                      }
                      //SharedSendHtmlMail("fafa.lai@adtalk.com.au", "Trade Tinting", 'emily92308@126.com', 'Customer Name', 'Invoice', 'This is your invoice');
                      SharedQuery("commit", $dblink);
                    }
                    else
                      $errcode = REMEDY_ERR_DBDELETE;
                  }
                  else
                    $errcode = REMEDY_ERR_DBINSERT;
                }
                else
                  $errcode = REMEDY_ERR_DBINSERT;
              }
              else
                $errcode = REMEDY_ERR_DBQUERY;
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
      SharedQuery("rollback", $dblink);
  }

  $response = array("errcode" => $errcode, "count" => $count, "clientid" => $clientid, "jobid" => $jobid);
  $json = json_encode($response);
  echo $json;
?>


