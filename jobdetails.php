<?php
include "logincheck.php";
if (!isset($_SERVER['HTTPS'])) {
    //header('location: https://www.adtalk.services/testtag/jobs.php');
    //exit;
}
$dblink = SharedConnect();
$jobid = isset($_GET['jid']) ? $_GET['jid'] : '';
$clientid = isset($_GET['clientid']) ? $_GET['clientid'] : '';

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
    "DATE_FORMAT(cl1.datecreated,\"%Y-%m-%d %H:%i\") datecreated," .
    "DATE_FORMAT(cl1.datemodified,\"%Y-%m-%d %H:%i\") datemodified," .
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
    </head>

    <body>
        <?php include "top.php";?>
        <!-- <div style="clear: both;">&nbsp;</div> -->
        <div>
            <div>
                <div>
                    <div>
                        <div class="existingJobDetailsDIV">
                            <label>
                                <?php if ($clientmsg != "") {
                                    echo $clientmsg;
                                } else {
                                    echo date("l, F j, Y");
                                }?>
                            </label>
                            <!-- <table> -->
                            <!-- <th style="width:20%"> -->
                            <h2 class="clientTitle">QUOTE
                                <?php echo $jobid; ?>
                            </h2>
                            <br>

                            <div class="row">
                                <div class="col-11">
                                    <a href="#" onClick="javascript:history.back(-1);">&#60;BACK TO JOBS</a>
                                </div>
                                <div class="col-*">
                                    <a href="#" onClick="window.print();return false;">
                                        <img src="images/print.png" width="30" heigth="30">
                                    </a>
                                </div>
                            </div>
                            <!-- </th> -->
                            <!-- <th style="width:20%"> -->
                            <div style="background-color:#d8dad8" class="my-2 py-3 text-dark col-4">
                                <b>
                                    Client name:
                                    <?php echo $clientName; ?>
                                    </p>
                                    <p>Mobile:
                                        <?php echo $mobile; ?>
                                    </p>
                                    <label>Address:
                                        <?php echo $address . " " . $city . " " . $state . $postcode ?>
                                    </label>
                                </b>
                            </div>
                            <!-- </th> -->
                            <!-- </table> -->
                            <div class="entry">
                                <div class="button-group bg-white">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle bg-white mx-1" data-toggle="dropdown">Hide
                                        <span class="caret"></span>
                                    </button>
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
                                        <li>
                                            <a href="#" class="small" data-value="10" tabIndex="-1">
                                                <input type="checkbox" />&nbsp;Rate</a>
                                        </li>
                                        <li>
                                            <a href="#" class="small" data-value="11" tabIndex="-1">
                                                <input type="checkbox" />&nbsp;Price</a>
                                        </li>
                                        <li>
                                            <a href="#" class="small" data-value="12" tabIndex="-1">
                                                <input type="checkbox" />&nbsp;Created</a>
                                        </li>
                                    </ul>
                                </div>
                                <table align="left" id="tblJobs" rules="cols" frame="box" class="sortable table table-bordered">
                                    <tr>
                                        <th align="left">Room</th>
                                        <th align="left">Window</th>
                                        <th align="right">Width</th>
                                        <th align="right">Height</th>
                                        <th align="left">Direction</th>
                                        <th align="left">Frame</th>
                                        <th align="left">Glass</th>
                                        <th align="left">Film</th>
                                        <th align="right">Area</th>
                                        <th align="right">Rate</th>
                                        <th align="right">Price</th>
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
    "DATE_FORMAT(jd1.datecreated,\"%Y-%m-%d %H:%i\") datecreated " .
    "from " .
    "jobdetails jd1 " .
    "where " .
    "jd1.dateexpired is null " .
    "and  " .
    "jd1.jobs_id=$jobid " .
    "order by " .
    "jd1.datecreated desc " .
    "limit 200";
if ($dbresult = SharedQuery($dbselect, $dblink)) {
    if ($numrows = SharedNumRows($dbresult)) {
        while ($dbrow = SharedFetchArray($dbresult)) {
            $notestip = SharedPrepareToolTip($dbrow['notes']);
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
                                                <?php echo number_format($dbrow['width'],2); ?>
                                            </td>
                                            <td align="right">
                                                <?php echo number_format($dbrow['height'],2); ?>
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
                                                <?php echo number_format($dbrow['totalarea'],2); ?>
                                            </td>
                                            <td align="right">
                                                <?php echo number_format($dbrow['salerate'],2); ?>
                                            </td>
                                            <td align="right">
                                                $
                                                <?php echo number_format($dbrow['totalprice'],2); ?>
                                            </td>
                                            <td align="left">
                                                <?php echo $dbrow['datecreated']; ?>
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
                    </div>
                </div>
            </div>


            <?php include "bottom.php";?>
        </div>
        <script src="js/jobdetails.js"></script>
    </body>

    </html>