<?php

  $host = 'localhost';
  $db_user = 'root';
  $db_pw = 'toor'; #toor
  $db_name = 'smartpt';
  $conn = new mysqli($host, $db_user, $db_pw, $db_name);

  if ($conn->connect_error) {
    printf("Connect failed: %s\n", $conn->connect_error);
  exit();
  }
  else{
    //echo $db_name;
  }
?>
