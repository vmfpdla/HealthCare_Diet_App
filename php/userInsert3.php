<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- 스타일 시트 순서 중요 !!!!!!!-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/index.css" type="text/css"/>
	<!-- 폰트 -->
	<link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Do+Hyeon&display=swap" rel="stylesheet">
	<!-- 아이콘 -->
	<script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>

	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<meta charset="utf-8">

	<style>
		body{
			padding-top: 180px;
			padding-bottom: 120px;
		}

		.form_group{

		}
	</style>
</head>
<body>
	<nav class="navbar fixed-top" style="background-color:#8DA5BD">
		<p style="font-size:90px; font-weight:bold; color:white;">Smart PT</p>
		<a href="userInsert3.html"><i class="fa fa-user-circle" style="font-size:100px; color:white;"></i></a>
	</nav>

  <form style="width:80%; margin: 10% auto;">
  <div class="form-row">
		<div class="form-group col-md-6">
      <label for="inputState">성별</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>Male</option>
        <option>Female</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputNumber">나이</label>
      <input type="number" min="0" max="100" class="form-control" id="inputNumber" placeholder="age ( 세 )">
    </div>

  </div>
	<div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputHeight">키</label>
      <input type="number" min="100" max="250" class="form-control" id="inputHeight" placeholder="height ( cm )">
    </div>
		<div class="form-group col-md-6">
	    <label for="inputWeight">체중</label>
	    <input type="number" min="10" max="150" class="form-control" id="inputWeight" placeholder="weight ( Kg )">
	  </div>
  </div>
	<div class="form-group">
		<label for="inputState">운동 빈도</label>
		<select id="inputState" class="form-control">
			<option selected>Choose...</option>
			<option>앉아서 주로 생활 / 가벼운 움직임만 한다</option>
			<option>규칙적인 생활을 한다</option>
			<option>육체노동 등 평소 신체 활동량이 많다</option>
		</select>
	</div>
  <div class="form-group">
    <label for="inputCalory">하루 목표 칼로리</label>
    <input type="number" class="form-control" id="inputCalory" placeholder="Calory ( Kcal )">
    <br>
    <p style="color:gray;">[ 하루 권장 칼로리 ] 표준체중(kg) X 활동지수</p>
    <p style="color:gray;">[ 다이어트 식단 칼로리 ] 여성 : 800 - 1200 Kcal , 남성 : 1200 - 1400 Kcal</p>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputState">미스케일 사용여부</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>Yes</option>
        <option>No</option>
      </select>
    </div>
  </div>


  <button type="submit" class="btn btn-primary">Sign in</button>
</form>


<br /><br /><br />
<nav class="navbar fixed-bottom" style="background-color:white; box-shadow: 20px 20px 20px 20px #E6E6E6; padding-right:70px; padding-left:70px;">
	<a href="index.php">
		<div class="navIcons" style="text-align:center;">
			<br />
			<i class="navIcon fas fa-home" id="navHome" aria-hidden="true" style="font-size:60px; color:#BDBDBD;"></i>
			<p class="navName" style="color:#BDBDBD;"> Home </p>
		</div>
	</a>
	<a href="recommend.php">
		<div class="navIcons" style="text-align:center;">
			<br />
			<i class="navIcon fas fa-utensils" id="navDiet" aria-hidden="true" style="font-size:60px; color:#BDBDBD;"></i>
			<p class="navName" style="color:#BDBDBD;"> Diet </p>
		</div>
	</a>
	<a href="miband.php">
		<div class="navIcons" style="text-align:center;">
			<br />
			<i class="navIcon fas fa-heartbeat" id="navMiband" aria-hidden="true" style="font-size:60px; color:#BDBDBD;"></i>
			<p class="navName" style="color:#BDBDBD;"> Miband </p>
		</div>
	</a>
	<a href="static.php">
		<div class="navIcons" style="text-align:center;">
			<br />
			<i class="navIcon far fa-chart-bar" id="navChart" aria-hidden="true" style="font-size:60px; color:#BDBDBD;"></i>
			<p class="navName" style="color:#BDBDBD;"> Chart </p>
		</div>
	</a>
</nav>




</body>
</html>
