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
    <!DOCTYPE html>
    <html>

    <head>
        <?php include("meta.php");?>
        <title>Sign Up</title>
    </head>

    <body>
        <?php include("top.php");?>

        <div class="m-auto container" style="width:60%">
            <h1 class="text-dark">Sign Up</h1>
            <form style="background-color:#f0f0f0;" action="#" method="post" id="frmSignup" class="p-4">
                <div class="row">
                    <input id="sign_id" class="form-control" type="text" placeholder="NAME">
                </div>
                <div class="row">
                    <input id="sign_phone" class="form-control col-sm-5" type="text" placeholder="PHONE">
                    <input id="sign_email" class="form-control col" type="text" placeholder="EMAIL">
                </div>
                <div class="row">
                    <input id="sign_country" class="form-control" type="text" placeholder="COUNTRY">
                </div>
                <div class="row">
                    <input id="sign_address" class="form-control" type="text" placeholder="ADDRESS">
                </div>
                <div class="row">
                    <input id="sign_city" class="form-control col-sm-5" type="text" placeholder="CITY">
                    <input id="sign_state" class="form-control col-sm" type="text" placeholder="STATE">
                    <input id="sign_pcode" class="form-control col-sm" type="text" placeholder="P/CODE">
                </div>
                <span class="myhr"></span>
                <div class="row">
                    <input id="sign_password" class="form-control col-sm-5" type="text" placeholder="PASSWORD">
                    <input class="form-control col" type="text" placeholder="RE-ENTER PASSWORD">
                </div>
                <span class="myhr"></span>

                <h2 class="text-dark mt-5">
                    <b>PLAN SELECTION</b>
                </h2>
                <div class="form-group text-dark">
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="opt_1">30 day free trial</h6>
                    </div>
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="opt_2">Annual plan - USD $99 per year (save 17% *)</h6>
                    </div>
                    <div class="radio">
                        <h6>
                            <input type="radio" name="plan_opt" value="opt_3">3 Year plan - USD $250 (save 30% *)</h6>
                    </div>
                    <label class="ml-5">* in comparison to purchasing a monthly plan</label>
                </div>
                <div>
                <button class="btn-danger btn-lg">SIGN UP</button>
                </div>
            </form>
        </div>
        <?php include("bottom.php");?>
    </body>

    </html>