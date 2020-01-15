<!-- this table does not need the 'Code' column, and the 'Code' input. so remove them on the page. when insert/update the table, use the fldName for the code field as well -->
<!-- 
     1 ===  Successfull
     2 ===  Fail 
    
-->
<?php
    include("logincheck.php");
    // include("meta.php");
    if (!isset($_SERVER['HTTPS']))
    {
        //header('location: https://www.adtalk.services/testtag/clients.php');
        //exit;
    }
    $dblink = SharedConnect();
    $clientmsg = "";
    $cmd = AT_CMDCREATE;
    $clientid = 0;
    $notification = 0;
    //
    $fldcode = "";
    $fldname = "";
    $flddesc = "";
    $fldcontact = "";
    $fldemail1 = "";
    $fldmobile = "";
    $fldaddress = "";
    $fldcity = "";
    $fldstate = "";
    $fldpostcode = "";
    $fldcountry = "";
    $fldgpslat = "";
    $fldgpslong = "";
    //
    if (isset($_GET['cmd']))
    {
        
        $cmd = intval(SharedCleanString($_GET['cmd'], AT_MAXBIGINT));
        error_log($cmd);
        $clientid = intval(SharedCleanString(isset($_GET['id']) ? $_GET['id'] : 0, AT_MAXBIGINT));
        if ($cmd == AT_CMDMODIFY)
        {
            // Double check dateexpired is null and this belongs to this customer...
            $dbselect = "select " .
                "cl1.code," .
                "cl1.name," .
                "cl1.notes as 'desc'," .
                "cl1.contact," .
                "cl1.email1," .
                "cl1.mobile," .
                "cl1.address," .
                "cl1.city," .
                "cl1.state," .
                "cl1.postcode, " .
                "cl1.country " .
                "from " .
                "clients cl1 " .
                "where " .
                "cl1.id=" . $clientid . " " .
                "and " .
                "cl1.cust_id=" . $_SESSION['custid'] . " " .
                "and " .
                "cl1.dateexpired is null";
            error_log("Modify");
            error_log($dbselect);
            if ($dbresult = SharedQuery($dbselect, $dblink))
            {
                if ($numrows = SharedNumRows($dbresult))
                {
                    $url = "";
                    while ($dbrow = SharedFetchArray($dbresult))
                    {
                        $fldcode = $dbrow['code'];
                        $fldname = $dbrow['name'];
                        $flddesc = $dbrow['desc'];
                        $fldcontact = $dbrow['contact'];
                        $fldemail1 = $dbrow['email1'];
                        $fldmobile = $dbrow['mobile'];
                        $fldaddress = $dbrow['address'];
                        $fldcity = $dbrow['city'];
                        $fldstate = $dbrow['state'];
                        $fldpostcode = $dbrow['postcode'];
                        $fldcountry = $dbrow['country'];
                    }
                }
            }
        }
        else if ($cmd == AT_CMDDELETE)
        {
            
            $dbupdate = "update " .
                "clients " .
                "set " .
                "dateexpired=CURRENT_TIMESTAMP," .
                "usersexpired_id=" . $_SESSION['loggedin'] . " " .
                "where " .
                "id=" . $clientid . " " .
                "and " .
                "cust_id=" . $_SESSION['custid'];
            if (SharedQuery($dbupdate, $dblink))
            {
                $notification = 1;
                $clientmsg = "Client " . $fldname . " has been deleted."; 
            }
            else
            {
                $notification = 2;
                $clientmsg = "Unable to delete " . $fldname . ". Please try again or contact support.";
            }
                
            //
            $cmd = AT_CMDCREATE;
            $clientid = 0;
        }
        else
            $clientid = 0;
    }
    else if (isset($_POST['fldName']))
    {
        error_log("fldName ".$_POST['fldName']);
        // Hidden field - are we creating or modifying?
        $clientid = strtoupper(SharedCleanString($_POST['fldClientId'], AT_MAXBIGINT));
        error_log("the client id is");
        error_log($clientid);
        // $fldcode = strtoupper(SharedCleanString($_POST['fldCode'], AT_MAXCODE));
        $fldname = SharedCleanString($_POST['fldName'], AT_MAXNAME);
        $flddesc = SharedCleanString($_POST['fldDesc'], AT_MAXNOTE);
        $fldcontact = SharedCleanString($_POST['fldContact'], AT_MAXNAME);
        $fldemail1 = SharedCleanString($_POST['fldEmail1'], AT_MAXEMAIL);
        $fldmobile = SharedCleanString($_POST['fldMobile'], AT_MAXPHONE);
        //$fldmobile = SharedNormaliseMobile(SharedCleanString($_POST['fldMobile'], AT_MAXPHONE));
        $fldaddress = SharedCleanString($_POST['fldAddress'], AT_MAXADDRESS);
        $fldcity = SharedCleanString($_POST['fldCity'], AT_MAXADDRESS);
        $fldstate = strtoupper(SharedCleanString($_POST['fldState'], AT_MAXSTATE));
        $fldpostcode = SharedCleanString($_POST['fldPostcode'], AT_MAXPOSTCODE);
        $fldcountry = SharedCleanString($_POST['fldCountry'], 50);
        $fldgpslat = $_POST['fldGpsLat'];
        $fldgpslong = $_POST['fldGpsLong'];
        //
        if ($clientid == 0)
        {
            error_log("client id is 0");
            $dbinsert = "insert into " .
                "clients " .
                "(" .
                "cust_id," .
                "clients.code," .
                "clients.name," .
                "clients.notes," .
                "contact," .
                "email1," .
                "mobile," .
                "address," .
                "city," .
                "state," .
                "postcode," .
                "country," .
                "userscreated_id" .
                ") " .
                "values " .
                "(" .
                $_SESSION['custid'] . "," .
                SharedNullOrQuoted($fldname,50, $dblink) . "," .
                SharedNullOrQuoted($fldname,50,  $dblink) . "," .
                SharedNullOrQuoted($flddesc,1000,  $dblink) . "," .
                SharedNullOrQuoted($fldcontact, 50, $dblink) . "," .
                SharedNullOrQuoted($fldemail1,50,  $dblink) . "," .
                SharedNullOrQuoted($fldmobile,50,  $dblink) . "," .
                SharedNullOrQuoted($fldaddress,50,  $dblink) . "," .
                SharedNullOrQuoted($fldcity,50,  $dblink) . "," .
                SharedNullOrQuoted($fldstate,50,  $dblink) . "," .
                SharedNullOrQuoted($fldpostcode, 50, $dblink) . "," .
                SharedNullOrQuoted($fldcountry, 50, $dblink) . "," .
                $_SESSION['loggedin'] .
                ")";
            error_log("This is for insert");
            error_log($dbinsert);
            if (SharedQuery($dbinsert, $dblink))
            {
                $clientid = SharedGetInsertId($dblink);
                //new client, new job. for create job detail 
                error_log($fldgpslat);
                error_log($fldgpslat);
                $dbinsert = "insert into " .
                "jobs " .
                "(cust_id,clients_id,jobname,contact,address,city,state,postcode,mobile,gpslat,gpslon,totalprice,discount,tax,userscreated_id) " .
                "values " .
                "(" .
                $_SESSION['custid'] . "," .
                $clientid . "," .
                SharedNullOrQuoted($fldname,50, $dblink) . "," .
                SharedNullOrQuoted($fldcontact,50, $dblink) . "," .
                SharedNullOrQuoted($fldaddress,50,  $dblink) . "," .
                SharedNullOrQuoted($fldcity,50,  $dblink) . "," .
                SharedNullOrQuoted($fldstate,50,  $dblink) . "," .
                SharedNullOrQuoted($fldpostcode, 50, $dblink) . "," .
                SharedNullOrQuoted($fldmobile,50,  $dblink) . "," .
                $fldgpslat . ",".
                $fldgpslat . ",".
                "0," .
                "0," .
                "0," .
                $_SESSION['loggedin'] .
                ")";
                error_log("inserting to jobs table");
                error_log($dbinsert);
                if (SharedQuery($dbinsert, $dblink))
                {
                    $jobid = SharedGetInsertId($dblink);
                    error_log($jobid);
                    $notification = 1;
                
                    // Successful save, clear form...
                    $fldcode = "";
                    $fldname = "";
                    $flddesc = "";
                    $fldcontact = "";
                    $fldemail1 = "";
                    $fldmobile = "";
                    $fldaddress = "";
                    $fldcity = "";
                    $fldstate = "";
                    $fldpostcode = "";
                    $fldcountry = "";
                    $clientid = 0;
                    $clientmsg = "Client " . $fldname . " has been added.";
                }
            
            }
            else
            {
                $notification = 2;
                $clientmsg = "Unable to add " . $fldcode . ". Please try again or contact support.";
            }
                
                //alert("Unable to add " . $fldname . ". Please try again or contact support.");
        }
        else
        {
            error_log("client id is ".$clientid);
            unset($_POST);
            $notification = 2;
            $clientmsg = "Could not edit user on the portal, please edit on the portal. Please wait for the next update.";
            $clientid = 0;
            $cmd = AT_CMDCREATE;
            $fldcode = "";
            $fldname = "";
            $flddesc = "";
            $fldcontact = "";
            $fldemail1 = "";
            $fldmobile = "";
            $fldaddress = "";
            $fldcity = "";
            $fldstate = "";
            $fldpostcode = "";
            $fldcountry = "";
            $fldgpslat = "";
            $fldgpslong = "";
            // $dbupdate = "update " .
            //     "clients " .
            //     "set " .
            //     "clients.code=" . SharedNullOrQuoted($fldname,50,  $dblink) . "," .
            //     "clients.name=" . SharedNullOrQuoted($fldname,50,  $dblink) . "," .
            //     "clients.notes=" . SharedNullOrQuoted($flddesc, 1000, $dblink) . "," .
            //     "contact=" .SharedNullOrQuoted($fldcontact, 50, $dblink) . "," .
            //     "email1=" .SharedNullOrQuoted($fldemail1, 50, $dblink) . "," .
            //     "mobile=" . SharedNullOrQuoted($fldmobile, 50, $dblink) . "," .
            //     "address=" . SharedNullOrQuoted($fldaddress, 50, $dblink) . "," .
            //     "city=" . SharedNullOrQuoted($fldcity, 50, $dblink) . "," .
            //     "state=" . SharedNullOrQuoted($fldstate, 50, $dblink) . "," .
            //     "postcode=" . SharedNullOrQuoted($fldpostcode,50,  $dblink) . "," .
            //     "country=" . SharedNullOrQuoted($fldcountry,50,  $dblink) . "," .
            //     "datemodified=CURRENT_TIMESTAMP," .
            //     "usersmodified_id=" . $_SESSION['loggedin'] . " " .
            //     "where " .
            //     "id=" . $clientid . " " .
            //     "and " .
            //     "cust_id=" . $_SESSION['custid'];
            // error_log("This is for update");
            // error_log($dbupdate);
            // if (SharedQuery($dbupdate, $dblink))
            // {

            //     $dbjobupdate = "update ".
            //                     "jobs ".
            //                     "set ".
            //                     "jobname =". SharedNullOrQuoted($fldname,50,  $dblink) . "," .
            //                     "datemodified=CURRENT_TIMESTAMP," .
            //                     "usersmodified_id=" . $_SESSION['loggedin'] . " " .
            //                     "where " .
            //                     "clients_id=". $clientid . " " .
            //                     "and " .
            //                     "cust_id=" . $_SESSION['custid'];
            //     error_log("This is for job update");
            //     error_log($dbjobupdate);
                
            //     if(SharedQuery($dbjobupdate,$dblink))
            //     {
            //         $notification = 1;
            //         $fldcode = "";
            //         $fldname = "";
            //         $flddesc = "";
            //         $fldcontact = "";
            //         $fldemail1 = "";
            //         $fldmobile = "";
            //         $fldaddress = "";
            //         $fldcity = "";
            //         $fldstate = "";
            //         $fldpostcode = "";
            //         $fldcountry = "";
            //         $clientid = 0;
            //         $clientmsg = "Client " . $fldname . " has been updated.";
            //     }
            //     else
            //     {
            //         $notification = 2;
            //         $clientmsg = "Unable to save " . $fldname . ". Please try again or contact support.";
            //     }
            // }
            // else
            // {            
            //     $notification = 2;
            //     $clientmsg = "Unable to save " . $fldname . ". Please try again or contact support.";
            // }
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php
        include("meta.php");
    ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqCHDj475c_6YSc9yqwBH3eN1bYovqtUE&libraries=places&callback=initAutocomplete"
            async defer>
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                var message = "";
                var notification = "";
                message = "<?php if ($clientmsg != "
                ") echo $clientmsg; else echo 123;?>";
                notification = "<?php if ($notification != "
                ") echo $notification; else echo 123;?>";
                // console.log(message);
                // console.log(notification);
                if (notification == 1) {
                    resetForm();
                    // console.log(document.g)
                    //document.getElementById('savingPDFAlert').style.display = 'block';
                    noty({
                        text: message,
                        type: 'success',
                        timeout: 3000
                    });
                } else if (notification == 2) {
                    //resetForm();
                    noty({
                        text: message,
                        type: 'warnning',
                        timeout: 3000
                    });
                }

                message = "";
                notification = "";
                // getGeoLocation();
                // resetForm()
            });

            function resetForm()
            {
                console.log(document.getElementById('fldName').value);
                document.getElementById('frmClients').reset();
                document.getElementById('fldName').value = "";
                console.log(document.getElementById('fldName').value);
                document.getElementById('fldDesc').value = "";
                document.getElementById('fldAddress').value = "";
                document.getElementById('fldCity').value = "";
                document.getElementById('fldState').value = "";
                document.getElementById('fldCountry').value = "";
                document.getElementById('fldPostcode').value = "";
                document.getElementById('fldEmail1').value = "";
                document.getElementById('fldContact').value = "";
                document.getElementById('fldMobile').value = "";
                document.getElementById('fldClientId').value = "";

            }

            function initAutocomplete() {
                // Create the autocomplete object, restricting the search to geographical
                // location types.
                console.log(document.getElementById('fldName').value);
                console.log("I am in");
                autocomplete = new google.maps.places.Autocomplete( /** @type {!HTMLInputElement} */ (document.getElementById(
                    'fldAddress')), {
                    types: ['geocode']
                });

                // When the user selects an address from the dropdown, populate the address
                // fields in the form.
                google.maps.event.addListener(
                    autocomplete,
                    'place_changed',
                    function () {
                        var place = autocomplete.getPlace();

                        if (!_.isUndefined(place.address_components)) {
                            if (place.address_components.length == 8) {
                                //console.log("length 8");
                                //console.log(place.address_components);
                                //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                                document.getElementById('fldAddress').value = place.name
                                //$('#fldCity').textbox('setValue', place.address_components[3].short_name);
                                document.getElementById('fldCity').value = place.address_components[3].short_name;
                                //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[7].short_name);
                                document.getElementById('fldState').value = place.address_components[5].short_name;
                                // $('#fldState').combobox('setValue', place.address_components[5].short_name);
                                document.getElementById('fldCountry').value = place.address_components[6].long_name;
                                document.getElementById('fldPostcode').value = place.address_components[7].short_name;
                            } else if (place.address_components.length == 9) {
                                //console.log("length 9");
                                //console.log(place.address_components);
                                //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                                document.getElementById('fldAddress').value = place.name
                                //$('#fldCity').textbox('setValue', place.address_components[3].short_name);
                                document.getElementById('fldCity').value = place.address_components[3].short_name;
                                //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[7].short_name);
                                document.getElementById('fldState').value = place.address_components[5].short_name;
                                // $('#fldState').combobox('setValue', place.address_components[5].short_name);
                                document.getElementById('fldCountry').value = place.address_components[6].long_name;
                                document.getElementById('fldPostcode').value = place.address_components[7].short_name;
                            } else {
                                //console.log("other");
                                //console.log(place.address_components);
                                //$('#fldNewBookingCustAddress1').textbox('setValue', place.name);
                                document.getElementById('fldAddress').value = place.name;
                                //$('#fldNewBookingCustCity').textbox('setValue', place.address_components[2].short_name);
                                document.getElementById('fldCity').value = place.address_components[2].short_name;
                                //$('#fldNewBookingCustPostcode').textbox('setValue', place.address_components[6].short_name);
                                document.getElementById('fldState').value = place.address_components[4].short_name;
                                document.getElementById('fldCountry').value = place.address_components[5].long_name;
                                document.getElementById('fldPostcode').value = place.address_components[6].short_name;
                            }
                        }
                    }
                );
            }

            // Bias the autocomplete object to the user's geographical location,
            // as supplied by the browser's 'navigator.geolocation' object.
            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                        $gpslat = position.coords.latitude;
                        $gpslong = position.coords.longitude
                        console.log($gpslat);
                        console.log($gpslong);
                        document.getElementById('fldGpsLat').value = $gpslat;
                        document.getElementById('fldGpsLong').value = $gpslong;
                    });
                }
            }

            function getGeoLocation()
            {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        $gpslat = position.coords.latitude;
                        $gpslong = position.coords.longitude
                        console.log($gpslat);
                        console.log($gpslong);
                        document.getElementById('fldGpsLat').value = $gpslat;
                        document.getElementById('fldGpsLong').value = $gpslong;

                    });
                }
            }

            function OnFormLoad() {
                $('#fldCode').focus();

                <?php
                    if ($cmd == AT_CMDMODIFY)
                    {
                ?>
                    ShowMap();
                    console.log("I am here2");
                <?php
                    }
                ?>
            }

            function ShowMap() {
                var address = $('#fldAddress').val() + ',' + $('#fldCity').val() + ',' + $('#fldState').val();
                var encodedaddress = encodeURI(address);
                var googlemapurl = 'http://maps.googleapis.com/maps/api/staticmap?center=' + encodedaddress +
                    '&zoom=13&size=280x280&maptype=roadmap&sensor=false&markers=color:red%7Clabel:S%7C' +
                    encodedaddress + '&apikey=<?php echo AT_GOOGLESTATICMAP_APIKEY; ?>';
                $('#fldGoogleMap').attr('src', googlemapurl);
            }
            onload = OnFormLoad;


            function searchClients() {
                var input, filter, table, tr, td, i, searchIndex;
                input = document.getElementById("searchInputClients");
                filter = input.value.toUpperCase();
                // console.log(filter);
                table = document.getElementById("tblClients");
                tr = table.getElementsByTagName("tr");
                searchIndex = 0;
                if (document.getElementById("searchMobile").checked) {
                    searchIndex = 1;
                } else if (document.getElementById("searchName").checked) {
                    searchIndex = 0;
                }
                // console.log(searchIndex);
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[searchIndex];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
        <title>Remedy Tinting - Clients</title>
</head>

<body>
    <?php
        include("top.php");
    ?>
        <div>
            <div id="savingPDFAlert" class="myAlert-top alert alert-info collapse">
                <strong>Saving PDF. Please don't close this page. It will take a while</strong>
            </div>
            <div class="existingClientsDIV">
                <div class="container">
                    <label><?php echo date("l, F j, Y"); ?></label>
                    <h2 class="clientTitle">Clients</h2>
                    <label>Move mouse over links for tips. Click on table header to sort by that column.</label>
                    <br/>
                    <strong>Note:You could create a new user on the portal.However, you could only edit or delete the user on the app.</strong>
                    <br/>
                    <strong>More functions will come in the future</strong>
                </div>
                <div id="DIV_SearchClients" class="container">
                    <input type="text" id="searchInputClients" onkeyup="searchClients()" placeholder="Search by name or phone" title="Type in a name or phone"
                        class="form-control col-xl-4">
                </div>
                <div class="container mb-4">
                    <input class="radio mb-2" type="radio" name="search" value="Name" id="searchName" checked> Name
                    <br>
                    <input class="radio" type="radio" name="search" value="Mobile" id="searchMobile"> Phone
                    <br>
                </div>
                <div class="container">
                    <table id="tblClients" rules="cols" frame="box" class="table table-bordered sortable" style="width:100%">
                        <tr>
                            <th style="width:30%">Name</th>
                            <th style="width:30%">Phone</th>
                            <th style="width:30%">Date Modified</th>
                            <!-- <th class="unsortable" style="width:10%" style="display:none;">Action</th> -->
                        </tr>
                        <?php
                            $dbselect = "select " .
                                "cl1.id," .
                                "cl1.code," .
                                "cl1.name," .
                                "cl1.notes as 'desc'," .
                                "cl1.contact," .
                                "cl1.mobile," .
                                "cl1.address," .
                                "cl1.city," .
                                "cl1.state," .
                                "DATE_FORMAT(cl1.datecreated,\"%d-%m-%Y %H:%i\") datecreated," .
                                "DATE_FORMAT(cl1.datemodified,\"%d-%m-%Y %H:%i\") datemodified," .
                                "cl1.gpslat," .
                                "cl1.gpslon " .
                                "from " .
                                "clients cl1 " .
                                "where " .
                                "cl1.cust_id=" . $_SESSION['custid'] . " " .
                                "and " .
                                "cl1.dateexpired is null ".
                                // "and " .
                                // $where . " " .
                                "order by " .
                                "cl1.datecreated desc, ".
                                "cl1.datemodified desc ";
                            error_log($dbselect);
                            if ($dbresult = SharedQuery($dbselect, $dblink))
                            {
                                if ($numrows = SharedNumRows($dbresult))
                                {
                                    $url = "";
                                    while ($dbrow = SharedFetchArray($dbresult))
                                    {
                                        $deletetip = "Delete Client: <strong>" . $dbrow['name'] . "</strong>";
                                        $contacttip = "<strong>Name: </strong>" . $dbrow['name'] . "<br />" .
                                                    "<strong>Phone: </strong>" . $dbrow['mobile'] . "<br />" .
                                                    "<strong>Address: </strong>" . $dbrow['address'] . "<br />" .
                                                    "<strong>City: </strong>" . $dbrow['city'] . ", " . $dbrow['state'] . "<br />";
                                            //$dbrow['desc'];
                                        $deletetip = SharedPrepareToolTip($deletetip);
                                        $contacttip = SharedPrepareToolTip($contacttip);
                        ?>
                        <tr>
                            <td align="left">
                                <span class="hotspot" onmouseover="tooltip.show('<?php echo $contacttip; ?>');" onmouseout="tooltip.hide();">
                                    <a href="clients.php?cmd=<?php echo AT_CMDMODIFY; ?>&id=<?php echo $dbrow['id']; ?>">
                                        <?php echo SharedAddEllipsis($dbrow['name'], 20); ?>
                                    </a>
                                </span>
                            </td>
                            <td align="left">
                                <?php echo SharedAddEllipsis($dbrow['mobile'], 20); ?>
                            </td>
                            <td align="right">
                                <?php if ($dbrow['datemodified'] == "") echo $dbrow['datecreated']; else echo $dbrow['datemodified']; ?>
                            </td>
                            <td align="center" style="display:none;">
                                <a href="clients.php?cmd=<?php echo AT_CMDDELETE; ?>&id=<?php echo $dbrow['id']; ?>">
                                    <span onmouseover="tooltip.show('<?php echo $deletetip; ?>');" onmouseout="tooltip.hide();">
                                        <img src="images/icon-delete.png" width="25" height="17" alt="Delete" />
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <?php
                                    }
                                }
                            }
                        ?>
                    </table> 
                </div>
            </div>
            <div class="container" style="width:70%">
                <div class="clientsIDV">
                    <h2 class="clientTitle" style="margin-bottom:10px">Add/Modify Clients</h2>
                    <a href="clients.php?cmd=<?php echo AT_CMDCREATE; ?>&id=0" class="btn btn-primary">Create New</a>
                    <div class="clientsEntry">
                        <form name="frmClients" action="clients.php" method="post" id="frmClients">
                            <table style="width:100%">
                                <tr>
                                    <td align="left" valign="top" colspan="4">
                                        <input style="width: 100%" id="fldName" name="fldName" type="text" placeholder="NAME" size="20" maxlength="<?php echo AT_MAXNAME; ?>"
                                            value="<?php echo SharedPrepareDisplayString($fldname); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td align="left" valign="top">Desc:</td> -->
                                    <td align="left" valign="top" colspan="4">
                                        <input style="width: 100%" style="width: 100%" id="fldDesc" name="fldDesc" type="text" placeholder="NOTES" size="40" maxlength="<?php echo AT_MAXNOTE; ?>"
                                            value="<?php echo SharedPrepareDisplayString($flddesc); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td align="left" valign="top">Address:</td> -->
                                    <td align="left" valign="top" colspan="4">
                                        <input style="width: 100%" style="width: 100%" id="fldAddress" name="fldAddress" type="text" placeholder="ADDRESS" size="40"
                                            maxlength="<?php echo AT_MAXADDRESS; ?>" value="<?php echo SharedPrepareDisplayString($fldaddress); ?>"
                                            onchange="ShowMap();" onFocus="geolocate()" />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td align="left" valign="top">City:</td> -->
                                    <td align="left" valign="top" style="width: 25%" colspan="1">
                                        <input style="width: 100%" id="fldCity" name="fldCity" type="text" placeholder="CITY" size="40" maxlength="<?php echo AT_MAXADDRESS; ?>"
                                            value="<?php echo SharedPrepareDisplayString($fldcity); ?>" onchange="ShowMap();"
                                        />
                                    </td>
                                    <td align="left" valign="top" colspan="1" style="width: 25%">
                                        <input style="width: 100%" id="fldState" name="fldState" type="text" placeholder="STATE" size="40" value="<?php echo SharedPrepareDisplayString($fldstate); ?>"
                                            onchange="ShowMap();" />
                                        <!-- <select style="width: 100%;margin-top: 8px" id="fldState" name="fldState" onchange="ShowMap();">
                                            <option value="VIC" <?php if ($fldstate == "VIC" or $fldstate == "") echo "selected=\"selected\""; ?>>VIC</option>
                                            <option value="NSW" <?php if ($fldstate == "NSW") echo "selected=\"selected\""; ?>>NSW</option>
                                            <option value="SA" <?php if ($fldstate == "SA") echo "selected=\"selected\""; ?>>SA</option>
                                            <option value="WA" <?php if ($fldstate == "WA") echo "selected=\"selected\""; ?>>WA</option>
                                            <option value="QLD" <?php if ($fldstate == "QLD") echo "selected=\"selected\""; ?>>QLD</option>
                                            <option value="TAS" <?php if ($fldstate == "TAS") echo "selected=\"selected\""; ?>>TAS</option>
                                            <option value="ACT" <?php if ($fldstate == "ACT") echo "selected=\"selected\""; ?>>ACT</option>
                                            <option value="NT" <?php if ($fldstate == "NT") echo "selected=\"selected\""; ?>>NT</option>
                                        </select> -->
                                    </td>
                                    <td align="left" valign="top" colspan="1" style="width:25%">
                                        <input style="width: 100%" id="fldPostcode" name="fldPostcode" type="text" placeholder="POSTCODE" size="8" maxlength="4"
                                            class="required" value="<?php echo SharedPrepareDisplayString($fldpostcode); ?>"
                                        />
                                        <div id="frmClients_fldPostcode_errorloc" class="error_strings"></div>
                                    </td>
                                    <td align="left" valign="top" style="width: 50%" colspan="1">
                                        <input style="width: 100%" id="fldCountry" name="fldCountry" type="text" placeholder="COUNTRY" size="40" value="<?php echo SharedPrepareDisplayString($fldcountry); ?>"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td align="left" valign="top">Contact:</td> -->
                                    <td align="left" valign="top" colspan="2" style="width: 50%">
                                        <input style="width: 100%" style="width: 100%" id="fldContact" name="fldContact" type="text" placeholder="CONTACT" size="20"
                                            maxlength="<?php echo AT_MAXNAME; ?>" value="<?php echo SharedPrepareDisplayString($fldcontact); ?>"
                                        />
                                    </td>
                                    <td align="left" valign="top" colspan="2" style="width: 50%">
                                        <input style="width: 100%" id="fldEmail1" name="fldEmail1" type="text" size="20" placeholder="EMAIL,REQUIRED" maxlength="<?php echo AT_MAXEMAIL; ?>"
                                            value="<?php echo SharedPrepareDisplayString($fldemail1); ?>" required pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                                            title="Invalid Email address" />
                                        <div id="frmClients_fldEmail1_errorloc" class="error_strings"></div>
                                    </td>
                                </tr>

                                <tr>
                                    <!-- <td align="left" valign="top">Mobile:</td> -->
                                    <td align="left" valign="top" colspan="2" style="width: 50%">
                                        <input style="width: 100%" id="fldMobile" name="fldMobile" type="text" placeholder="Phone (Must be at least 5 digits)" size="20"
                                            maxlength="<?php echo AT_MAXPHONE; ?>" value="<?php echo SharedPrepareDisplayString($fldmobile); ?>"
                                            required pattern="^[0-9]{5,}$" title="Invalid Phone number" />
                                        <div id="frmClients_fldMobile_errorloc" class="error_strings"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td align="left" valign="top">Contact:</td> -->
                                    <td align="left" valign="top" colspan="2" style="width: 50%">
                                        <input type="hidden" style="width: 0%" id="fldGpsLat" name="fldGpsLat" type="text" placeholder="CONTACT" size="20"/>
                                    </td>
                                    <td align="left" valign="top" colspan="2" style="width: 50%">
                                        <input type="hidden" style="width: 0%" id="fldGpsLong" name="fldGpsLong" type="text" placeholder="CONTACT" size="20"/>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td align="left" valign="top">&nbsp;</td> -->
                                    <td align="left" valign="top">
                                        <input id="btnSave" type="submit" value="Save" style="width:50%" />
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" id="fldClientId" name="fldClientId" value="<?php echo SharedPrepareDisplayString($clientid); ?>" />
                        </form>
                    </div>
                </div>
            </div>
            <!--
                <script type="text/javascript">
                    var frmvalidator = new Validator("frmClients");
                    frmvalidator.EnableOnPageErrorDisplay();
                    frmvalidator.addValidation("fldCode", "req", "Please enter a unique client code");
                    //frmvalidator.addValidation("fldPostCode", "req", "Please enter your PostCode");
                    //frmvalidator.addValidation("fldPostCode", "regexp=^[0-9]{4}$", "Postcode must be 4 digits");
                    //frmvalidator.addValidation("fldMobile", "regexp=^[0-9]{10}$|^\(0[1-9]{1}\)[0-9]{8}$|^[0-9]{8}$|^[0-9]{4}[ ][0-9]{3}[ ][0-9]{3}$|^\(0[1-9]{1}\)[ ][0-9]{4}[ ][0-9]{4}$|^[0-9]{4}[ ][0-9]{4}$", "Must be in 04xxyyyzzz or xxxxyyyy format");
                    frmvalidator.addValidation("fldMobile", "regex=^(?=\d)\S{6,}", "Invalid Phone number"); //numbers only, at least six digits

                    frmvalidator.addValidation("fldEmail1", "email", "Invalid email address format");

                </script>
            -->
    <?php
        include("left.php");
    ?>

    <div style="clear: both;">&nbsp;</div>

    <?php
        include("bottom.php");
    ?>

</body>

</html>