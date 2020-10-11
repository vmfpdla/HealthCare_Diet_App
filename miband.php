<?php
  require_once("./dbconn.php");
  $user_id = 1; # 1번 가져왔다고 가정
  $user['user_goal']= 1500;
  $today = date("Y-m-d");
  $kcal =0;//칼로리

  $sql1 = "SELECT * FROM doexercise INNER JOIN exerciseinfo on doexercise.exercise_id = exerciseInfo.exercise_id WHERE user_id='$user_id' and doexercise_day='$today'";
  $result1 = $conn->query($sql1);

  if ($result1->num_rows > 0) { // 여러줄 가져오는 경우
    while($row = $result1->fetch_assoc())
    {
          if($row['exercise_name']=='걷기')
          {
            $walking = $row;
            $walking_calory = $row['exercise_calory'];

          }
          else if($row['exercise_name']=='수영')
          {
            $swimming = $row;
            $swimming_calory = $row['exercise_calory'];

          }
          else if($row['exercise_name']=='자전거')
          {
            $cycle = $row;
            $cycle_calory = $row['exercise_calory'];

          }
          else
          {
            $rope = $row;
            $rope_calory = $row['exercise_calory'];

          }

          $kcal = $kcal - $row['doexercise_calory'];
    }
  }


  $sql2 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today'";
  $result2 = $conn->query($sql2);

  if ($result2 -> num_rows>0) { // 여러줄 가져오는 경우

    while($row = $result2->fetch_assoc()) {
      if($row['eaten_serving']==0){ # 1/2인분인경우
        $kcal = $kcal + 0.5*$row['food_calory'];
      }

      else if($row['eaten_serving']==1){ # 1인분인경우
        $kcal = $kcal + $row['food_calory'];
      }

      else if($row['eaten_serving']==2){ # 2인분인경우
        $kcal = $kcal + 2*$row['food_calory'];
      }
    }
  }

  if($kcal > $user['user_goal']) // 칼로리가 초과했으면
  {
    $is_uptoCalory =1;
  }
  else{ // 아니면
    $is_uptoCalory=0;
  }



  $recommend_walking = ($kcal-$user['user_goal'])/$walking_calory;
  $recommend_swimming = ($kcal-$user['user_goal'])/$swimming_calory;
  $recommend_cycle =($kcal-$user['user_goal'])/$cycle_calory;
  $recommend_rope = ($kcal-$user['user_goal'])/$rope_calory;

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!-- 외부 css -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/jaehyun.css?ver=2">
  <!-- 폰트 -->
  <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Do+Hyeon&display=swap" rel="stylesheet">
  <!-- 아이콘 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">

  <!-- 스크립트 -->
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="./js/nav.js"></script>
</head>

<body>
  <nav class="navbar fixed-top">
    <p class="navp">Smart PT</p>
    <a href="userInsert3.html"><i class="fa fa-user-circle navi"></i></a>
  </nav>
  <br><br><br>
  <div class="card">
    <div class="card-header">
      오늘의 운동
    </div>
    <div class="card-body">
      <div class="container">
        <div style="height:100px; text-align:center;">
          <div>
            <i class="fas fa-walking mifi"></i>
            <p class="mif">걷기</p>
            <p><?php echo $walking['doexercise_minute'] ." 분 / ". $walking['doexercise_calory']." Kcal";?></p>

          </div>
          <div>
            <i class="fas fa-swimmer mifi"></i>
            <p class="mif">수영</p>
            <p><?php echo $swimming['doexercise_minute'] ." 분 / ". $swimming['doexercise_calory']." Kcal";?></p>
          </div>
          <div>
            <i class="fas fa-biking mifi"></i>
            <p class="mif">자전거</p>
            <p><?php echo $cycle['doexercise_minute'] ." 분 / ". $cycle['doexercise_calory']." Kcal";?></p>
          </div>
          <div>
            <i class="fas fa-swimmer mifi"></i>
            <p class="mif">줄넘기</p>
            <p><?php echo $rope['doexercise_minute'] ." 분 / ". $rope['doexercise_calory']." Kcal";?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container" style="margin:5% 0 0 15%;">
    <div class="progress rounded-pill" style="height:40px; float:left; width: 80%; margin-top:1%;">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
        <p class="pr" > <?php echo $kcal ." / ". $user['user_goal']." Kcal";?></p>
      </div>
    </div>
  </div>

  <div id="notification_div" style="position:absolute; right:10%; width:150px; margin-top:50px;">
    <i class="fas fa-exclamation-circle misi" style="padding-top:10px;"></i>
    <p style="font-size:15px; padding-top:10px;">총 <?php echo ($kcal-$user['user_goal']);?> Kcal 초과</p>
  </div>

  <br><br><br><br><br><br>

  <div class="card" id="recommend_exercise">
    <div class="card-header">
      추천 운동
    </div>
    <div class="card-body">
      <div class="container">
        <div style="height:600px; text-align:center;">
          <div id="exercise">
            <h3 class="mip">걷기</h3>
            <p class="mipp">  <?php echo $recommend_walking.'분 / '. ($kcal-$user['user_goal']).' Kcal'; ?></p>
          </div>
          <div id="exercise">
            <h3 class="mip">수영</h3>
            <p class="mipp"> <?php echo $recommend_swimming.'분 / '. ($kcal-$user['user_goal']).' Kcal'; ?></p>
          </div>
          <div id="exercise">
            <h3 class="mip">자전거</h3>
            <p class="mipp"> <?php echo $recommend_cycle.'분 / '. ($kcal-$user['user_goal']).' Kcal'; ?></p>
          </div>
          <div id="exercise">
            <h3 class="mip">줄넘기</h3>
            <p class="mipp"> <?php echo $recommend_rope.'분 / '. ($kcal-$user['user_goal']).' Kcal'; ?></p>
          </div>
        </div>
      </div>
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

  <script>
    var is_uptoCalory = '<?php echo $is_uptoCalory ?>';
    // 칼로리 초과했으면 보여주고 아니면 안보여주고 !
    if(is_uptoCalory==0){
      document.getElementById('notification_div').style.display='none';
      document.getElementById('recommend_exercise').style.display='none';
    }
    else{
      document.getElementById('notification_div').style.display='block';
      document.getElementById('recommend_exercise').style.display='block';
    }


  </script>
</body>
</html>
