<?php
  if (!isset($_SERVER['HTTPS']))
  {
    //header('location: https://www.adtalk.services/testtag/contact.php');
    //exit;
  }
  require_once("remedyshared.php");
  require_once("class.phpmailer.php");
  SharedInit();

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <!-- Bootstrap CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->
        <?php include("meta.php");?>

        <title>FAQ</title>
    </head>

    <body>
        <?php include("top.php");?>
        <hr />
        <div class="container" style="width:70%">
            <label>
                <?php echo date("l, F j, Y"); ?>
            </label>
            <h2 class="clientTitle mb-2">FAQ</h2>
        </div>
    </body>

    </html>