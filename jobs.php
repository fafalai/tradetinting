<?php
  include("logincheck.php");
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/jobs.php');
    //exit;
  }
  $dblink = SharedConnect();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php
            include("meta.php");
        ?>
        <script>
            function searchJobs() {
                var input, filter, table, tr, td, i, searchIndex;
                input = document.getElementById("searchInputJobs");
                filter = input.value.toUpperCase();
                table = document.getElementById("tblJobs");
                tr = table.getElementsByTagName("tr");
                searchIndex = 0;
                console.log()
                if (document.getElementById("searchName").checked) {
                    searchIndex = 1;
                } else if (document.getElementById("searchMobile").checked) {
                    searchIndex = 2;
                } else if (document.getElementById("searchCreatedDate").checked) {
                    searchIndex = 4;
                }
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[searchIndex];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
            $(function(){
                $("#topscroll").scroll(function(){
                    $("#divJobs").scrollLeft($("#topscroll").scrollLeft());
                });
                $("#divJobs").scroll(function(){
                    $("#topscroll").scrollLeft($("#divJobs").scrollLeft());
                });
            });
        </script>
        <meta http-equiv="refresh" content="60" />
        <title>Remedy Tint - View Jobs</title>

    </head>

    <body>
        <?php
            include ("top.php");
        ?>


        <div class="existingJobsDIV">
            <div class="container">
                <label>
                    <?php echo date("l, F j, Y"); ?>
                </label>
                <h2 class="clientTitle">Quotes</h2>
            </div>


            <div id="DIV_SearchJobs" class="container">
                <input id="searchInputJobs" class="form-control col-xl-4" type="text" onkeyup="searchJobs()" placeholder="Search by client name or mobile"
                    title="Type in a name or mobile">
                <div class="radio mb-2">
                    <input type="radio" name="search" value="Name" id="searchName" checked> Client Name
                </div>
                <div class="radio mb-2">
                    <input type="radio" name="search" value="Mobile" id="searchMobile"> Phone
                </div>
                <div class="radio">
                    <input type="radio" name="search" value="CreatedDate" id="searchCreatedDate"> Date (DD-MM-YYYY)
                </div>
            </div>

            <div class="container">
                <label style="margin-top:30px;font-size: 15px;">Select a Quote to see job details.</label>
            </div>

          
            
            <div class="container" style="margin-top:20px">
                <div class="topscroll" id="topscroll">
                    <table class="topscroll-div" id="topscrolldiv"></table>
                </div> 
                <div style="overflow-x:auto;table-layout:auto;width:100%;margin-top:20px" id="divJobs">
                    <table id="tblJobs" rules="cols" frame="box">
                        <tr>
                            <th>Quote</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <!-- <th>Area</th> -->
                            <th align="right">Date</th>
                            <!--                  <th align="left">Job ID</th>-->
                            <th>#Rooms</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Net Rate</th>
                            <th>Tax</th>
                            <th>Final Price</th>
                            <!-- <th>Job Date</th> -->
                            <th>P1</th>
                            <th>P2</th>
                            <th>P3</th>
                            <th>P4</th>
                            <th>P5</th>
                            <th>P6</th>
                            <th>P7</th>
                            <th>P8</th>
                            <th>P9</th>
                            <th>P10</th>
                            <th class="unsortable">Map</th>
                        </tr>
                        <?php
                            $where = "";
                            if ($_SESSION['admin'] != 0)
                            {
                                // Admins can see all their user's jobs...
                                $where = "j1.userscreated_id in " .
                                        "(" .
                                        "select " .
                                        "u1.id " .
                                        "from " .
                                        "users u1 " .
                                        "where " .
                                        "u1.cust_id=" . $_SESSION['custid'] . " " .
                                        "and " .
                                        "u1.active=1" .
                                        ")";
                            }
                            else
                            {
                                // Non-admin can only see their own jobs...
                                $where = "j1.userscreated_id=" . $_SESSION['loggedin'];
                            }
                            $dbselect = "select " .
                                        "j1.id jobid," .
                                        "j1.clients_id clientid," .
                                        "j1.userscreated_id usercreatedid," .
                                        "j1.jobno," .
                                        "j1.jobname," .
                                        "j1.gpslat," .
                                        "j1.gpslon," .
                                        "j1.notes as 'desc'," .
                                        "DATE_FORMAT(j1.datecreated,\"%d-%m-%Y %H:%i\") datecreated," .
                                        "DATE_FORMAT(j1.datejob,\"%d-%m-%Y %H:%i\") jobdate," .
                                        "j1.contact contact," .
                                        "j1.city city," .
                                        "j1.mobile mobile," .
                                        //   
                                        "totalrateinjob(j1.id) totalprice,".
                                        "j1.discount," .
                                        "j1.tax," .
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
                                        "u1.name usercreated," .
                                        "cl1.name clientname," .
                                        "cl1.address clientaddress," .
                                        "cl1.city clientcity," .
                                        "cl1.state clientstate," .
                                        "cl1.mobile clientmobile," .
                                        "numroomsinjob(j1.id) numrooms " .
                                        "from " .
                                        "jobs j1 left join users u1 on (j1.userscreated_id=u1.id) " .
                                        "        left join clients cl1 on (j1.clients_id=cl1.id) " .
                                        "where " .
                                        "j1.dateexpired is null " .
                                        "and " .
                                        "cl1.dateexpired is null " .
                                        "and " .
                                        $where . " " .
                                        "order by " .
                                        "j1.datecreated desc " .
                                        "limit 200";
                                        error_log($dbselect);
                            if ($dbresult = SharedQuery($dbselect, $dblink))
                            {
                                if ($numrows = SharedNumRows($dbresult))
                                {
                                while ($dbrow = SharedFetchArray($dbresult))
                                {
                                    $mapurl = SharedGoogleStaticMapUrl($dbrow['gpslat'], $dbrow['gpslon']);
                                    $notestip = SharedPrepareToolTip($dbrow['desc']);
                                    $contacttip = "<strong>Name: </strong>" . $dbrow['clientname'] . "<br />" .
                                                "<strong>Phone: </strong>" . $dbrow['clientmobile'] . "<br />" .
                                                "<strong>Address: </strong>" . $dbrow['clientaddress'] . "<br />" .
                                                "<strong>City: </strong>" . $dbrow['clientcity'] .", " . $dbrow['clientstate'] . "<br />";
                                    $clientname = ($dbrow['clientname'] == '') ? $dbrow['contact'] : $dbrow['clientname'];
                                    $clientcity = ($dbrow['clientcity'] == '') ? $dbrow['city'] : $dbrow['clientcity'];
                                    $clientmobile = ($dbrow['clientmobile'] == '') ? $dbrow['mobile'] : $dbrow['clientmobile'];
                                    $url_jobdetails = "jobdetails.php?jid=" . $dbrow['jobid']."&clientid=".$dbrow['clientid'];
                                    if($dbrow['totalprice'] == null)
                                    {
                                        $totalprice = 0.0000;
                                    }
                                    else
                                    {
                                        $totalprice = $dbrow['totalprice'];
                                    }
                                    $netrate = ($totalprice) - ($dbrow['discount']); 
                                    $finalprice = $netrate * (1+$dbrow['tax']*0.01);
                                    $p1 = ($dbrow["photo1"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo1"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p2 = ($dbrow["photo2"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo2"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p3 = ($dbrow["photo3"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo3"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p4 = ($dbrow["photo4"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo4"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p5 = ($dbrow["photo5"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo5"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p6 = ($dbrow["photo6"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo6"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p7 = ($dbrow["photo7"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo7"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p8 = ($dbrow["photo8"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo8"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p9 = ($dbrow["photo9"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo9"] . '" target="_blank"><img src="images/camera.png" /></a>';
                                    $p10 = ($dbrow["photo10"] == "") ? '&nbsp;' : '<a href="photos/' . $dbrow["photo10"] . '" target="_blank"><img src="images/camera.png" /></a>';
                        ?>
                            <tr>
                                <td align="right">
                                    <span class="hotspot" onmouseover="tooltip.show('<?php echo $contacttip; ?>');" onmouseout="tooltip.hide();">
                                        <a href="<?php echo $url_jobdetails;?>">
                                            <?php echo $dbrow['jobid']; ?>
                                        </a>
                                    </span>
                                </td>
                                <td align="left">
                                    <?php echo $clientname; ?>
                                </td>
                                <td align="right">
                                    <?php echo $clientmobile; ?>
                                </td>
                                <!-- <td align="left"><span class="hotspot" onmouseover="tooltip.show('<?php //echo $notestip; ?>');" onmouseout="tooltip.hide();"><?php //echo SharedPrepareDisplayString($dbrow['windowname']); ?></span></td> -->
                                <!-- <td align="right">
                                    <?php echo $clientcity; ?>
                                </td> -->
                                
                                <td align="right">
                                    <?php echo $dbrow['datecreated']; ?>
                                </td>
                                
                                <td align="right">
                                    <?php echo $dbrow['numrooms']; ?>
                                </td>
                                <td align="right">
                                    $
                                    <?php echo number_format($totalprice,2); ?>
                                </td>
                                <td align="right">
                                    $
                                    <?php echo number_format($dbrow['discount'],2); ?>
                                </td>
                                <td align="right">
                                    $
                                    <?php echo number_format($netrate,2); ?>
                                </td>
                                <td align="right">
                                    <?php echo number_format($dbrow['tax'],2); ?>%
                                </td>
                                <td align="right">
                                    $
                                    <?php echo number_format($finalprice,2); ?>
                                </td>
                                <!-- <td align="left">
                                
                                    <?php echo $dbrow['jobdate']; ?>
                                    
                                </td> -->
                                <td align="center">
                                    <?php echo $p1; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p2; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p3; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p4; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p5; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p6; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p7; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p8; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p9; ?>
                                </td>
                                <td align="center">
                                    <?php echo $p10; ?>
                                </td>
                                <td align="center">
                                    <a href="<?php echo $mapurl; ?>" target="_blank">
                                        <img src="images/map2.png" />
                                    </a>
                                </td>
                            </tr>
                            <?php
                    }
                }
                }
            ?>
                    </table>
                </div>

            </div>

            <div style="clear: both;">&nbsp;</div>
            <div style="clear: both;">&nbsp;</div>
        <?php
            include("bottom.php");
        ?>

        </div>
    </body>

</html>