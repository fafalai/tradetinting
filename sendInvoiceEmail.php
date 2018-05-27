<?php
  require_once("remedyshared.php");
  require_once("remedyuuid.php");
  require_once("remedyerrcodes.php");
  require_once("remedyutils.php");
  require_once("class.phpmailer.php");

  $errcode = REMEDY_ERR_NONE;
  $count = 0;
  $resultsetCust = array();
  $clientid = 0;
  $jobid = 0;
  error_log("I am in");
  try
  {
    error_log($_POST['uuid']);
    error_log($_POST['lastsync']);
    error_log($_POST['data']);
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
          error_log("the user id ");
          error_log($userid);
          $custid = $user['cust_id'];
          error_log("the customer id ");
          error_log($custid);
          // Always fetch cust info...
          $dbselect = "select " .
                      "c1.name name, " .
                      "c1.desc, " .
                      "c1.contact contact, " .
                      "c1.phone phone, " .
                      "c1.mobile mobile, " .
                      "c1.email email, " .
                      "c1.address address, " .
                      "c1.city city, " .
                      "c1.state state, " .
                      "c1.postcode postcode, " .
                      "c1.url, " .
                      "c1.licenseno " .
                      "from " .
                      "cust c1 " .
                      "where " .
                      "c1.id=$custid";
          //error_log($dbselect);
          if ($dbresult = mysql_query($dbselect, $dblink))
          {
            if ($numrows = mysql_num_rows($dbresult))
            {
              $resultsetCust = null;
              while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
                $resultsetCust = $dbrow;
                $businessName = $resultsetCust['name'];
                $custname = $resultsetCust['contact'];
                // error_log("the customer name is ");
                // error_log($resultsetCust['email']);

              if (sizeof($data) > 0)
              {
                $clientid = $data["clientID"];
                $jobid = $data["jobID"];
                $clientselect = "select " .
                                "c1.email1 email, " .
                                "c1.name name, ".
                                "c1.address address, ".
                                "c1.city city, ".
                                "c1.state state, ".
                                "c1.postcode postcode ".
                                "from " .
                                "clients c1 " .
                                "where " . 
                                "c1.id = $clientid";
                //error_log($clientselect);
                
                $jobTotalSelect = "select " .
                                  "count(j1.id) totalWindowNumber, " .
                                  "sum(j1.totalPrice) totalPrice ". 
                                  "from " .
                                  "jobdetails j1 ".
                                  "where ".
                                  "j1.jobs_id = $jobid";
                //error_log($jobTotalSelect);

                $jobDetailSelect = "select ".
                                  "j1.discount discount, ".
                                  "j1.tax tax ".
                                  "from ". 
                                  "jobs j1 ".
                                  "where ".
                                  "j1.id = $jobid";
                
                $jobGroupSelect = "select ".
                                  "j1.name roomName, ".
                                  "sum(j1.totalPrice) totalPrice, ".
                                  "count(j1.id) numOfWindows, ".
                                  "j1.filmType filmType ".
                                  "from ".
                                  "jobdetails j1 ".
                                  "where ".
                                  "j1.jobs_id = $jobid ".
                                  "group by name, filmType";

                $jobGlassTypeSelect = "select ".
                                  "j1.glassType glassType ".
                                  "from ".
                                  "jobdetails j1 ".
                                  "where ".
                                  "j1.jobs_id = $jobid ".
                                  "group by j1.glassType";

                $jobFrameTypeSelect = "select ".
                                  "j1.frameType frameType ".
                                  "from ".
                                  "jobdetails j1 ".
                                  "where ".
                                  "j1.jobs_id = $jobid ".
                                  "group by j1.frameType";
                $jobFilmTypeSelect = "select ".
                                  "j1.filmType filmType ".
                                  "from ".
                                  "jobdetails j1 ".
                                  "where ".
                                  "j1.jobs_id = $jobid ".
                                  "group by j1.filmType";
                //error_log($jobGlassTypeSelect);
                //error_log($jobFrameTypeSelect);
                //error_log($jobFilmTypeSelect);
                error_log($jobGroupSelect);


                if ($clientresult = mysql_query($clientselect, $dblink))
                {
                  if($numrows = mysql_num_rows($clientresult))
                  {
                    $client = null;
                    while ($dbrow = mysql_fetch_array($clientresult,MYSQL_ASSOC))
                    $client = $dbrow;
                    error_log("the client email is ");
                    error_log($client['email']);
                  }
                }
                if ($jobTotalResult = mysql_query($jobTotalSelect, $dblink))
                {
                  if($numrows = mysql_num_rows($jobTotalResult))
                  {
                    $jobTotal = null;
                    while ($dbrow = mysql_fetch_array($jobTotalResult,MYSQL_ASSOC))
                    $jobTotal = $dbrow;
                    //error_log("the total price of this job is ");
                    //error_log($jobTotal['totalPrice']);
                  }
                }
                if ($jobDetailResult = mysql_query($jobDetailSelect, $dblink))
                {
                  if($numrows = mysql_num_rows($jobDetailResult))
                  {
                    $jobDetail = null;
                    while ($dbrow = mysql_fetch_array($jobDetailResult,MYSQL_ASSOC))
                    $jobDetail = $dbrow;
                    //error_log("the discount of this job is ");
                    //error_log($jobDetail['discount']);
                  }
                }
                if ($jobGroupResult = mysql_query($jobGroupSelect, $dblink))
                {
                  if($numrows = mysql_num_rows($jobGroupResult))
                  {
                    //$jobGroupCount 
                    while ($dbrow = mysql_fetch_array($jobGroupResult,MYSQL_ASSOC))
                    $jobGroupDetail[] = $dbrow;
                  }
                }
                if ($jobGlassTypeResult = mysql_query($jobGlassTypeSelect, $dblink))
                {
                  if($numrows = mysql_num_rows($jobGlassTypeResult))
                  {
                    //$jobGroupCount 
                    while ($dbrow = mysql_fetch_array($jobGlassTypeResult,MYSQL_ASSOC))
                    $jobGlassType[] = $dbrow;
                  }
                }
                if ($jobFrameTypeResult = mysql_query($jobFrameTypeSelect, $dblink))
                {
                  if($numrows = mysql_num_rows($jobFrameTypeResult))
                  {
                    //$jobGroupCount 
                    while ($dbrow = mysql_fetch_array($jobFrameTypeResult,MYSQL_ASSOC))
                    $jobFrameType[] = $dbrow;
                  }
                }
                if ($jobFilmTypeResult = mysql_query($jobFilmTypeSelect, $dblink))
                {
                  if($numrows = mysql_num_rows($jobFilmTypeResult))
                  {
                    //$jobGroupCount 
                    while ($dbrow = mysql_fetch_array($jobFilmTypeResult,MYSQL_ASSOC))
                    $jobFilmType[] = $dbrow;
                  }
                }
                
                /** Each customer should have their own email template, $custid.html. If there is no corresponding html from the folder, use the genearl one */
                if (file_exists( "./quoteEmailTemplate/$custid.html"))
                {
                  $emailtemplate = file_get_contents("./quoteEmailTemplate/$custid.html");
                  error_log("use user's own email template");
                }
                else
                {
                  $emailtemplate = file_get_contents("./quoteEmailTemplate/generalTemplate.html");
                  error_log("use general template");
                }
               

                //error_log("the total number of this job  group by name is ");
                //error_log(count($jobGroupDetail));
                
                $totalPrice = number_format((float)$jobTotal['totalPrice'], 2, '.', '');
                //error_log("the total price of this job ");
                //error_log($totalPrice);

            
                $tax = number_format((float)$jobDetail['tax'], 2, '.', '');
                //error_log("the tax of this job is ");
                //error_log($tax);

                $discount = number_format((float)$jobDetail['discount'], 2, '.', '');
                error_log("the discount of this job is ");
                error_log($discount);

                $discountrow = "";
                if ($discount != 0.00 )
                {
                  $discountrow = "<tr style='text-align: center'> 
                                  <td>
                                    Discount
                                  </td>
                                  <td>
                                  </td>
                                  <td>
                                  </td>
                                  <td>".
                                    "$".$discount.
                                  "</td>
                                  </tr>";
                }
                else
                {
                  error_log("The discount is 0, should not have the discount row");
                }
                // error_log("the discount row is");
                // error_log($discountrow);

                $netPrice = number_format((float)($totalPrice - $discount), 2, '.', '');

                $taxAmount = ($totalPrice - $discount) * ($tax *0.01);
                $taxAmountFormate = number_format((float)$taxAmount, 2, '.', '');
                //error_log("the tax amount of this job is ");
                //error_log($taxAmountFormate);

                $finalPrice = ($totalPrice - $discount) * (1 + $tax *0.01);
                $finalPriceFormate = number_format((float)$finalPrice, 2, '.', '');
                // error_log("the final price of this job is ");
                // error_log($finalPriceFormate);
                $tableReplace = "";
                foreach($jobGroupDetail as $jobDetail)
                {
                  //error_log($jobDetail.roomName);
                  //error_log($jobDetail['roomName']);
                  //error_log($jobDetail['totalPrice']);
                  //error_log($jobDetail['numOfWindows']);
                  $row = "<tr style='text-align: center'> <td>" . 
                          $jobDetail['roomName']. 
                          "</td>
                          <td>".
                          $jobDetail['numOfWindows'].
                          "</td>
                          <td>".
                          $jobDetail['filmType'].
                          "</td>
                          <td>".
                          "$".number_format((float)$jobDetail['totalPrice'], 2, '.', '').
                          "</th>
                          </tr>";
                error_log($row);
                $tableReplace = $tableReplace.$row;
                }

                $glassType = "";
                error_log(count($jobGlassType));
                if(count($jobGlassType) == 1)
                {
                  $glassType =$jobGlassType[0]['glassType'];
                }
                else
                {
                  for ($x =0 ; $x<count($jobGlassType); $x = $x + 1)
                  {
                    error_log($jobGlassType[$x]['glassType']);
                    if (($jobGlassType[$x]['glassType']) != "" && ($jobGlassType[$x]['glassType']) != null )
                    {
                      if ($x == 0)
                      {
                        $glassType =$jobGlassType[$x]['glassType'];
                      }
                      else
                      {
                        if ($glassType == "")
                        {
                          $glassType = $glassType.$jobGlassType[$x]['glassType'];
                        }
                        else
                        {
                          $glassType = $glassType. ", ".$jobGlassType[$x]['glassType'];
                        }

                        
                      }
                      error_log($glassType);
                    }
                    else
                    {
                      error_log("the glass type is empty");
                    }
                  }
                }
                

                $frameType = "";
                for ($x = 0; $x<count($jobFrameType);$x = $x +1)
                {
                  if(count($jobFrameType) == 1)
                  {
                    $frameType =$jobFrameType[0]['frameType'];
                  }
                  else
                  {
                    for ($x =0 ; $x<count($jobFrameType); $x = $x + 1)
                    {
                      error_log($jobFrameType[$x]['frameType']);
                      if (($jobFrameType[$x]['frameType']) != "" && ($jobFrameType[$x]['frameType']) != null )
                      {
                        if ($x == 0)
                        {
                          $frameType =$jobFrameType[$x]['frameType'];
                        }
                        else
                        {
                          if ($frameType == "")
                          {
                            $frameType = $frameType.$jobFrameType[$x]['frameType'];
                          }
                          else
                          {
                            $frameType = $frameType. ", ".$jobFrameType[$x]['frameType'];
                          }
  
                          
                        }
                        error_log($frameType);
                      }
                      else
                      {
                        error_log("the frame type is empty");
                      }
                    }
                  }
                }
                
                $filmType = "";
                for ($x = 0; $x<count($jobFilmType);$x = $x +1)
                {
                  if (!empty($jobFilmType[$x]['filmType']))
                  {
                    if ($x == 0)
                    {
                      $filmType =$jobFilmType[$x]['filmType'];
                    }
                    else
                    {
                      $filmType = $jobFilmType[$x]['filmType']. ", ".$filmType;
                    }
                    error_log($filmType);
                  }
                  else
                  {
                    error_log("the film type is empty");
                  }
                }

                error_log($glassType);
                error_log($frameType);
                error_log($filmType);
                //error_log($tableReplace);

                //error_log("Prints the day, date, month, year, time, AM or PM");
                //error_log(date("l j \of F Y h:i:s A"));
                $emailtemplate = str_replace("xxx_quote",$jobid,$emailtemplate);
                $emailtemplate = str_replace("XXX_Date",date("l"),$emailtemplate);
                $emailtemplate = str_replace("XXX_Month",date("F"),$emailtemplate);
                $emailtemplate = str_replace("XXX_Day",date("j"),$emailtemplate);
                $emailtemplate = str_replace("XXX_YEAR",date("Y"),$emailtemplate);
                $emailtemplate = str_replace("XXX_CLIENTFIRSTNAME",$client['name'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CLIENTSTREET",$client['address'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CLIENTCITY",$client['city'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTNAME",$resultsetCust['contact'],$emailtemplate);
                $emailtemplate = str_replace("XXX_BUSINESSNAME",$businessName,$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTADDRESS",$resultsetCust['address'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTCITY",$resultsetCust['city'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTSTATE",$resultsetCust['state'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTPOSTCODE",$resultsetCust['postcode'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTPHONE",$resultsetCust['phone'],$emailtemplate);
                $emailtemplate = str_replace("XXX_CUSTEMAIL",$resultsetCust['email'],$emailtemplate);
                $emailtemplate = str_replace("XXX_TOTALPRICE","$".$totalPrice,$emailtemplate);
                $emailtemplate = str_replace("XXX_WindowNumber",$jobTotal['totalWindowNumber'],$emailtemplate);
                //$emailtemplate = str_replace("XXX_DISCOUNT","$".$discount,$emailtemplate);
                $emailtemplate = str_replace("XXX_NETPRICE","$".$netPrice,$emailtemplate);
                $emailtemplate = str_replace("XXX_TAXAMOUNT","$".$taxAmountFormate,$emailtemplate);
                $emailtemplate = str_replace("XXX_TAX",$tax."%",$emailtemplate);
                $emailtemplate = str_replace("XXX_FINALPRICE","$".$finalPriceFormate,$emailtemplate);
                $emailtemplate = str_replace("XXX_TABLEREPLACE",$tableReplace,$emailtemplate);
                $emailtemplate = str_replace("XXX_DISCOUNTROW",$discountrow,$emailtemplate);
                $emailtemplate = str_replace("XXX_GLASSTYPE",$glassType,$emailtemplate);
                $emailtemplate = str_replace("XXX_FRAMETYPE",$frameType,$emailtemplate);
                // $emailtemplate = str_replace("XXX_FILMTYPE",$filmType,$emailtemplate);
                
                SharedSendHtmlMail($resultsetCust['email'], $businessName, $client['email'],$client['name'], "Quote Confirmation", $emailtemplate);
                error_log("sending email");
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
      mysql_query("rollback", $dblink);
  }

  $response = array("errcode" => $errcode, "count" => $count, "clientid" => $clientid, "jobid" => $jobid);
  $json = json_encode($response);
  echo $json;
?>


