<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" href="./css/jaehyun.css">

	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./style.css">
	<link rel="stylesheet" href="/resource/css/bootstrap.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<meta charset="utf-8">

	<scrip src="./js/nav.js">


</head>
<body>


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


	<br><br>





</body>
</html>
