<?php
require_once("./dbconn.php");


#여기는 모든 음식 정보 가져오는 거!
##$sql = "SELECT * FROM foodinfo WHERE food_id=".$food_id;

##$result1 = mysqli_query($conn,$sql);

##$row = mysqli_fetch_array($result1);


$user_id=1;
$food_id=$_POST["foodnum"];
$eaten_time=2;
$eaten_serving=$_POST["serving"];
$eaten_day = date('Y-m-d',time());
#if ( ! $conn ) {
#die( 'Could not connect: ' . mysqli_error($con) );
#} else {


print_r($_POST);
$sql2 = "INSERT INTO eatenfood ( user_id, food_id, eaten_day, eaten_time, eaten_serving) VALUES ( '$user_id', '$food_id','$eaten_day', '$eaten_time', '$eaten_serving')";

mysqli_query($conn,$sql2);
$conn->close();


header("Location: ./index.php");
?>
