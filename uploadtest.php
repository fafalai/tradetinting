<?php

error_log("***** POST vars");
foreach ($_POST as $key => $value)
{
  if (is_array($value))
  {
    $a = implode("|", $value);
    error_log($key . " => " . $a);
  }
  else
    error_log($key . " => " . $value);
}

error_log("***** FILES vars");
foreach ($_FILES as $key => $value)
{
  if (is_array($value))
  {
    error_log("key: $key");
    foreach ($value as $k => $v)
    {
      error_log($k . " => " . $v);
    }
    //$a = implode("|", $value);
    //error_log($key . " => " . $a);
    
  }
  else
    error_log($key . " => " . $value);
}

//$file = $_FILES["image"];
//error_log("Image: " . $file["name"]);

header("Content-Type: application/json");
//echo json_encode(["jobid" => $data.jobid, "filename" => $file["name"]]);
echo json_encode(["errcode" => 0]);

/*
if (move_uploaded_file($file["tmp_name"], "photos/" . $file["name"]))
{
  header("Content-Type: application/json");
  echo json_encode(["html" => "File Upload successfull."]);

  $filename = $file["name"];
}
else
{
  header("Content-Type: application/json");
  echo json_encode(["html" => "Unable to move image. May be permission error?"]);
}
*/
?>
