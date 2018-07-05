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
                <button id="login" onclick="redirect('login.php')" style="background-image: url('images/login_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold;">Log in</button>
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
                                    <a href="contact.php">CONTACT</a>
                                </li>
                                <div class="dropdown">
                                    <!-- <li> -->
                                    <a href="#">ACCOUNT</a>
                                    <!-- </li> -->
                                    <!-- <li><button style="border:none"></button>Account</button></li> -->
                                    <div class="dropdown-content">
                                        <a href="profile.php">BUSINESS DETAILS</a>
                                        <a href="users.php" style="width:90%">USERS</a>
                                        <!--                                        <a href="logout.php">LOGOUT</a>-->
                                    </div>
                                </div>
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
    <div class="clearfix"></div>