<script type="text/javascript">
      function redirect(address)
      {
        location.href = address;
      }

</script>
<div>
    <table>
      <tr>
        <td align="left" valign="top">
          <?php
            if (SharedIsLoggedIn())
            {
              echo $_SESSION['username'];
            }
            else
            {
              echo "&nbsp;";
            }
          ?>
        </td>
        <td align="left" valign="top"><img src="images/tint-app-logo.png" width="110" height="70" alt="Tinting Logo" longdesc="http://www.remedyappserver.com"></td>
      </tr>
    </table>
  </div>
</div>
<div id="header">
    <?php
      if (!SharedIsLoggedIn())
      {
      ?>
         <button id="login" onclick="redirect('login.php')" style="background-image: url('login_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">Log in</button>
         <button id="signup" onclick="redirect('signu.php')" style="background-image: url('signup_btn.png');width: 125px;height: 39px;cursor: pointer;font-size: 12pt;color: white;font-weight: bold">Sign up</button>
      <?php
      }
      else
      {
        echo "&nbsp;";
      }
    ?>
  <div id="menu">
    <ul>
      <li class="current_page_item"><a href="index.php" class="first">Home</a></li>
      <?php
        if (SharedIsLoggedIn())
        {
      ?>
          <li><a href="logout.php">Logout</a></li>
      <?php
        }
        else
        {
      ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
      <?php
        }
      ?>
      <li><a href="contact.php">Contact</a></li>
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
            <li><a href="clients.php">Clients</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="profile.php">Company</a></li>
            <li><a href="resource.php">Resource</a></li>

      <?php
          }
        }
      ?>      
    </ul>
  </div>

<div id="logo">
  <h1><img src="images/tint-app-logo.png" width="150" height="80"></h1>
</div>
