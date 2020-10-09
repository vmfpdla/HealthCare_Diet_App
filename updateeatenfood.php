<?php
$require_once('./dbconn.php');
$user_id=1
$eaten_id =5;
$food_id=1;
$eaten_time=2;
$eaten_serving=1;
$eaten_day = date("Y-m-d",time());


$sql = "INSERT INTO eatenfood (eaten_id, user_id, food_id, eaten_day, eaten_time, eaten_serving) VALUES ($eaten_id,$user_id,$food_id,$eaten_day,$eaten_time,$eaten_serving)";


$conn=mysqli_query($sql);

$conn->close();

header("Location: ./index.php");

?>

