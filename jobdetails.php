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
  <title>Remedy Tint - Job <?php echo $jobid; ?></title>
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
            <h2 class="clientTitle">QUOTE <?php echo $jobid; ?></h2>
            <div class="entry">
              <table border="0" align="left" id="tblJobs" rules="cols" frame="box" class="sortable" cellpadding="2" style="margin-bottom: 10px;margin-top:20px">
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
                  if ($dbresult = mysql_query($dbselect, $dblink))
                  {
                    if ($numrows = mysql_num_rows($dbresult))
                    {
                      while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
                      {
                        $notestip = SharedPrepareToolTip($dbrow['notes']);
                ?>
                        <tr>
                          <td align="left"><span class="title_room"><?php echo $dbrow['room']; ?></span></td>
                          <td align="left"><?php echo $dbrow['window']; ?></td>
                          <td align="right"><?php echo $dbrow['width']; ?></td>
                          <td align="right"><?php echo $dbrow['height']; ?></td>
                          <td align="right"><?php echo $dbrow['direction']; ?></td>
                          <td align="left"><?php echo $dbrow['frametype']; ?></td>
                          <td align="left"><?php echo $dbrow['glasstype']; ?></td>
                          <td align="left"><?php echo $dbrow['filmtype']; ?></td>
                          <td align="right"><?php echo $dbrow['totalarea']; ?></td>
                          <td align="right"><?php echo $dbrow['salerate']; ?></td>
                          <td align="right"><?php echo $dbrow['totalprice']; ?></td>
                          <td align="left"><?php echo $dbrow['datecreated']; ?></td>
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
