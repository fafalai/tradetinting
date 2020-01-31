<!--
<head>
     <link rel="stylesheet" type="type/css" href="styles.css">
    <script type="text/javascript">
        function redirect(address) {
            location.href = address;
        }
    </script>

</head>
-->

<?php
//              if (SharedIsLoggedIn())
//              {
//                echo $_SESSION['username'];
//              }
//              else
//              {
//                echo "&nbsp;";
//              }
            ?>
<?php

  $c_id=$_SESSION['custid'];
  $dbselect = "select " .
  "u1.licexpired, " .
  "u1.period " .
  "from " .
  "users u1 " .
  "where " .
  "u1.cust_id='$c_id'";
if ($dbresult = SharedQuery($dbselect, $dblink)){

	if ($numrows = SharedNumRows($dbresult)){
		while ($dbrow = SharedFetchArray($dbresult))
		{
			$licexpired = $dbrow['licexpired'];
			$period = $dbrow['period'];
		}
	}else{
    $licexpired = 0;
    $period = 0;
  }
}else{
  $licexpired = 0;
  $period = 0;
}
	$expiresoon=false;
if (($period==0) && (strtotime($licexpired."-7 day")<=strtotime("now")) && ((strtotime($licexpired)>strtotime("now")))){
	$expiresoon=true;

}elseif(($period!=0) && (strtotime($licexpired."-14 day")<=strtotime("now"))&& ((strtotime($licexpired)>strtotime("now")))){
	$expiresoon=true;
}
?>
    <div id="DIV_headerContainer">
        <div id="DIV_topImage">
            <a href="index.php">
                <img src="images/tint-app-logo.png" alt="Tinting Logo" longdesc="http://www.remedyappserver.com">
            </a>
        </div>
        <?php
            if (!SharedIsLoggedIn())
            {
        ?>
            <div id="DIV_topLoginSignUp">
                <button id="signup" onclick="redirect('index.php')" style="background-image: url('images/login_btn.png');width: 132px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Home</button>
                <button id="signup" onclick="redirect('contact.php')" style="background-image: url('images/signup_btn.png');width: 132px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Contact Us</button>
                <button id="login" onclick="redirect('login.php')" style="background-image: url('images/login_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold;">&nbsp;&nbsp;Log in</button>
                <button id="signup" onclick="redirect('signup.php')" style="background-image: url('images/signup_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">&nbsp;&nbsp;&nbsp;Sign up</button>
            </div>
            <?php
            }
            else
            {
              echo "&nbsp;";
            }
            ?>

                <?php
                        if (SharedIsLoggedIn())
                        {
                      ?>
                    <div id="DIV_showUser" class="pull-right">Welcome,


						<?php echo $_SESSION['username'];?>

                        <a href="logout.php">Logout</a>
                    </div>
                    <!-- <div class="float-none"></div> -->
                    <br>
                    <br>
                    <br>
                    <div class="topmenu pull-right" id="DIV_topMenu">
                        <ul>
                            <li>
                                <a href="index.php">HOME</a>
                            </li>
                            <li>
                                <a href="jobs.php">JOBS</a>
                            </li>
                            <?php
                        if ($_SESSION['admin'] != 0)
                        {
                      ?>
                                <!-- <li><a href="tagreps.php">Reports</a></li> -->
                                <li>
                                    <a href="clients.php">CLIENTS</a>
                                </li>
                                <li>
                                    <a href="resource.php">RESOURCES</a>
                                </li>
                                <li>
                                    <a href="faq.php">FAQ</a>
								</li>
								<Li>
                                <div class="dropdown">
                                    <!-- <li> -->
                                    <a href="#">PROFILE</a>
                                    <!-- </li> -->
                                    <!-- <li><button style="border:none"></button>Account</button></li> -->
                                    <div class="dropdown-content">
                                        <a href="profile.php">BUSINESS DETAILS</a>
                                        <a href="users.php" style="width:90%">USERS</a>
                                        <a href="subscription.php" style="width:90%">SUBSCRIPTION</a>
                                        <!--                                        <a href="logout.php">LOGOUT</a>-->
                                    </div>
								</div>
						</li>
                                <li>
                                    <a href="contact.php">HELP</a>
                                </li>
                                <?php
                          }

                        else
                        {
                          echo "&nbsp;";
                        }
                      }
                        ?>
                        </ul>
					</div>
	</div>
	<?php if($expiresoon){ ?>
							<!-- , <span style="background-color:red; font-size:1.5em">You subscription is Expiring on ; </span> -->

	<div class="alert-box">
    <span class="badge">Warning </span> Your Subscription is Expiring on  <?= date('Y-m-d', strtotime($licexpired))?>
  </div>
						<?php }?>
	<div class="clearfix"></div>

  <?php if($expiresoon){ ?>
	<style>.alert-box {
	background-color: #fffbcc;
	color: #777;
	font-size: 14px;
	line-height: 23px;
	padding: 13px 16px;
	text-align:center;
	font-family:Arial, Helvetica, sans-serif;

	margin-bottom:15px;
}
.alert-box .badge {
	background-color: #f58f2a;
	border-radius: 3px;
	color: #fff;
	margin-left: 4px;
	margin-right: 4px;
	padding: 3px 5px 3px 4px;
	font-weight:bold;
	text-transform: uppercase;
}
#DIV_headerContainer{
	height:156px;
}
</style>

          <?php }?>
