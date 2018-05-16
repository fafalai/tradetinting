<script type="text/javascript">
      function redirect(address)
      {
        location.href = address;
      }

</script>
<div style="padding: 10px;margin-bottom: 80px">
  <table style="background-color:white;padding: 20px">
          <tr>
            <td align="right" valign="top"><img src="images/tint-app-logo.png" width="220" height="100" alt="Tinting Logo" longdesc="http://www.remedyappserver.com" style="margin-left: 100px;padding: 10px"></td>
            <?php
              if (!SharedIsLoggedIn())
              {
              ?>
                <td>
                  <button id="login" onclick="redirect('login.php')" style="background-image: url('login_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold;margin-left: 200px">Log in</button>
                </td>
                <td>
                  <button id="signup" onclick="redirect('signu.php')" style="background-image: url('signup_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">&nbsp;&nbsp;&nbsp;Sign up</button>
                </td>
              <?php
              }
              else
              {
                echo "&nbsp;";
              }
              ?>

            <td>
              <div id="menu">
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
                                <li>Account</li>
                                <!-- <li><button style="border:none"></button>Account</button></li> -->
                                <div class="dropdown-content">
                                  <a href="profile.php">Business Details</a>
                                  <a href="users.php">Users</a>
                                  <a href="logout.php">Logout</a>
                                </div>
                          </div>
                      <?php
                        }
                      ?>
                  <?php
                      }
                      else
                      {
                        echo "&nbsp;";
                      }
                      ?>     
                </ul>
              </div>
            </td>
          </tr>
  </table>
</div>

<!-- <div id="logo">
  <h1><img src="images/tint-app-logo.png" width="150" height="80"></h1>
</div> -->
