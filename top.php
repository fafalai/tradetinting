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

<?php if (SharedIsLoggedIn()){?>
<div id="DIV_headerContainer">

<?php if($expiresoon){ ?>
	<div class="alert-box">
    <span class="badge">Warning </span> Your Subscription is Expiring on  <?= date('Y-m-d', strtotime($licexpired))?>
  </div>  
		<?php }?>
	<?php
	if (!SharedIsLoggedIn()){
	?>
		<div class="topmenu" id="DIV_topMenu">
			<ul>
				<li>
					<a href="index.php">HOME</a>
				</li>
				<li>              
					<a href="contact.php">Contact Us</a>
				</li>
				<li>
					<a href="login.php">Log In</a>
				</li>
				<a href="signup.php">Sign Up</a>
			</ul>
		</div>
	<?php }elseif(SharedIsLoggedIn()){ ?>

	<div class="topmenu " id="DIV_topMenu">
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
                                    <a href="#">PROFILE</a>
                                    <div class="dropdown-content">
                                        <a href="profile.php">BUSINESS DETAILS</a>
                                        <a href="users.php" style="width:90%">USERS</a>
                                        <a href="subscription.php" style="width:90%">SUBSCRIPTION</a>
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
                        }?>

						<a href="logout.php">Logout</a>
						<?php
                      }
                        ?>
						<li>

						</li>
                        </ul>
					</div>
</div>
					<?php }?>
	<div class="clearfix"></div>

  <?php if($expiresoon){ ?>
	<style>.alert-box {
	background-color: #fffbcc;
	color: #777;
	font-size: 14px;
	line-height: 23px;
	padding: 3px 5px;
	text-align:center;
	font-family:Arial, Helvetica, sans-serif;
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

	<?php if($expiresoon){ ?>
	height:73px;
<?php }?>
}
</style>

          <?php }?>
