<?php
  $name = $_POST["name"];
  
  $path = "files/".$name;
  if($name == "readme") $path = $name;
  $path .= ".txt";
  
  $data = file_get_contents($path);
  echo $data;
?>