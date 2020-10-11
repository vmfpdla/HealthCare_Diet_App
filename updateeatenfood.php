<?php
require_once('./dbconn.php');
$gfood_id=$_POST['food_id'];
$geaten_time=$_POST['eaten_time'];

$user_id=1
$eaten_id =5;
$food_id=1;
$eaten_time=2;
$eaten_serving=1;
$eaten_day = date("Y-m-d",time());
if ( ! $conn ) {
	die( 'Could not connect: ' . mysqli_error($con) );
} else {
	echo 'Connection established';

	$sql = "INSERT INTO eatenfood ( user_id, food_id, eaten_day, eaten_time, eaten_serving) VALUES ( '$user_id', '$food_id','$eaten_day', '$eaten_time', '$eaten_serving')";

	mysqli_query($conn,$sql);
	echo $gfood_id . $geaten_time;
	$conn->close();

#	header("Location: ./index.php");
}

#$sql = "INSERT INTO eatenfood (eaten_id, user_id, food_id, eaten_day, eaten_time, eaten_serving) VALUES ($eaten_id,$user_id,$food_id,$eaten_day,$eaten_time,$eaten_serving)";



?>

