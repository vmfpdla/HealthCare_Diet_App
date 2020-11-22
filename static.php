<?php
  require_once("./dbconn.php");
  session_start();
  $user_id = $_SESSION['id'] ;
  $user_id=1;
  $i=0;
  $j=0;
  $dailyKcal; // 일별 섭취 칼로리
  $inbody;
  $today = date("Y-m-d");
  $user;


  $sql = "SELECT * FROM user WHERE user_id='$user_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) { // 여러줄 가져오는 경우
    while($row = $result->fetch_assoc())
    {
      $user=$row;
    }
  }

  // 음식 칼로리 불러오기
  $sql1 = "SELECT * FROM eatenfood WHERE user_id='$user_id' ORDER BY eaten_day";
  $result1 = $conn->query($sql1);

  if ($result1->num_rows > 0) { // 여러줄 가져오는 경우
    while($row = $result1->fetch_assoc())
    {
          $dailyKcal[$i]=$row;
          $i++;
    }
  }

  //
  $sql2= "SELECT * FROM inbody WHERE user_id='$user_id' ORDER BY ABS(DATEDIFF(NOW(),inbody_day)) LIMIT 5";
  $result2 = $conn->query($sql2);

  if ($result2->num_rows > 0) { // 여러줄 가져오는 경우
    while($row = $result2->fetch_assoc())
    {
          $inbody[$j]=$row;
          $j++;
    }
  }

?>
<!DOCTYPE html>
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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
  <script src="./js/nav.js"></script>




</head>

<body>
  <div id="dailykcalarray" style="display:none">
    <?php
      echo json_encode($dailyKcal);
    ?>
  </div>
  <div id="dailyinbodyarray"  style="display:none">
    <?php
      echo json_encode($inbody);
    ?>
  </div>
	<nav class="navbar fixed-top">
		<p class="navp">SmartPT</p>
		<a href=""><i class="fas fa-spinner " style="font-size:70px; color:#D8D8D8; margin-right:30px;"></i></a>

    <!-- <i class="fas fa-spinner fa-10x fa-spin"></i> -->
	</nav>

	<br><br><br>
  <div id="carouselExampleCaptions1" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<div style="width:95%; margin-left:20px;">
					<canvas id="daily_kcal"></canvas>
          <script src="./js/daily_kcalgraph.js?ver=1"></script>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:95%; margin-left:20px;">
					<canvas id="week_kcal"></canvas>
          <script src="./js/week_kcalgraph.js?ver=1"></script>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:95%; margin-left:20px;">
					<canvas id="month_kcal"></canvas>
          <script src="./js/month_kcalgraph.js?ver=1"></script>
				</div>
			</div>
		</div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions1" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
    </a>
     <a class="carousel-control-next" href="#carouselExampleCaptions1" role="button" data-slide="next">
       <span class="carousel-control-next-icon" aria-hidden="true"></span>
       <span class="sr-only">Next</span>
     </a>
	</div>

	<br><br><br>
	<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<div style="width:100%">
					<canvas id="inbodyMuscle"></canvas>
          <script src="./js/inbodyMuscle.js?ver=1"></script>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:100%">
					<canvas id="inbodyFat"></canvas>
          <script src="./js/inbodyFat.js?ver=1"></script>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:100%">
					<canvas id="inbodyKg"></canvas>
          <script src="./js/inbodyKg.js?ver=1"></script>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:100%">
					<canvas id="inbodyBmi"></canvas>
          <script src="./js/inbodyBmi.js?ver=1"></script>
				</div>
			</div>
		</div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
    </a>
     <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
       <span class="carousel-control-next-icon" aria-hidden="true"></span>
       <span class="sr-only">Next</span>
     </a>
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
    <a href="static.php">
      <div class="navIcons" style="text-align:center;">
        <br />
        <i class="navIcon far fa-chart-bar navdi" id="navChart" aria-hidden="true" style="color:#8DA5BD;"></i>
        <p class="navName navdp" style="color:#8DA5BD;"> Chart </p>
      </div>
    </a>
  </nav>
  <script>

    var user_check = '<?php echo $user[user_check_inbody] ?>';

    if (user_check == 0) {
      document.getElementById('carouselExampleCaptions').style.display = 'none';
    }
    else {
      document.getElementById('carouselExampleCaptions').style.display = 'block';
    }

    $('.carousel').carousel({
      touch: true
    })


  </script>

</body>
</html>
