 <html>
    <head>
    <title>CK Editor </title>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <form action="" method="post">
            <textarea class="ckeditor" name="editor">
            <?php
                //echo file_get_contents("default.html");
                if (file_exists("50.html") == true)
                {
                    echo file_get_contents("50.html");
                }
                else
                {
                    echo file_get_contents("default.html");
                }
            ?>
            </textarea>
            <input type="submit" value="save">
        </form>
    <body>
</html>

<?php
    if(isset($_POST[editor]))
    {
        $text = $_POST['editor'];
        //echo "$text";
        $myfile = fopen("50.html", "w") or die("Unable to open file!");
        fwrite($myfile, $text);
        // $txt = "Jane Doe\n";
        // fwrite($myfile, $txt);
        fclose($myfile);
    }

?>
