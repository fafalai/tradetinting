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
		<div id="DIV_faq">
			<div class="easyui-accordion" style="width:100%;align-self: center;">
				<div title="How do I register via the website" style="padding:10px;overflow:auto;" selected>
					<p style="line-height:1.15;">

						You need to register via the TintApp.com.au website. Click the “Sign Up” button on the top
						right.
						Enter your details and select a subscription plan, click the button at the bottom of the form.
					</p>
				</div>
				<div title="Can I register via the App" style="padding:10px">
					<p style="line-height:1.15;">
						Yes, when you open the App for the first time click the register link on the home page. The
						browser
						will
						open and direct you to the sign-up page on the portal.
						Follow the steps in point 1 to complete the register.
					</p>
				</div>
				<div title="Do I need to pay to use the App" style="padding:10px;">
					<p style="line-height:1.15;">
						Tint App is a subscription based app, which you have the option to subscribe annually or 3
						years.
					</p>
					<p style="line-height:1.15;">
						At the conclusion of your 30 day free trial period you select an annual plan or 3 Years plan,
						you
						will
						need
						to enter your credit card details to make a payment.
						After all the process is done, you have registered successfully.
					</p>
				</div>
				<div title="How do I log in to the Portal" style="padding:10px;">
					<p style="line-height:1.15;">
						On the portal, there is a “Log in” button on the top right. Click the button, it the site will
						navigate
						you
						to the login page. Enter your user name and password correctly.
					</p>
				</div>
				<div title="How do I log in to the App" style="padding:10px;">
					<p style="line-height:1.15;">
						On the app, when you open the app it will ask your user details. Enter user name and password
						correctly,
						then you will login.
					</p>
				</div>
				<div title="How do I reset my password for the App?" style="padding:10px;">
					<p style="line-height:1.15;">
						You need to reset your password by logging on the web portal and following the steps below.
					</p>
					<ol>
						<li> Click “Profile” on the top right menu, select “Users”</li>
						<li> Select your user ID from the table. </li>
						<li> You will see the form look like the screen shot below. There is a “Rest password” section.
							Enter
							your
							new
							password and repeat, click “Save” button at the bottom. Rest password is successful
						</li>
					</ol>
				</div>
				<div title="How do I access the information I uploaded from the App?" style="padding:10px;">
					<ol>
						<li>
							Log in to the portal with the user name and password when you register.
						</li>
						<li>
							There is a menu on the top.
						</li>
						<li>
							Click the ‘Clients’, you will see all the clients’ information you create on the app.
						</li>
						<li>
							Click ‘Jobs’, you will see all the jobs. Click the quote number, you will see all the
							installation
							details
							in this job.
						</li>
					</ol>
				</div>
				<div title="What happens when I am out of range and cannot upload to server?" style="padding:10px;">
					<ol>
						<li>
							The mobile application save all the data locally.
						</li>
						<li>
							When your phone has stable connection again, open the app, select the clients, go to‘Job
							Summary Page’, click ‘Submit’ button at the bottom (see image below). The data will send
							to
							the server properly.
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

</body>

</html>