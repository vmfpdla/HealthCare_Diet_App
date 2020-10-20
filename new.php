<?php

require_once("./dbconn.php");

$user_id = 1; # 1번 가져왔다고 가정
$sql = "SELECT * FROM user WHERE user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) { // 여러줄 가져오는 경우

  while($row = $result->fetch_assoc()) {
    $user = $row;
  }
} else {
  echo "유저 접속 오류";
}


$today = date("Y-m-d");
  $kcal = 0; //칼로리
  $car =0; // 탄수화물
  $fat =0; // 지방
  $pro =0; // 단백질
  $sql2 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today'";
  $result2 = $conn->query($sql2);

  if ($result2 -> num_rows>0) { // 여러줄 가져오는 경우

  while($row = $result2->fetch_assoc()) {
    if($row['eaten_serving']==0){ # 0인분인경우
    $kcal = $kcal + $row['food_calory'];
    $car = $car + $row['food_car'];
    $fat = $fat + $row['food_fat'];
    $pro = $pro + $row['food_pro'];
    }


    echo $kcal;
    echo $car;
    echo $fat;
    echo $pro;
  #echo $row['exercise_name'] ." / " .$row['exercise_minute'] ."분 / ".$row['exhausted_calory']."Kcal";
  #echo nl2br("\n");
  }

  }
  else //echo "0 results";



?>
