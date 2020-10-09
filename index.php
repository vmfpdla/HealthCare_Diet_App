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


# 유저 정보 가져오기 - 세션
# 가져왔다고 치고....
$user_id = 1; # 1번 가져왔다고 가정

?>




<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<html>

<head>
  <title></title>
  <link rel="stylesheet" href="./css/jaehyun.css">

  <!-- 스타일 시트 순서 중요 !!!!!!!-->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/index.css" type="text/css"/>
  <!-- 폰트 -->
  <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Do+Hyeon&display=swap" rel="stylesheet">
  <!-- 아이콘 -->
  <script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
  <!-- 자바스크립트 -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="../js/nav.js"></script>
  <script src="../js/camera.js"></script>

</head>

<body>
  <nav class="shadow-sm p-3 mb-5  rounded navbar fixed-top">
    <p class="navp" style=" color:white;">Smart PT</p>
    <a href="userInsert3.php">
      <i class="fas fa-user-circle navi"></i>
    </a>

  </nav>
  <br><br><br>
  <div class="card">
    <div class="card-header">
      <p>오늘의 운동</p>
    </div>
    <div class="card-body" style="text-align:center">
      <!-- 운동데이터를 가져오는 php 문 -->
      <?php
      $sql1 = "SELECT * FROM doexercise INNER JOIN exerciseinfo on doexercise.exercise_id = exerciseInfo.exercise_id WHERE user_id='$user_id'";
      $result1 = $conn->query($sql1);

      if ($result1->num_rows > 0) { // 여러줄 가져오는 경우

      while($row = $result1->fetch_assoc()) {

      echo $row['exercise_name'] ." / " .$row['doexercise_minute'] ."분 / ".$row['doexercise_calory']."Kcal";
      echo nl2br("\n");
    }
  } else {
  echo "0 results";
}
?>
</div>
</div>
<br><br>
<div class="card">
  <div class="card-header">
    영양소
  </div>
  <?php
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
#echo $row['exercise_name'] ." / " .$row['exercise_minute'] ."분 / ".$row['exhausted_calory']."Kcal";
#echo nl2br("\n");
}
}
else echo "0 results";
?>
<div class="card-body">

  <div class="container">
    <div class="container" style="float:left; width: 15%;text-align: center;">
      <p class="pr" align="left;"> Kcal </p>

    </div>

    <div class="progress rounded-pill" style="height:40px;">
      <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
        <p class="pr" style="padding-top:15px;"> 1560/2600 </p>
      </div>
    </div>
  </div>

  <br><br>

  <div class="container">
    <div class="container" style="float:left; width: 15%;text-align: center;">
      <p class="pr" align="left;"> 탄 </p>

    </div>

    <div class="progress rounded-pill" style="height:30px;">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
        <p class="pr" tyle=" padding-top:15px;"> 250/400 </p>
      </div>
    </div>


  </div>
  <br><br>


  <div class="container">
    <div class="container" style="float:left; width: 15%;text-align: center;">
      <p class="pr" align="left;"> 단 </p>

    </div>

    <div class="progress rounded-pill" style="height:30px;">
      <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
        <p class="pr" style=" padding-top:15px;"> 80/140 </p>
      </div>
    </div>
  </div>


  <br><br>

  <div class="container" style="font-weight: bold;">
    <div class="container" style="float:left; width: 15%;text-align: center;">
      <p class="pr" align="left;"> 지 </p>

    </div>

    <div class="progress rounded-pill" style="height:30px;">
      <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
        <p class="pr" style="padding-top:15px;"> 30/70 </p>
      </div>
    </div>
  </div>
</div>
</div>

<br><br>
<div class="card">
  <div class="card-header">
    아침
  </div>
  <div class="card-body">
    <div style="float:left; margin:50px 50px;">
      <p> 쌀밥 300Kcal </p>
      <p> 불고기 300Kcal </p>
      <p> 된장국 300Kcal </p>
    </div>
    <div style="margin:20px 30px;">
      <div class="container" style="margin-bottom:-25px;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> Kcal </p>

        </div>

        <div class="progress rounded-pill" style="height:25px; width: 300px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 1560/2600 </p>
          </div>
        </div>
      </div>

      <br><br>

      <div class="container" style="margin-bottom:-20px;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 탄 </p>

        </div>

        <div class="progress rounded-pill" style="height:20px;  width: 300px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style=" padding-top:15px;"> 250/400 </p>
          </div>
        </div>


      </div>
      <br><br>


      <div class="container" style="margin-bottom:-20px;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 단 </p>

        </div>

        <div class="progress rounded-pill" style="height:20px;  width: 300px;">
          <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 80/140 </p>
          </div>
        </div>
      </div>


      <br><br>

      <div class="container" style="font-weight: bold;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 지 </p>

        </div>

        <div class="progress rounded-pill" style="height:20px;  width: 300px;">
          <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 30/70 </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<br><br>
<div class="card">
  <div class="card-header">
    점심
  </div>
  <div class="card-body">
    <div style="float:left; margin:50px 50px;">
      <p> 쌀밥 300Kcal </p>
      <p> 불고기 300Kcal </p>
      <p> 된장국 300Kcal </p>
    </div>
    <div style="margin:20px 30px;">
      <div class="container" style="margin-bottom:-25px;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> Kcal </p>

        </div>

        <div class="progress rounded-pill" style="height:25px; width: 300px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 1560/2600 </p>
          </div>
        </div>
      </div>

      <br><br>

      <div class="container" style="margin-bottom:-20px;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 탄 </p>

        </div>

        <div class="progress rounded-pill" style="height:20px;  width: 300px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 250/400 </p>
          </div>
        </div>


      </div>
      <br><br>


      <div class="container" style="margin-bottom:-20px;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 단 </p>

        </div>

        <div class="progress rounded-pill" style="height:20px;  width: 300px;">
          <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 80/140 </p>
          </div>
        </div>
      </div>


      <br><br>

      <div class="container" style="font-weight: bold;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 지 </p>

        </div>

        <div class="progress rounded-pill" style="height:20px;  width: 300px;">
          <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;"> 30/70 </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<br><br>
<div class="card">
  <div class="card-header">
    저녁
  </div>
  <div class="card-body">

  </div>
</div>
<br /><br /><br />
<nav class="navbar fixed-bottom navd">
  <a href="index.php">
    <div class="navIcons" style="text-align:center;" >
      <br/>
      <i class="navIcon fas fa-home navdi" id="navHome" aria-hidden="true"></i>
      <p class="navName navdp"> Home </p>
    </div>
  </a>
  <a href="recommend.php">
    <div class="navIcons" style="text-align:center;">
      <br/>
      <i class="navIcon fas fa-utensils navdi" id="navDiet" aria-hidden="true"></i>
      <p class="navName navdp"> Diet </p>
    </div>
  </a>
  <a href="miband.php">
    <div class="navIcons" style="text-align:center;">
      <br/>
      <i class="navIcon fas fa-heartbeat navdi" id="navMiband" aria-hidden="true"></i>
      <p class="navName navdp"> Miband </p>
    </div>
  </a>
  <a href="static.php">
    <div  class="navIcons" style="text-align:center;">
      <br/>
      <i class="navIcon far fa-chart-bar navdi" id="navChart" aria-hidden="true" ></i>
      <p class="navName navdp"> Chart </p>
    </div>
  </a>
</nav>



</body>

</html>
