<?php
  require_once("./dbconn.php");
  $user_id = 1; # 1번 가져왔다고 가정


  $sql1 = "SELECT * FROM eatenfood WHERE user_id='$user_id' ORDER BY eaten_day";
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

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta charset="utf-8">

  <link rel="stylesheet" href="./css/jaehyun.css">

  <!-- 외부 css -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

</head>
<body>
	<nav class="navbar fixed-top">
		<p class="navp">Smart PT</p>
		<a href="userinsert.php"><i class="fa fa-user-circle navi"></i></a>
	</nav>

	<br><br><br>
	<div style="width:100%">
		<canvas id="daily_kcal"></canvas>
	</div>
	<script src="./js/daily_kcalgraph.js"></script>

	<br><br><br>
	<div style="width:100%">
		<canvas id="week_kcal"></canvas>
	</div>
	<script src="./js/week_kcalgraph.js"></script>

	<br><br><br>
	<div style="width:100%">
		<canvas id="month_kcal"></canvas>
	</div>
	<script src="./js/month_kcalgraph.js"></script>

	<br><br><br>
	<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
			<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
			<li data-target="#carouselExampleCaptions" data-slide-to="3"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<div style="width:100%">
					<canvas id="inbodyMuscle"></canvas>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:100%">
					<canvas id="inbodyFat"></canvas>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:100%">
					<canvas id="inbodyKg"></canvas>
				</div>
			</div>
			<div class="carousel-item">
				<div style="width:100%">
					<canvas id="inbodyBmi"></canvas>
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
	<script src="./js/inbodyKg.js"></script>
	<script src="./js/inbodyFat.js"></script>
	<script src="./js/inbodyMuscle.js"></script>
	<script src="./js/inbodyBmi.js"></script>
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
