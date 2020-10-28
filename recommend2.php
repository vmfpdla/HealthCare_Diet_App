<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="./css/jaehyun.css">
	
 
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">
  <link rel="stylesheet" href="/resource/css/bootstrap.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
 <script src="./js/nav.js"></script>
</STYLE>

</script>
</head>
<body>
	<nav class="navbar fixed-top">
		<p class="navp">Smart PT</p>
		<a href="userInsert3.html"><i class="fa fa-user-circle navi"></i></a>
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
					<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"role="progressbar" style="width: 60%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p  style="font-size:20px; font-weight: bold;"> 1560/2600 </p>
					</div>
				</div>
			</div>
			<br><br>
			<div class="container">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr" align="left;"> 탄  </p>
					
				</div>	
				<div class="progress rounded-pill" style="height:30px;">
					<div class="progress-bar progress-bar-striped progress-bar-animated"role="progressbar" style="width: 62.5%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p class="pr"> 250/400 </p>
					</div>
				</div>
			</div>
			<br><br>
			<div class="container">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr" align="left;"> 단  </p>
					
				</div>	
				<div class="progress rounded-pill" style="height:30px;">
					<div class="progress-bar progress-bar-striped bg-success progress-bar-animated"role="progressbar" style="width: 57%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p class="pr"> 80/140 </p>
					</div>
				</div>
			</div>
			<br><br>
			<div class="container" style="font-weight: bold;">
				<div class="container" style="float:left; width: 15%;text-align: center;">
					<p class="pr"> 지  </p>
				</div>	
				<div class="progress rounded-pill" style="height:30px;">
					<div class="progress-bar progress-bar-striped bg-info progress-bar-animated"role="progressbar" style="width: 42%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
						<p class="pr"> 30/70 </p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<Br><br>
	
	<div class="card">
		<div class="card-header">
			아침
		</div>
		<div class="card-body">
			<p> 쌀밥 300Kcal <br> 불고기 471Kcal <br> 된장국 78Kcal  </p>
		</div>
	</div>
	
	<Br><br>
	<div class="card">
		<div class="card-header">
			점심
		</div>
		<div class="card-body">
			<form action="recommend_diet.php" method="POST">
				<input type="number" id="inputKcal" name="inputKcal" size="20">
				<button>입력</button>
			</form>
			</div>
		</div>
	</div>
	<Br><br>
	<div class="card">
		<div class="card-header">
			저녁
		</div>
		<div class="card-body">
			<p> 쌀밥 300Kcal <br> 불고기 471Kcal <br> 된장국 78Kcal  </p>
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
</body>
</html>
