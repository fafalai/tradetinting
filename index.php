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
    <?php include("meta.php");?>
    <title>Tinting</title>
  </head>

  <body>
    <?php include("top.php");?>
    <hr />
    <?php
        if (!SharedIsLoggedIn())
        {
		//   include("introducing.php");
		include("login.php");
         }
        else
        {
          include("welcome.php");
        }
      ?>


      <!-- <div id="page">
    <div id="content">
      <div id="content-bgtop">
        <div id="content-bgbtm">
        <div class="post">
           
           
          </div>

          <!- <div class="post"> 
            <h2 class="title">Welcome to Remedy Tinting</h2>
            <div class="entry">
              <p><strong>Tinting</strong> is part of the Remedy Suite of iOS&reg; applications created by <a href="http://www.adtalk.com.au" target="_blank">Adtalk</a> and is targeted at organisations and individuals who are required to quote and order tinting jobs.</p>
              <p>The new <strong>Remedy Tinting</strong> app enables the user to capture "REAL TIME" information in the field, manage & GPS track all your tinting work with ease.</p>
            </div>
          </div> -->
      <!--        </div>-->
      <!--      </div>-->
      <!--    </div>-->
      <!-- end #content -->
      <?php
        if (!SharedIsLoggedIn())
        {
          include("feature.php");
         }
        else
        {
          // include("sections.php");
        }
      ?>
        <div style="display:none;">
          <div style="font-size: 24px; text-align: center;" class="mb-3">
            <b class="text-dark">HOW TO USE THIS APP</b>
          </div>
          <div class="easyui-accordion mx-auto" style="width:50%;height1:300px;">
            <div title="Clent" style="overflow:auto;padding:10px;">
              <p>A programming language is a formal language designed to communicate instructions to a machine, particularly
                a computer. Programming languages can be used to create programs that control the behavior of a machine and/or
                to express algorithms precisely.</p>
            </div>
            <div title="Jobs" style="padding:10px;">
              <p>Java (Indonesian: Jawa) is an island of Indonesia. With a population of 135 million (excluding the 3.6 million
                on the island of Madura which is administered as part of the provinces of Java), Java is the world's most
                populous island, and one of the most densely populated places in the world.</p>
            </div>
          </div>
        </div>
        <div style="clear: both;">&nbsp;</div>

        <?php include("bottom.php");?>
        <!-- end #footer -->
        <!--  </div>-->
  </body>

  </html>