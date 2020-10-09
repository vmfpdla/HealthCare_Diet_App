<!DOCTYPE html>
<html>
<head>


	<link rel="stylesheet" href="./css/jaehyun.css">
 <script src="./js/nav.js"></script>
 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">
  <link rel="stylesheet" href="/resource/css/bootstrap.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</head>



<body>

	<nav class="navbar fixed-top">
		<p class="navp">Smart PT</p>
		<a href="userInsert3.html"><i class="fa fa-user-circle navi"></i></a>
	</nav>

	<br><br>
	<br><br>
	<br><br>

	<div class="container" style="text-align: center;">
		<i class="fa fa-pie-chart titlei" aria-hidden="true"></i>
		<p class="title">Report</p>
	</div>
	<br><br><br>	
	<div style="width:100%">
		<canvas id="Kcal"></canvas>
	</div>
	<script src="./js/KcalGraph.js"></script>

	<br><br>



	<br><br><br>	
	<div style="width:100%">
		<canvas id="Kg"></canvas>
	</div>

	<script src="./js/KgGraph.js"></script>

	<br><br>







	<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
			<li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
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



	<script src="./js/inbodyKg.js"> 
	</script>



		<script src="./js/inbodyFat.js"> 
	</script>


		<script src="./js/inbodyMuscle.js"> 
	</script>


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
