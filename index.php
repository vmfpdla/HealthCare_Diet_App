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
  <link rel="stylesheet" href="./css/jaehyun.css?ver=1">
  <!-- 폰트 -->
  <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Do+Hyeon&display=swap" rel="stylesheet">
  <!-- 아이콘 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">

  <!-- 스크립트 -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="./js/nav.js"></script>
</head>

<body>
  <nav class="shadow-sm p-3 mb-5  rounded navbar fixed-top">
    <p class="navp" style=" color:white;">Smart PT</p>
    <a href="userinsert.php">
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
  else //echo "0 results";
?>
    <div class="card-body">

      <div class="container">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> Kcal </p>

        </div>

        <div class="progress rounded-pill" style="height:40px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
            style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:15px;">
              <?php echo $kcal ." / ". $user['user_goal'] ?>
            </p>
          </div>
        </div>
      </div>

      <br><br>

      <div class="container">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 탄 </p>

        </div>

        <div class="progress rounded-pill" style="height:30px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%"
            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style=" padding-top:20px;">
              <?php echo $car ." / ". $user['user_goal'] ?>
            </p>
          </div>
        </div>


      </div>
      <br><br>


      <div class="container">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 단 </p>

        </div>

        <div class="progress rounded-pill" style="height:30px;">
          <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar"
            style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style=" padding-top:20px;">
              <?php echo $pro ." / ". $user['user_goal'] ?>
            </p>
          </div>
        </div>
      </div>


      <br><br>

      <div class="container" style="font-weight: bold;">
        <div class="container" style="float:left; width: 15%;text-align: center;">
          <p class="pr" align="left;"> 지 </p>

        </div>

        <div class="progress rounded-pill" style="height:30px;">
          <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar"
            style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
            <p class="pr" style="padding-top:20px;">
              <?php echo $fat ." / ". $user['user_goal'] ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br><br>

  <?php
  // 아침에 먹은 식단을 가져온다.
  $sql3 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today' and eaten_time=1";
  $result3 = $conn->query($sql3);

  if ($result3 -> num_rows>0) { // 여러줄 가져오는 경우

    //아침에 먹은게 하나라도 있는 경우
    $is_morning =1;
  }
  else{
    // 아침에 먹은게 없는경우에는 카메라 아이콘 보여준다.
    $is_morning =0;
  }

  // 점심에 먹은 식단을 가져온다.
  $sql4 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today' and eaten_time=2";
  $result4 = $conn->query($sql4);

  if ($result4 -> num_rows>0) { // 여러줄 가져오는 경우

    //점심에 먹은게 하나라도 있는 경우
    $is_lunch =1;
  }
  else{
    // 점심에 먹은게 없는경우에는 카메라 아이콘 보여준다.
    $is_lunch =0;
  }

  // 저녁에 먹은 식단을 가져온다.
  $sql5 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today' and eaten_time=3";
  $result5 = $conn->query($sql5);


  if ($result5 -> num_rows>0) { // 여러줄 가져오는 경우

    //저녁에 먹은게 하나라도 있는 경우
    $is_dinner =1;
  }
  else{
    // 저녁에 먹은게 없는경우에는 카메라 아이콘 보여준다.
    $is_dinner =0;
  }

?>

  <div class="card">
    <div class="card-header">
      아침
    </div>
    <div class="card-body" id="camera_1" style="text-align: center;" >
      <form method="POST" action="foodinput.php">
        <input type="hidden" name="eatentime" value="1" />
        <button type="submit"><i class="fas fa-utensils cardi" aria-hidden="true"></i></button>
      </form>
    </div>
    <div class="card-body" id="diet_1">
      <div style="float:left; margin:50px 50px; width:15%;">
        <p style="width:100%"><?php
      if($is_morning==1){
        $morning_kcal =0;
        $morning_car =0;
        $morning_pro =0;
        $morning_fat =0;
        while($row = $result3->fetch_assoc()) {
          $morning_kcal = $morning_kcal+$row['food_calory'];
          $morning_car = $morning_car+$row['food_car'];
          $morning_pro = $morning_pro+$row['food_pro'];
          $morning_fat = $morning_fat+$row['food_fat'];
          echo $row['food_name'] ."  ". $row['food_calory']."  Kcal";
          echo nl2br("\n\n");
        }
      }
    ?></p>
      </div>
 
 <div style="margin:20px 30px; float:left; width:60%;" class="smallbar">
        <div class="container" style="margin-bottom:-25px;">
         <div class="container" style="float:left; width:20%;"> 
            <p class="pr"> Kcal </p>
         </div>

          <div class="progress rounded-pill" style="height:25px; width:70%">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
              style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $morning_kcal ." / 1500" ?> </p>
            </div>
          </div>
        </div>

        <br><br>

        <div class="container" style="margin-bottom:-20px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 탄 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px; width:70%;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%"
              aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style=" padding-top:15px;"> <?php echo $morning_car ." / 1500" ?> </p>
            </div>
          </div>


        </div>
        <br><br>


        <div class="container" style="margin-bottom:-20px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 단 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px; width:70%;">
            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar"
              style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $morning_pro ." / 1500" ?> </p>
            </div>
          </div>
        </div>


        <br><br>

        <div class="container" style="font-weight: bold;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 지 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px; width:70%;">
            <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar"
              style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $morning_fat ." / 1500" ?> </p>
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
    <div class="card-body" id="camera_2" style="text-align: center;">
      <form method="POST" action="foodinput.php">
        <input type="hidden" name="eatentime" value="2" />
        <button type="submit"> <i class="fas fa-utensils cardi" aria-hidden="true"></i></button>
      </form>
    </div>
    <div class="card-body" id="diet_2">
      <div style="float:left; margin:50px 50px;  width:15%;">
       <p style="width: 100%;"> <?php
    if($is_lunch==1){
      $lunch_kcal =0;
      $lunch_car =0;
      $lunch_pro =0;
      $lunch_fat =0;
      while($row = $result4->fetch_assoc()) {
        $lunch_kcal = $lunch_kcal+$row['food_calory'];
        $lunch_car =  $lunch_car+$row['food_car'];
        $lunch_pro =  $lunch_pro+$row['food_pro'];
        $lunch_fat =  $lunch_fat+$row['food_fat'];
        echo $row['food_name'] ."  ". $row['food_calory']."  Kcal";
        echo nl2br("\n\n");
      }
    }
    ?></p>
      </div>




      <div style="margin:20px 30px;" class="smallbar">
        <div class="container" style="margin-bottom:-25px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> Kcal </p>

          </div>

          <div class="progress rounded-pill" style="height:25px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
              style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $lunch_kcal ." / 1500" ?> </p>
            </div>
          </div>
        </div>

        <br><br>

        <div class="container" style="margin-bottom:-20px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 탄 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%"
              aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $lunch_car ." / 1500" ?> </p>
            </div>
          </div>


        </div>
        <br><br>


        <div class="container" style="margin-bottom:-20px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 단 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px;">
            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar"
              style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $lunch_pro ." / 1500" ?> </p>
            </div>
          </div>
        </div>


        <br><br>

        <div class="container" style="font-weight: bold;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 지 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px;">
            <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar"
              style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $lunch_fat ." / 1500" ?> </p>
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
    <div class="card-body" id="camera_3" style="text-align: center;">
      <form method="POST" action="foodinput.php">
        <input type="hidden" name="eatentime" value="3" />
        <button type="submit"> <i class="fas fa-utensils cardi" aria-hidden="true"></i></button>
      </form>
    </div>

    <div class="card-body" id="diet_3">
      <div style="float:left; margin:50px 50px;  width:15%;">
        <p style="width: 100%;">
        <?php
        if($is_dinner==1){
          $dinner_kcal =0;
          $dinner_car =0;
          $dinner_pro =0;
          $dinner_fat =0;
          while($row = $result5->fetch_assoc()) {
            $dinner_kcal = $dinner_kcal+$row['food_calory'];
            $dinner_car =  $dinner_car+$row['food_car'];
            $dinner_pro =  $dinner_pro+$row['food_pro'];
            $dinner_fat =  $dinner_fat+$row['food_fat'];
            echo $row['food_name'] ."  ". $row['food_calory']."  Kcal";
            echo nl2br("\n\n");
          }
        }
      ?></p>
      </div>
      <div style="margin:20px 30px;" class="smallbar">
        <div class="container" style="margin-bottom:-25px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> Kcal </p>

          </div>

          <div class="progress rounded-pill" style="height:25px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
              style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $dinner_kcal ." / 1500" ?> </p>
            </div>
          </div>
        </div>

        <br><br>

        <div class="container" style="margin-bottom:-20px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 탄 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62.5%"
              aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $dinner_car ." / 1500" ?> </p>
            </div>
          </div>


        </div>
        <br><br>


        <div class="container" style="margin-bottom:-20px;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 단 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px;">
            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar"
              style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $dinner_car ." / 1500" ?> </p>
            </div>
          </div>
        </div>


        <br><br>

        <div class="container" style="font-weight: bold;">
          <div class="container" style="float:left; width:20%;"> 
            <p class="pr" align="left;"> 지 </p>

          </div>

          <div class="progress rounded-pill" style="height:20px;">
            <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar"
              style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
              <p class="pr" style="padding-top:15px;"> <?php echo $dinner_fat ." / 1500" ?> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <br /><br /><br />
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
  <script>

    var is_morning = '<?php echo $is_morning ?>';
    var is_lunch = '<?php echo $is_lunch ?>';
    var is_dinner = '<?php echo $is_dinner ?>';

    if (is_morning == 1) {

      document.getElementById('camera_1').style.display = 'none';
      document.getElementById('diet_1').style.display = 'block';
    }
    else {

      document.getElementById('camera_1').style.display = 'block';
      document.getElementById('diet_1').style.display = 'none';
    }

    if (is_lunch == 1) {

      document.getElementById('camera_2').style.display = 'none';
      document.getElementById('diet_2').style.display = 'block';
    }
    else {

      document.getElementById('camera_2').style.display = 'block';
      document.getElementById('diet_2').style.display = 'none';
    }

    if (is_dinner == 1) {

      document.getElementById('camera_3').style.display = 'none';
      document.getElementById('diet_3').style.display = 'block';
    }
    else {

      document.getElementById('camera_3').style.display = 'block';
      document.getElementById('diet_3').style.display = 'none';
    }

  </script>
</body>

</html>
