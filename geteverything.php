<?php
  require_once ("remedyshared.php");
  require_once ("remedyerrcodes.php");
  require_once ("remedyutils.php");
  $errcode = REMEDY_ERR_NONE;
  $count = 0;
  $resultsetCust = array();
  $resultsetClients = array();
  $resultsetJobs = array();
  $resultsetJobDetails = array();
  try
  {
    if (isset($_POST['uuid']) && isset($_POST['lastsync']))
    {
      $uuid = SharedCleanString($_POST['uuid'], 50);
      $lastsync = SharedCleanString($_POST['lastsync'], 50);
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
                      "c1.notes as desc," .
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
            }
          }
          // Fetch clients for this user/cust combo...
          // that have been added or modified since given timestamp...
          $dbselect = "select " .
                      "cl1.id," .
                      "cl1.code," .
                      "cl1.altcode," .
                      "cl1.name," .
                      "cl1.notes as 'desc'," .
                      "cl1.contact," .
                      "cl1.mobile," .
                      "cl1.email1," .
                      "cl1.address," .
                      "cl1.city," .
                      "cl1.state," .
                      "cl1.postcode," .
                      "cl1.gpslat," .
                      "cl1.gpslon," .
                      "cl1.datecreated," .
                      "cl1.datemodified," .
                      "cl1.dateexpired " .
                      "from " .
                      "clients cl1 " .
                      "where " .
                      "(" .
                      "cl1.datecreated >= '$lastsync' " .
                      "or " .
                      "cl1.datemodified >= '$lastsync' " .
                      "or " .
                      "cl1.dateexpired >= '$lastsync'" .
                      ") " .
                      "and " .
                      "cl1.dateexpired is null " .
                      "and " .
                      "cl1.cust_id = $custid";
          if ($dbresult = SharedQuery($dbselect, $dblink))
          {
            if ($numrows = SharedNumRows($dbresult))
            {
              $count += $numrows;
              while ($dbrow = SharedFetchArray($dbresult))
                $resultsetClients[] = $dbrow;
            }

            // Fetch client jobs...
            $dbselect = "select " .
                        "j1.id," .
                        "j1.clients_id," .
                        "j1.jobno," .
                        "j1.jobname," .
                        "j1.notes as 'desc'," .
                        "j1.contact," .
                        "j1.mobile," .
                        "j1.address," .
                        "j1.city," .
                        "j1.state," .
                        "j1.postcode," .
                        "j1.datejob," .
                        "j1.datecompleted," .
                        "j1.totalprice," .
                        "j1.discount," .
                        "j1.tax," .
                        "j1.gpslat," .
                        "j1.gpslon," .
                        "j1.photo1," .
                        "j1.photo2," .
                        "j1.photo3," .
                        "j1.photo4," .
                        "j1.photo5," .
                        "j1.photo6," .
                        "j1.photo7," .
                        "j1.photo8," .
                        "j1.photo9," .
                        "j1.photo10," .
                        "j1.datecreated," .
                        "j1.datemodified," .
                        "j1.dateexpired " .
                        "from " .
                        "jobs j1 left join clients cl1 on (j1.clients_id=cl1.id) " .
                        "where " .
                        "j1.cust_id = $custid " .
                        "and " .
                        "j1.dateexpired is null " .
                        "and " .
                        "(" .
                        "j1.datecreated >= '$lastsync' " .
                        "or " .
                        "j1.datemodified >= '$lastsync' " .
                        "or " .
                        "j1.dateexpired >= '$lastsync'" .
                        ")";
            if ($dbresult = SharedQuery($dbselect, $dblink))
            {
              if ($numrows = SharedNumRows($dbresult))
              {
                $count += $numrows;
                while ($dbrow = SharedFetchArray($dbresult))
                  $resultsetJobs[] = $dbrow;
              }

              // Fetch jobdetails that have been added, modified or expired since given timestamp...
              $dbselect = "select " .
                          "jd1.id," .
                          "jd1.jobs_id," .
                          "jd1.name," .
                          "jd1.width," .
                          "jd1.height," .
                          "jd1.notes," .
                          "jd1.glasstype," .
                          "jd1.frametype," .
                          "jd1.filmtype," .
                          "jd1.direction," .
                          "jd1.salerate," .
                          "jd1.totalarea," .
                          "jd1.altname," .
                          "jd1.totalprice," .
                          "jd1.datecreated " .
                          "from " .
                          "jobdetails jd1 " .
                          "where " .
                          "jd1.datecreated >= '$lastsync' " .
                          "and " .
                          "jd1.jobs_id in " .
                          "(" .
                          "select j1.id from jobs j1 where j1.cust_id = $custid" .
                          ") " .
                          "and " .
                          "jd1.dateexpired is null " .
                          "order by " .
                          "jd1.jobs_id";
              if ($dbresult = SharedQuery($dbselect, $dblink))
              {
                if ($numrows = SharedNumRows($dbresult))
                {
                  $count += $numrows;
                  while ($dbrow = SharedFetchArray($dbresult))
                    $resultsetJobDetails[] = $dbrow;
                }
              }
              else
                $errcode = REMEDY_ERR_DBQUERY;
            }
            else
              $errcode = REMEDY_ERR_DBQUERY;
          }
          else
            $errcode = REMEDY_ERR_DBQUERY;
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
  }
  // Note: we don't return REMEDY_ERR_NODATA since we're returning multiple result sets and this might prematurely terminate processing by client...
  // and technically, it's not an error - just no data....
  // Update last sync timestamp for client...
  $lastsync = Date("Y-m-d H:i:00");
  $response = array("errcode" => $errcode, "count" => $count, "lastsync" => $lastsync, "cust" => $resultsetCust, "clients" => $resultsetClients, "jobs" => $resultsetJobs, "jobdetails" => $resultsetJobDetails);
  $json = json_encode($response);
  echo $json;
?>
