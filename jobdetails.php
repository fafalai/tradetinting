<?php
include("logincheck.php");
if (!isset($_SERVER['HTTPS']))
{
    //header('location: https://www.adtalk.services/testtag/jobs.php');
    //exit;
}
$dblink = SharedConnect();
$jobid = isset($_GET['jid']) ? $_GET['jid'] : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php
        include("meta.php");
        ?>
        <meta http-equiv="refresh" content="300" />
        <title>Remedy Tint - Job
            <?php echo $jobid; ?>
        </title>
    </head>

    <body>
        <?php
        include ("top.php");
        ?>
        <div style="clear: both;">&nbsp;</div>
        <div>
            <div>
                <div>
                    <div>
                        <div class="existingJobDetailsDIV">
                            <label><?php if ($clientmsg != "") echo $clientmsg; else echo date("l, F j, Y"); ?></label>
                            <h2 class="clientTitle">QUOTE
                                <?php echo $jobid; ?>
                            </h2>
                            <div class="entry">

                                <div class="button-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button>
                                    <ul id="ul_dropdownlist" class="dropdown-menu" style="padding:6px;">
                                        <li><a href="#" class="small" data-value="1" tabIndex="-1"><input type="checkbox"/>&nbsp;Room</a></li>
                                        <li><a href="#" class="small" data-value="2" tabIndex="-1"><input type="checkbox"/>&nbsp;Window</a></li>
                                        <li><a href="#" class="small" data-value="3" tabIndex="-1"><input type="checkbox"/>&nbsp;Width</a></li>
                                        <li><a href="#" class="small" data-value="4" tabIndex="-1"><input type="checkbox"/>&nbsp;Height</a></li>
                                        <li><a href="#" class="small" data-value="5" tabIndex="-1"><input type="checkbox"/>&nbsp;Direction</a></li>
                                        <li><a href="#" class="small" data-value="6" tabIndex="-1"><input type="checkbox"/>&nbsp;Frame</a></li>
                                        <li><a href="#" class="small" data-value="7" tabIndex="-1"><input type="checkbox"/>&nbsp;Glass</a></li>
                                        <li><a href="#" class="small" data-value="8" tabIndex="-1"><input type="checkbox"/>&nbsp;Film</a></li>
                                        <li><a href="#" class="small" data-value="9" tabIndex="-1"><input type="checkbox"/>&nbsp;Area</a></li>
                                        <li><a href="#" class="small" data-value="10" tabIndex="-1"><input type="checkbox"/>&nbsp;Rate</a></li>
                                        <li><a href="#" class="small" data-value="11" tabIndex="-1"><input type="checkbox"/>&nbsp;Price</a></li>
                                        <li><a href="#" class="small" data-value="12" tabIndex="-1"><input type="checkbox"/>&nbsp;Created</a></li>
                                    </ul>
                                </div>

                                <table id="Table_jobdetails" align="left" id="tblJobs" rules="cols" frame="box" class="sortable" cellpadding="2">
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
                                    if ($dbresult = SharedQuery($dbselect, $dblink))
                                    {
                                        if ($numrows = SharedNumRows($dbresult))
                                        {
                                            while ($dbrow = SharedFetchArray($dbresult))
                                            {
                                                $notestip = SharedPrepareToolTip($dbrow['notes']);
                                    ?>
                                    <tr>
                                        <td align="left"><span class="title_room"><?php echo $dbrow['room']; ?></span></td>
                                        <td align="left">
                                            <?php echo $dbrow['window']; ?>
                                        </td>
                                        <td align="right">
                                            <?php echo $dbrow['width']; ?>
                                        </td>
                                        <td align="right">
                                            <?php echo $dbrow['height']; ?>
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
                                            <?php echo $dbrow['totalarea']; ?>
                                        </td>
                                        <td align="right">
                                            <?php echo $dbrow['salerate']; ?>
                                        </td>
                                        <td align="right">
                                            <?php echo $dbrow['totalprice']; ?>
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

            <div style="clear: both;">&nbsp;</div>

            <?php
            include("bottom.php");
            ?>

        </div>
    </body>

</html>
