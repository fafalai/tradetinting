<head>
  <!-- <link rel="stylesheet" type="type/css" href="styles.css"> -->
  <script type="text/javascript">
      function redirect(address)
      {
        location.href = address;
      }
</script>
</head>
<div style="padding: 10px;margin-bottom: 40px">
  <table style="background-color:white;padding: 20px">
    <tr>
      <td align="right" valign="top"><img src="images/tint-app-logo.png" width="220" height="100" alt="Tinting Logo" longdesc="http://www.remedyappserver.com" style="margin-left: 100px;padding: 10px"></td>
      <td align="right">
            <?php
            if (!SharedIsLoggedIn())
            {
            ?>
               <button id="login" onclick="redirect('login.php')" style="background-image: url('images/login_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold;margin-left: 150px">Log in</button>
               <button id="signup" onclick="redirect('signu.php')" style="background-image: url('images/signup_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">&nbsp;&nbsp;&nbsp;Sign up</button>
            <?php
            }
            else
            {
              echo "&nbsp;";
            }
          ?>
      </td>
      <td>
        <div class="topmenu">
          <ul>
            <ul>
              <?php
                 if (SharedIsLoggedIn())
                 {
              ?>
                  <li class="current_page_item"><a href="index.php" class="first">Home</a></li>
                  <li><a href="jobs.php">Jobs</a></li>
                  <?php
                    if ($_SESSION['admin'] != 0)
                    {
                  ?>
                      <li><a href="clients.php">Clients</a></li>
                      <li><a href="resource.php">Resource</a></li>
                      <li><a href="contact.php">Contact</a></li>
                      <div class="dropdown">
                        <li><a style="cursor: pointer">Account</a></li>
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
          </ul>
        </div>

      </td>
    </tr>
  </table>
</div>