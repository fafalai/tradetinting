<?php
include "logincheck.php";

if (!isset($_SERVER['HTTPS'])) {
    //header('location: https://www.adtalk.services/testtag/jobs.php');
    //exit;
}
$dblink = SharedConnect();
$jobid = isset($_GET['jid']) ? $_GET['jid'] : '';
$clientid = isset($_GET['clientid']) ? $_GET['clientid'] : '';
$unit = "";

$dbselect = "select " .
    "cl1.id," .
    "cl1.code," .
    "cl1.name," .
    "cl1.notes as 'desc'," .
    "cl1.contact," .
    "cl1.mobile," .
    "cl1.address," .
    "cl1.city," .
    "cl1.state," .
    "cl1.postcode," .
    "DATE_FORMAT(cl1.datecreated,\"%d-%m-%Y %H:%i\") datecreated," .
    "DATE_FORMAT(cl1.datemodified,\"%d-%m-%Y %H:%i\") datemodified," .
    "cl1.gpslat," .
    "cl1.gpslon " .
    "from " .
    "clients cl1 " .
    "where " .
    "cl1.cust_id=" . $_SESSION['custid'] . " " .
    "and " .
    "id=" . $clientid . " " .
    "and " .
    "cl1.dateexpired is null";
if ($dbresult = SharedQuery($dbselect, $dblink)) {
    if ($numrows = SharedNumRows($dbresult)) {
        while ($dbrow = SharedFetchArray($dbresult)) {
            $clientName = SharedAddEllipsis($dbrow['name'], 20);
            $mobile = $dbrow['mobile'];
            $address = $dbrow['address'];
            $city = $dbrow['city'];
            $state = $dbrow['state'];
            $postcode = $dbrow['postcode'];
            $notes = $dbrow['desc'];
        }
    }
}
$dbselect = "select " .
    "c1.name," .
    "c1.desc," .
    "c1.identificationno," .
    "DATE_FORMAT(c1.datecreated,\"%Y-%m-%d %H:%i\") datecreated," .
    "DATE_FORMAT(c1.datemodified,\"%Y-%m-%d %H:%i\") datemodified," .
    "c1.contact," .
    "c1.phone," .
    "c1.mobile," .
    "c1.email," .
    "c1.address," .
    "c1.city," .
    "c1.state," .
    "c1.postcode," .
    "c1.country," .
    "c1.currency," .
    "c1.units " .
    "from " .
    "cust c1 " .
    "where " .
    "c1.id=" . $_SESSION['custid'];
if ($dbresult = SharedQuery($dbselect, $dblink))
{
    if ($numrows = SharedNumRows($dbresult))
    {
        while ($dbrow = SharedFetchArray($dbresult))
        {
           $unit = $dbrow['units'];
        }
    }
}

?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php include "meta.php";?>
        <meta http-equiv="refresh" content="300" />
        <title>Remedy Tint - Job
            <?php echo $jobid; ?>
        </title>
        <style type="text/css" media="print">
            @page {
                size: A4 landscape;
            }

            @media print {
                table th{
                    width:130px
                }
            }

            #DIV_topMenu,
            #div_Hide,
            #div_Back,
            #DIV_showUser {
                display: none;
            }

            #info_Client {
                border: solid 1px;
            }

            body,
            #tblJobs{
                table-layout:auto;
                width:100%;
            }
            .existingJobDetailsDIV,
            #DIV_headerContainer {
                width: 100%;
                margin: 0;
                height: auto;
                /* page-break-after: avoid; */
            }

            label {
                margin-bottom: 5px;
            }

            #info_Client {
                margin-top: 0px;
                margin-bottom: 20px;
                backgroundcolor:red;
                /* padding: 0px; */
            }
        </style>
        <script>
             $(function(){
                $("#topscroll").scroll(function(){
                    $("#divJobDetails").scrollLeft($("#topscroll").scrollLeft());
                });
                $("#divJobDetails").scroll(function(){
                    $("#topscroll").scrollLeft($("#divJobDetails").scrollLeft());
                });
            });
        </script>

    </head>

    <body>
        <?php include "top.php";?>
        <!-- <div style="clear: both;">&nbsp;</div> -->

        <div class="existingJobDetailsDIV">
            
            <h1 style="text-transform:capitalize;font-size:30pt;font-weight:bold">Installation Details</h1>
            <label>
                <?php echo date("l, F j, Y"); ?>
            </label>
            <!-- <table> -->
            <!-- <th style="width:20%"> -->
            <h2 class="clientTitle">QUOTE
                <?php echo $jobid; ?>
            </h2>
            <br>

            <div id="div_Back" class="row">
                <div class="col-11">
                    <a id="link_Back" href="#" onClick="javascript:history.back(-1);">&#60; BACK TO JOBS</a>
                </div>
                <div class="col-*">
                    <a href="#" onClick="window.print();return false;">
                        <img id="img_Print" src="images/print.png" width="30" heigth="30">
                    </a>
                    <!-- <form action="" method="post">
                                        <input type="image" name="print" value="print" formtarget="_blank" src="images/print.png"  width="30" heigth="30"/>
                                    </form> -->
                </div>
            </div>
            <!-- </th> -->
            <!-- <th style="width:20%"> -->
            <div id="info_Client" style="background-color:#d8dad8" class="py-3 text-dark col-4">
                <b>
                    Client name:
                    <?php echo ucwords(strtolower($clientName)); ?>
                    </p>
                    <p>Phone:
                        <?php echo $mobile; ?>
                    </p>
                    <label>Address:
                        <?php echo $address . " " . $city . " " . $state ." ". $postcode ?>
                    </label>
                    <br/>
                    <label>Notes:
                        <?php echo $notes ?>
                    </label>
                </b>
            </div>
            <!-- </th> -->
            <!-- </table> -->
            <div class="entry">
                <div id="div_Hide" style="margin:10px 0 10px 0;font-size: 14px;" class="button-group bg-white">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle bg-white mx-1" data-toggle="dropdown">Hide
                            <span class="caret"></span>
                        </button>
                        <span>(Hide specific fields for Cutting List)</span>
                    <ul id="ul_dropdownlist" class="dropdown-menu px-2">
                        <li>
                            <a href="#" class="small" data-value="0" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Select All</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="1" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Room</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="2" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Window</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="3" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Width</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="4" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Height</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="5" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Direction</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="6" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Frame</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="7" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Glass</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="8" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Film</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="9" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Area</a>
                        </li>
                        <!-- <li>
                            <a href="#" class="small" data-value="10" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Rate</a>
                        </li>
                        <li>
                            <a href="#" class="small" data-value="11" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Price</a>
                        </li> -->
                        <li>
                            <a href="#" class="small" data-value="10" tabIndex="-1">
                                <input type="checkbox" />&nbsp;Created</a>
                        </li>
                    </ul>
                </div>
                <div class="topscroll" id="topscroll">
                    <table class="topscroll-div" id="topscrolldiv"></table>
                </div> 
                <div style="overflow-x:auto;table-layout:auto;width:100%;margin-top:20px" id="divJobDetails">
                    <table id="tblJobs" rules="cols" frame="box">
                        <tr>
                            <th align="left">Room</th>
                            <th align="left">Window</th>
                            <th align="right">
                            <?php
                                if ($unit == "mm")
                                {
                                    echo "Width (mm)";
                                }
                                else
                                {
                                    echo "Width (in)";
                                }
                            ?>
                            </th>
                            <th align="right">
                            <?php
                                if ($unit == "mm")
                                {
                                    echo "Height (mm)";
                                }
                                else
                                {
                                    echo "Height (in)";
                                }
                            ?>
                            
                            </th>
                            <th align="left">Direction</th>
                            <th align="left">Frame</th>
                            <th align="left">Glass</th>
                            <th align="left">Film</th>
                            <th align="right">
                                <?php
                                    if ($unit == "mm")
                                    {
                                        echo "Area (m2)";
                                    }
                                    else
                                    {
                                        echo "Area (ft2)";
                                    }
                                ?>
                            </th>
                            <!-- <th align="right">Rate</th>
                            <th align="right">Price</th> -->
                            <th align="right">Created</th>
                        </tr>
                        <?php
                            $dbselect = "select " .
                                "jd1.id jobdetailid," .
                                "jd1.name room," .
                                "jd1.altname window," .
                                "jd1.width," .
                                "jd1.height," .
                                "jd1.notes," .
                                "jd1.glasstype," .
                                "jd1.frametype," .
                                "jd1.filmtype," .
                                "jd1.direction," .
                                "jd1.salerate," .
                                "jd1.totalarea," .
                                "jd1.totalprice," .
                                "DATE_FORMAT(jd1.datecreated,\"%d-%m-%Y %H:%i\") datecreated " .
                                "from " .
                                "jobdetails jd1 " .
                                "where " .
                                "jd1.dateexpired is null " .
                                "and  " .
                                "jd1.jobs_id=$jobid " .
                                "order by " .
                                "jd1.name, " .
                                "jd1.altname, " .
                                "datecreated desc " .
                                "limit 200";

                            error_log("select job details:");
                            error_log($dbselect);
                            if ($dbresult = SharedQuery($dbselect, $dblink)) {
                                if ($numrows = SharedNumRows($dbresult)) {
                                    $sum = 0;
                                    while ($dbrow = SharedFetchArray($dbresult)) {
                                        $notestip = SharedPrepareToolTip($dbrow['notes']);
                                        $sum += $dbrow['totalarea'];

                        ?>
                        <tr>
                            <td align="left">
                                <span class="title_room">
                                    <?php echo $dbrow['room']; ?>
                                </span>
                            </td>
                            <td align="left">
                                <?php echo $dbrow['window']; ?>
                            </td>
                            <td align="right">
                                <?php echo number_format($dbrow['width']); ?>
                                <!-- remove the 2 decimal places, no needed -->
                            </td>
                            <td align="right">
                                <?php echo number_format($dbrow['height']); ?>
                                <!-- remove the 2 decimal places, no needed -->
                            </td>
                            <td align="right">
                                <?php echo $dbrow['direction']; ?>
                            </td>
                            <td align="left">
                                <?php echo $dbrow['frametype']; ?>
                            </td>
                            <td align="left">
                                <?php echo $dbrow['glasstype']; ?>
                            </td>
                            <td align="left">
                                <?php echo $dbrow['filmtype']; ?>
                            </td>
                            <td align="right">
                                <?php echo number_format($dbrow['totalarea'],3); ?>
                            </td>
                            <!-- <td align="right">
                                <?php echo number_format($dbrow['salerate'],2); ?>
                            </td>
                            <td align="right">
                                $
                                <?php echo number_format($dbrow['totalprice'],2); ?>
                            </td> -->
                            <td align="left">
                                <?php echo $dbrow['datecreated']; ?>
                            </td>
                        </tr>
                        <?php
                            }
                                }
                            }
                        ?>

                    <th align="left"></th>
                        <th align="left"></th>
                        <th align="right">
                        </th>
                        <th align="right">
                        </th>
                        <th align="left"></th>
                        <th align="left"></th>
                        <th align="left"></th>
                        <th align="left">Total: </th>
                        <th align="right">
                            <?php  echo number_format($sum,3); ?>
                        </th>
                        <!-- <th align="right"></th>
                        <th align="right"></th> -->
                        <th align="right"></th>
                    </tr>
                    </table>

                    <div style="clear: both;">&nbsp;</div>

                </div>
            </div>


            <?php include "bottom.php";?>
        </div>
        <script src="js/jobdetails.js"></script>
    </body>

    </html>