<?php

	require_once("./dbconn.php");

	$today = date("Y-m-d");
	$kcal = 0; //칼로리
	$car =0; // 탄수화물
	$fat =0; // 지방
	$pro =0; // 단백질

	$user_id = 1; # 1번 가져왔다고 가정
	$sql = "SELECT * FROM user WHERE user_id='$user_id'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) { // 여러줄 가져오는 경우

	  while($row = $result->fetch_assoc()) {
	    $user = $row;
	  }
	}
	else {
	  echo "유저 접속 오류";
	}
	// 오늘 먹은 음식 조회
	$sql1 = "SELECT * FROM eatenfood INNER JOIN foodinfo on eatenfood.food_id = foodinfo.food_id WHERE user_id='$user_id' and eaten_day='$today'";
	$result1 = $conn->query($sql1);

	if ($result1 -> num_rows>0) { // 여러줄 가져오는 경우

		while($row = $result1->fetch_assoc()) {
			if($row['eaten_serving']==0)
			{ # 0인분인경우
				$kcal = $kcal + $row['food_calory']*0.5;
				$car = $car + $row['food_car']*0.5;
				$fat = $fat + $row['food_fat']*0.5;
				$pro = $pro + $row['food_pro']*0.5;
		 	}
			else
			{
				$kcal = $kcal + $row['food_calory']*$row['eaten_serving'];
				$car = $car + $row['food_car']*$row['eaten_serving'];
				$fat = $fat + $row['food_fat']*$row['eaten_serving'];
				$pro = $pro + $row['food_pro']*$row['eaten_serving'];
			 }
			if($row['eaten_time']==1) // 아침인경우
			{

			}
		}
	}
	else //echo "0 results";

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

	<script src="./js/nav.js"></script>
	<script src="./js/recommend.js"> </script>
</head>

<body>
	<nav class="navbar fixed-top">
		<p class="navp">Smart PT</p>
		<a href="userinsert.php"><i class="fa fa-user-circle navi"></i></a>
	</nav>

	<br><br>
	<div clas="container" style="text-align: center;">
		<i class="fa fa-spoon titlei" aria-hidden="true"></i>
		<p class="title">식단추천</p>
	</div>
	<br><br><br>
	<div class="card">
		<div class="card-header">
			영양소
		</div>
		<div class="card-body">
			<div class="container">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr" align="left;"> Kcal  </p>

				</div>

				<div class="progress rounded-pill" style="height:40px;">
					<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"role="progressbar"
					 	style="width: <?php echo $kcal/1500*100;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p  class="pr" style="padding-top:15px;">
							<?php echo $kcal ." / ". $user['user_goal'] ?>
						</p>
					</div>
				</div>
			</div>
			<br><br>
			<div class="container">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr" align="left;"> 탄  </p>

				</div>

				<div class="progress rounded-pill" style="height:30px;">
					<div class="progress-bar progress-bar-striped progress-bar-animated"role="progressbar"
					style="width:  <?php echo $car/1500*100;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p class="pr" style=" padding-top:20px;">
							<?php echo $car ." / ". $user['user_goal'] ?>
						</p>
					</div>
				</div>
			</div>
			<br><br>
			<div class="container">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr" align="left;"> 단  </p>

				</div>

				<div class="progress rounded-pill" style="height:30px;">
					<div class="progress-bar progress-bar-striped bg-success progress-bar-animated"role="progressbar"
					style="width: <?php echo $pro/1500*100;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p class="pr" style=" padding-top:20px;"> <?php echo $pro ." / ". $user['user_goal'] ?> </p>
					</div>
				</div>
			</div>
			<br><br>
			<div class="container" style="font-weight: bold;">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr"> 지  </p>

				</div>

				<div class="progress rounded-pill" style="height:30px;">
					<div class="progress-bar progress-bar-striped bg-info progress-bar-animated"role="progressbar"
					style="width: <?php echo $fat/1500*100;?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p class="pr" style=" padding-top:20px;"> <?php echo $fat ." / ". $user['user_goal'] ?> </p>
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
		<div class="card-body" id="input_1">

			<form action="javascript:Display();">
				<input type="number" size="20">
				<button>입력</button>
			</form>

			<div id="setKcal" style="display: none;">
				<form>
					<select name="selectset" onchange="SetDisplay(this.form)" >
						<option selected value=0>-선택하세요- </option>
						<option value=1>Set1</option>
						<option value=2>Set2</option>
						<option value=3>Set3</option>
					</select>
					<input name="set" type="text" size="50" maxlength="50">
				</form>
			</div>
		</div>

		<div class="card-body" id="diet_1">
			<p>
			<?php
				if($is_morning==1){
					while($row = $result3->fetch_assoc()) {
						if($row['eaten_serving']==0){
							echo $row['food_name'] ."  ". $row['food_calory']*0.5."  Kcal"."  (0.5 인분)";
							echo nl2br("\n\n");
						}
						else{
							echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."  (".$row['eaten_serving']." 인분)";
							echo nl2br("\n\n");
						}
					}
				}
			?>
			</p>
		</div>
	</div>


	<Br><br>
	<div class="card">
		<div class="card-header">
			점심
		</div>
		<div class="card-body" id="input_2">

			<form action="javascript:Display();">
				<input type="number" size="20">
				<button>입력</button>
			</form>

			<div id="setKcal" style="display: none;">
				<form>
					<select name="selectset" onchange="SetDisplay(this.form)" >
						<option selected value=0>-선택하세요- </option>
						<option value=1>Set1</option>
						<option value=2>Set2</option>
						<option value=3>Set3</option>
					</select>
					<input name="set" type="text" size="50" maxlength="50">
				</form>
			</div>
		</div>

		<div class="card-body" id="diet_2">
			<p>
			<?php
				if($is_lunch==1){
					while($row = $result4->fetch_assoc()) {
						if($row['eaten_serving']==0){
							echo $row['food_name'] ."  ". $row['food_calory']*0.5."  Kcal"."  (0.5 인분)";
							echo nl2br("\n\n");
						}
						else{
							echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."  (".$row['eaten_serving']." 인분)";
							echo nl2br("\n\n");
						}
					}
				}
			?>
			</p>
		</div>
	</div>
	<Br><br>
	<div class="card">
		<div class="card-header">
			저녁
		</div>
		<div class="card-body" id="input_3">

			<form action="javascript:Display();">
				<input type="number" size="20">
				<button>입력</button>
			</form>

			<div id="setKcal" style="display: none;">
				<form>
					<select name="selectset" onchange="SetDisplay(this.form)" >
						<option selected value=0>-선택하세요- </option>
						<option value=1>Set1</option>
						<option value=2>Set2</option>
						<option value=3>Set3</option>
					</select>
					<input name="set" type="text" size="50" maxlength="50">
				</form>
			</div>
		</div>
		<div class="card-body" id="diet_3">
			<p>
			<?php
				if($is_dinner==1){
					while($row = $result5->fetch_assoc()) {
						if($row['eaten_serving']==0){
							echo $row['food_name'] ."  ". $row['food_calory']*0.5."  Kcal"."  (0.5 인분)";
							echo nl2br("\n\n");
						}
						else{
							echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."  (".$row['eaten_serving']." 인분)";
							echo nl2br("\n\n");
						}
					}
				}
			?>
			</p>
		</div>
	</div>
	<br><br>
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

	var is_morning = '<?php echo $is_morning ?>';
	var is_lunch = '<?php echo $is_lunch ?>';
	var is_dinner = '<?php echo $is_dinner ?>';

	if (is_morning == 1) {
		document.getElementById('diet_1').style.display = 'block';
		document.getElementById('input_1').style.display = 'none';
	}
	else {

		document.getElementById('input_1').style.display = 'block';
		document.getElementById('diet_1').style.display = 'none';
	}

	if (is_lunch == 1) {

		document.getElementById('diet_2').style.display = 'block';
		document.getElementById('input_2').style.display = 'none';
	}
	else {

		document.getElementById('input_2').style.display = 'block';
		document.getElementById('diet_2').style.display = 'none';
	}

	if (is_dinner == 1) {

		document.getElementById('diet_3').style.display = 'block';
		document.getElementById('input_3').style.display = 'none';
	}
	else {

		document.getElementById('input_3').style.display = 'block';
		document.getElementById('diet_3').style.display = 'none';
	}

  </script>


</body>
</html>
