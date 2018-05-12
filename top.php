<div id="header">
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

  <div id="search">
    <table>
      <tr>
        <td align="right" valign="top">
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
        <td align="right" valign="top"><img src="images/logo.png" width="29" height="29" alt="Remedy Logo" longdesc="http://www.remedyappserver.com"></td>
      </tr>
    </table>
  </div>
</div>

<div id="logo">
  <h1><img src="images/rttlogo.png" width="79" height="80"></h1>
  <p><em>Tinting</em> &bull; Assets &bull; Analysis</p>
</div>
