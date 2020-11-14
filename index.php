<?php

  require_once("./dbconn.php");

  $user_id = 1; # 1번 가져왔다고 가정
  $today = date("Y-m-d");

  $walking;
  $running;
  $kcal = 0; //칼로리
  $car =0; // 탄수화물
  $fat =0; // 지방
  $pro =0; // 단백질

  $sql = "SELECT * FROM user WHERE user_id='$user_id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { // 여러줄 가져오는 경우

    while($row = $result->fetch_assoc()) {
      $user = $row;
    }
  } else {
    echo "유저 접속 오류";
  }

  $maxcar = $user['user_goal'] * 0.65;
	$maxfat =$user['user_goal'] * 0.2;
	$maxpro =$user['user_goal'] * 0.15;

  $sql1 = "SELECT * FROM doexercise INNER JOIN exerciseinfo on doexercise.exercise_id = exerciseInfo.exercise_id WHERE user_id='$user_id' and doexercise_day='$today'";
  $result1 = $conn->query($sql1);


  if ($result1->num_rows > 0) { // 여러줄 가져오는 경우

    while($row = $result1->fetch_assoc()) {
      if($row['exercise_id']==1) $walking = $row;
      else if($row['exercise_id']==2) $running = $row;
    // echo $row['exercise_name'] ." / " .$row['doexercise_minute'] ."분 / ".$row['doexercise_calory']."Kcal";
    // echo nl2br("\n");
    }
  }
  else {
    //echo //"아직 운동을 안했어요 !";
  }
  if($walking==null){
    $walking['doexercise_calory']=0;
    $walking['doexercise_minute']=0;
    $walking['doexercise_distance']=0;
  }
  if($running==null){
    $running['doexercise_calory']=0;
    $running['doexercise_minute']=0;
    $running['doexercise_distance']=0;
  }

  $sql2 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today'";
  $result2 = $conn->query($sql2);

  if ($result2 -> num_rows>0) { // 여러줄 가져오는 경우

  while($row = $result2->fetch_assoc()) {
    if($row['eaten_serving']==0){ # 0인분인경우
      $kcal = $kcal + $row['food_calory']*0.5;
      $car = $car + $row['food_car']*0.5;
      $fat = $fat + $row['food_fat']*0.5;
      $pro = $pro + $row['food_pro']*0.5;
   }
   else{
    $kcal = $kcal + $row['food_calory']*$row['eaten_serving'];
    $car = $car + $row['food_car']*$row['eaten_serving'];
    $fat = $fat + $row['food_fat']*$row['eaten_serving'];
    $pro = $pro + $row['food_pro']*$row['eaten_serving'];
   }
  #echo $row['exercise_name'] ." / " .$row['exercise_minute'] ."분 / ".$row['exhausted_calory']."Kcal";
  #echo nl2br("\n");
  }

  }
  else //echo "0 results";

?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<html>

<head>
  <title></title>
  <meta charset="utf-8">


  <!-- 외부 css -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/jaehyun.css?ver=3">
  <!-- 아이콘 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">
  <!-- 스크립트 -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="./js/nav.js"></script>

  <style>

    #btn1 {
      border: 1px solid #8DA5BD;
      background-color: rgba(0, 0, 0, 0);
      color: #8DA5BD;
      padding: 5px;
      border-top-left-radius: 5px;
      border-bottom-left-radius: 5px;
      border-top-right-radius: 5px;
      border-bottom-right-radius: 5px;

      width: 100%;
      height: 70px;
      font-weight: bold;
      font-size: 30px;
    }

    #btn1:hover {
      color: white;
      background-color: #8DA5BD;
    }
  </style>



</head>

<body>
  <nav class="navbar fixed-top">
    <p class="navp">Smart PT</p>
    <a href="userinsert.php">
      <i class="fa fa-user-circle navi"></i>
    </a>

  </nav>
  <br><br><br>

  <div style="margin-left:50px;">
    <p style="font-size:80px;">오늘의 운동</p>
    <p class="mb-2 text-muted" style="font-size:70px;">Today's exercise</p>
  </div>
  <br>
  <div class="card exercise-card" style="float:left; margin:0 100px;">
    <div class="card-body">
        <img src="./walking.png"  width="100" height="100"/>
        <p style="font-size:60px; margin-bottom:0; color:#f38181;"><?php echo $walking['doexercise_calory'];?></p>
        <p style="font-size:40px; color:gray;">Kcal</p>
        <div>
          <p style="font-size:30px; float:left; margin-left:40px;"><?php echo $walking['doexercise_minute'];?> min</p>
          <p style="font-size:30px; "><?php echo $walking['doexercise_distance'];?> km</p>
	     </div>
    </div>
  </div>

  <div class="card exercise-card" style="margin-right:100px;">
    <div class="card-body">
        <img src="./running.png"  width="100" height="100"/>
        <p style="font-size:60px; margin-bottom:0; color:#f38181;"><?php echo $running['doexercise_calory'];?></p>
        <p style="font-size:40px; color:gray;">Kcal</p>
        <div>
          <p style="font-size:30px; float:left; margin-left:40px;"><?php echo $running['doexercise_minute'];?> min</p>
          <p style="font-size:30px; "><?php echo $running['doexercise_distance'];?> km</p>
        </div>
    </div>
  </div>

  <br><br><br><br>
  <a href="app://application">Call Android Activity</a>
  <div style="margin-left:50px;">
    <p style="font-size:80px;">오늘의 영양소</p>
    <p class="mb-2 text-muted" style="font-size:70px;">Today's nutrients</p>
  </div>
  <br>
  <div class="card nutrients-card" style="margin:0 100px; height:350px;">
    <div class="card-body">
      <br><br>
      <div>
        <p style="margin-right:20px; font-size:40px;" > 칼로리 </p>
        <div class="progress" style="height:30px;" >
          <div class="progress-bar bg-success" role="progressbar" style="width:  <?php echo $kcal/$user['user_goal']*100;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p style="text-align:center; font-size:30px;"><?php echo $kcal."/".$user['user_goal'];?></p>
      </div>
      <br><br>
      <div class="carprofat">
        <div style="float:left; width:150px; text-align:center; margin:0 70px;">
          <p style="font-size:40px;"> 탄수화물 </p>
          <div class="progress" >
            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $car/$maxcar*100;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> </div>
          </div>
          <p style="font-size:30px;"><?php echo $car."/".$maxcar;?></p>
        </div>
        <div style="float:left; width:150px; text-align:center; margin-right: 70px;">
          <p style="font-size:40px;"> 단백질 </p>
          <div class="progress" >
            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $pro/$maxpro*100;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> </div>
          </div>
          <p style="font-size:30px;"><?php echo $pro."/".$maxpro;?></p>
        </div>
        <div style="float:left; width:150px; text-align:center;">
          <p style="font-size:40px;"> 지방 </p>
          <div class="progress" >
            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $fat/$maxfat*100;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p style="font-size:30px;"><?php echo $fat."/".$maxfat;?></p>
        </div>
      </div>
    </div>
  </div>


  <br><br><br><br>
  <nav class="navbar fixed-bottom navd">
    <a href="index.php">
      <div class="navIcons" style="text-align:center;">
        <br />
        <i class="navIcon fas fa-home navdi" id="navHome" aria-hidden="true"></i>
        <p class="navName navdp"> Home </p>
      </div>
    </a>
    <a href="recommend.php">
      <div class="navIcons" style="text-align:center;">
        <br />
        <i class="navIcon fas fa-utensils navdi" id="navDiet" aria-hidden="true"></i>
        <p class="navName navdp"> Diet </p>
      </div>
    </a>
    <a href="miband.php">
      <div class="navIcons" style="text-align:center;">
        <br />
        <i class="navIcon fas fa-heartbeat navdi" id="navMiband" aria-hidden="true"></i>
        <p class="navName navdp"> Miband </p>
      </div>
    </a>
    <a href="static.php">
      <div class="navIcons" style="text-align:center;">
        <br />
        <i class="navIcon far fa-chart-bar navdi" id="navChart" aria-hidden="true"></i>
        <p class="navName navdp"> Chart </p>
      </div>
    </a>
  </nav>
</body>
</html>
