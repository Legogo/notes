<?php
  $name = $_POST["name"];
  $data = stripslashes($_POST["data"]);

  $path = "files/".$name;
  if($name == "readme") $path = $name;
  $path .= ".txt";

  if(strlen($data) <= 0){
    if(file_exists($path))  unlink($path);
    echo "deleted";
  }else{
   file_put_contents($path, $data);
   echo $data; 
  }
?>