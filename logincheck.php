<?php
  require_once("remedyshared.php");
  SharedInit();
  if (strpos($_SERVER['PHP_SELF'], "login.php"))
  {
    if (!isset($_SERVER['HTTPS']))
    {
      //header('location: https://www.adtalk.services/testtag/login.php');
      //exit;
    }
    // If we're already logged in, go to main page...
    if (SharedLogin())
    {
      //header('location: https://www.adtalk.services/testtag/index.php');
      header('location: index.php');
      exit;
    }
  }
  else
  {
    // We didn't come from this script, check if we're already logged in - if not, go back here
    if (!SharedLogin())
    {
      //header('location: https://www.adtalk.services/testtag/login.php');
      header('location: login.php');
      exit;
    }
  }
?>
