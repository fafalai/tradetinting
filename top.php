<head>
    <!-- <link rel="stylesheet" type="type/css" href="styles.css"> -->
    <script type="text/javascript">
        function redirect(address) {
            location.href = address;
        }

    </script>
</head>

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
            <a href="index.php"><img src="images/tint-app-logo.png" alt="Tinting Logo" longdesc="http://www.remedyappserver.com"></a>
        </div>
        <?php
            if (!SharedIsLoggedIn())
            {
            ?>
            <div id="DIV_topLoginSignUp">
                <button id="login" onclick="redirect('login.php')" style="background-image: url('images/login_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold;">Log in</button>
                <button id="signup" onclick="redirect('signu.php')" style="background-image: url('images/signup_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">&nbsp;&nbsp;&nbsp;Sign up</button>
            </div>
            <?php
            }
            else
            {
              echo "&nbsp;";
            }
          ?>

                <div class="topmenu" id="DIV_topMenu">
                    <ul>
                        <?php
                        if (SharedIsLoggedIn())
                        {
                      ?>

                            <li><a href="jobs.php">Jobs</a></li>
                            <?php
                        if ($_SESSION['admin'] != 0)
                        {
                      ?>
                                <!-- <li><a href="tagreps.php">Reports</a></li> -->
                                <li class="current_page_item"><a href="index.php" class="first">Home</a></li>
                                <li><a href="clients.php">Clients</a></li>
                                <li><a href="resource.php">Resource</a></li>
                                <li><a href="contact.php">Contact</a></li>
                                <div class="dropdown">
                                    <li><a style="cursor: pointer">Account</a></li>
                                    <!-- <li><button style="border:none"></button>Account</button></li> -->
                                    <div class="dropdown-content">
                                        <a href="profile.php">Business Details</a>
                                        <a href="users.php">Users</a>
                                        <a href="logout.php">Logout</a>
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

