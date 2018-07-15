
<head>
<script type="text/javascript">
    function redirect(address)
    {
    location.href = address;
    }
</script>
</head>
<body>
    <div class="introducingDIV col-12">
            <div class="sectionDIV col">
                <span style="font-size: 24pt;font-weight: bold;">
                            WELCOME  <?php echo $_SESSION['username'];?> ! 
                </span>
                <span style="font-size: 22pt;font-style: italic;">
                What would you like to do? 
                </span>
                <br/>
                <button  onclick="redirect('jobs.php')" class="sectionButton">VIEW / ADD JOBS</button>
                <button  onclick="redirect('clients.php')" class="sectionButton">VIEW / ADD CLIENTS</button>
                <button  onclick="redirect('resource.php')" class="sectionButton">VIEW RESOURCES</button>
                <button  onclick="redirect('contact.php')" class="sectionButton">CONTACT</button>
            </div>
    </div>
</body>
