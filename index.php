<?php
  include("remedyshared.php");
  SharedInit();
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/index.php');
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
  <title>Tinting</title>
</head>
<body>
  <?php
    include("top.php");
  ?>
  <hr />
  <div id="page">
    <div id="content">
      <div id="content-bgtop">
        <div id="content-bgbtm">
        <div class="post">
            <h2 class="title">Welcome to Tint App</h2>
            <div class="entry">
            <p>
                Tint App a powerful app that has been designed by Window Tinters for Window Tinters.
                <br/>
                It will quickly and accurately prepare and submit quotes while capturing "Real Time" information entered by the operator.
                <br/>
                The back end will store, track and can prepare cutting sheets for use in the workshop without the need to re-enter or rewrite the information.  
                <br/>
                Targeted at individuals and organisations that can benefit from a cost effective, fast and accurate quotation preparation system that can manage all you quotations with ease and efficiency.   
                <br/>
                Tint App is a cost effective and time Saving app that will have you completing and submitting Professional Quotations in minutes that can be sent immediately to your customer while on site.  
              </p>
            <strong>Sing up today for your <a href="https://www.w3schools.com/html/"> free (30 Day) trial</a></strong> 
            </div>
          </div>

          <!-- <div class="post">
            <h2 class="title">Welcome to Remedy Tinting</h2>
            <div class="entry">
              <p><strong>Tinting</strong> is part of the Remedy Suite of iOS&reg; applications created by <a href="http://www.adtalk.com.au" target="_blank">Adtalk</a> and is targeted at organisations and individuals who are required to quote and order tinting jobs.</p>
              <p>The new <strong>Remedy Tinting</strong> app enables the user to capture "REAL TIME" information in the field, manage & GPS track all your tinting work with ease.</p>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <!-- end #content -->

    <?php
      include("left.php");
    ?>

    <div style="clear: both;">&nbsp;</div>

    <?php
      include("bottom.php");
    ?>
    <!-- end #footer -->
  </div>
</body>
</html>
