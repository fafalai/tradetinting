<div id="sidebar">
    <!-- <div id="footer"> -->
    <ul>
        <?php
        if (isset($_SESSION['admin']) && ($_SESSION['admin'] != 0))
        {
        ?>
            <li>
                <!--
<h2>Send Message</h2>
<p>
<form action="sendmsg.php" method="post" id="frmSendMessage">
<table>
<tr>
<td align="left" valign="top">Msg:</td>
<td align="left" valign="top"><textarea id="fldMessage" name="fldMessage" cols="25" rows="5" style="resize: none"></textarea></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
<td align="left" valign="top"><input name="btnSend" type="submit" value="Send" /></td>
</tr>
</table>
<input id="fldCurrScript" name="fldCurrScript" type="hidden" value="<?php echo SharedGetParentScriptName(); ?>" />
</form>
<img id="fldGoogleMap" src="images/nomap.png" width="280" height="280" />
</p>
<p>
<table>
<?php
            // Order by m1.datecreated and NOT datecreated which is the generated date without seconds...
            $dbselect = "select " .
                "m1.message," .
                "DATE_FORMAT(m1.datecreated,\"%d/%m/%Y %h:%i%p\") datecreated " .
                "from " .
                "messages m1 " .
                "where " .
                "users_id=" . $_SESSION['loggedin'] . " " .
                "order by " .
                "m1.datecreated desc " .
                "limit 0, 5";
            if ($dbresult = mysql_query($dbselect, $dblink))
            {
                if ($numrows = mysql_num_rows($dbresult))
                {
                    while ($dbrow = mysql_fetch_array($dbresult, MYSQL_ASSOC))
                    {
                        $msg = $dbrow['message'];
                        $dt = $dbrow['datecreated'];
                        // Sanity checks...
?>
<tr>
<td align="left" valign="top"><?php echo $dt; ?></td>
<td align="left" valign="top"><span class="hotspot" onmouseover="tooltip.show('<?php echo $msg; ?>');" onmouseout="tooltip.hide();"><?php echo SharedAddEllipsis(addslashes(htmlspecialchars($msg))); ?></span></td>
</tr>
<?php
                    }
                }
            }
?>
</table>
</p>
-->
            </li>
            <?php
        }
        else
        {
        ?>
                <li>
                    <div id="DIV_FBContainer">
                        <div id="DIV_FeaturesBanner">
                            <strong>Click here to sign up today for your <font color="red">FREE</font> 30 Day trial</strong>
                        </div>
                        <!--                        <div id="FBcenter">-->
                        <div id="DIV_featuresContainer">
                            <div>
                                <h2>Features</h2>
                            </div>
                            <ul>
                                <li><a href="#">iPhone&reg; / iPad&reg; App</a></li>
                                <li><a href="#">Easy to setup and use</a></li>
                                <li><a href="#">Auto populated fields</a></li>
                                <li><a href="#">Barcode & QR scanning options</a></li>
                                <li><a href="#">Camera capabilities</a></li>
                                <li><a href="#">Automatic reporting</a></li>
                                <li><a href="#">Location maps</a></li>
                                <li><a href="#">Job tracking</a></li>
                            </ul>
                        </div>
                        <div id="DIV_benefitsContainer">
                            <div>
                                <h2>Features</h2>
                            </div>
                            <ul>
                                <li><a href="#">Real-time data capture</a></li>
                                <li><a href="#">Job register</a></li>
                                <li><a href="#">Centralised reporting</a></li>
                                <li><a href="#">Automatic reminders</a></li>
                                <li><a href="#">Accurate data</a></li>
                                <li><a href="#">Quotes automatically timestamped</a></li>
                                <li><a href="#">Quotes are location aware</a></li>
                            </ul>
                        </div>
                        <!--                        </div>-->
                    </div>
                    <!--
<h2>Welcome</h2>
<p><a href="login.php">Sign up</a> today and choose from our flexible payment options!</p>
</li>
<li>
<h2>Features</h2>
<ul>
<li><a href="#">iPhone&reg; / iPad&reg; App</a></li>
<li><a href="#">Easy to setup and use</a></li>
<li><a href="#">Auto populated fields</a></li>
<li><a href="#">Barcode & QR scanning options</a></li>
<li><a href="#">Camera capabilities</a></li>
<li><a href="#">Automatic reporting</a></li>
<li><a href="#">Location maps</a></li>
<li><a href="#">Job tracking</a></li>
</ul>
</li>
<li>
<h2>Benefits</h2>
<ul>
<li><a href="#">Real-time data capture</a></li>
<li><a href="#">Job register</a></li>
<li><a href="#">Centralised reporting</a></li>
<li><a href="#">Automatic reminders</a></li>
<li><a href="#">Accurate data</a></li>
<li><a href="#">Quotes automatically timestamped</a></li>
<li><a href="#">Quotes are location aware</a></li>
</ul>
-->
                </li>
                <?php
        }
        ?>
    </ul>
</div>
