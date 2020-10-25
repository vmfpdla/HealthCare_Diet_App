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

$sql1 = "SELECT * FROM diet";
$result1 = $conn->query($sql1);


$count=0;
if ($result1->num_rows > 0) { // 여러줄 가져오는 경우

  while($row = $result1->fetch_assoc()) {
  $diet_arry[$count]=[ 
      [
          $row['diet_id'],$row['diet_grains'],$row['diet_meat'],$row['diet_vet'],$row['diet_else'],$row['diet_calory'];
      ]
  ]
  $count+=1;
  echo $row['diet_id'] ." 번식단 밥종류:" .$row['diet_grains'] ." 고기종류: ".$row['diet_meat']."채소 종류 ".$row['diet_vet']."기타: ".$row['diet_else']."칼로리 :".$row['diet_calory'];
  echo nl2br("\n");
}
} else {
  echo "0 results";
}
?>
