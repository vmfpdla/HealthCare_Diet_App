<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./style.css">
	<link rel="stylesheet" href="/resource/css/bootstrap.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<meta charset="utf-8">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

	<style>

		body{padding-top:120px;
			padding-bottom:120px;
		}

		.inav:hover{
			-ms-transform: scale(1.5);
			-webkit-transform: scale(1.5);
			transform: scale(1.5);
			opacity: 0.7;
		}
	</style>
</head>



<body>

	<nav class="navbar fixed-top" style="background-color:#8DA5BD">
		<p style="font-size:90px; font-weight:bold; color:white;">Smart PT</p>
		<a href="userInsert3.html"><i class="fa fa-user-circle" style="font-size:100px; color:white;"></i></a>
	</nav>

	<br><br>
	<div clas="container" style="text-align: center;">
		<i class="fa fa-pie-chart" aria-hidden="true" style="font-size:300px; color:#8DA5BD; float: center;"></i>
		<p style="float: center; font-size: 100px;">Report</p>
	</div>
	<br><br><br>
	<div style="width:100%">
		<canvas id="Kcal"></canvas>
	</div>
	<script>
				// 우선 컨텍스트를 가져옵니다.
				var ctx = document.getElementById("Kcal").getContext('2d');
/*
	- Chart를 생성하면서,
	- ctx를 첫번째 argument로 넘겨주고,
	- 두번째 argument로 그림을 그릴때 필요한 요소들을 모두 넘겨줍니다.
	*/
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'],
			datasets: [{
				label: 'Daily Kcal',
				data: [2300, 2200, 2200, 2150, 2400, 2100,1970],
				backgroundColor: [
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			legend: {
				labels: {
					fontColor: "blue",
					fontSize: 18
				}
			},
						maintainAspectRatio: true, // default value. false일 경우 포함된 div의 크기에 맞춰서 그려짐.
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:false
								}
							}]
						}
					}
				});

			</script>

			<br><br>



			<br><br><br>
			<div style="width:100%">
				<canvas id="Kg"></canvas>
			</div>
			<script>
				// 우선 컨텍스트를 가져옵니다.
				var ctx = document.getElementById("Kg").getContext('2d');
/*
	- Chart를 생성하면서,
	- ctx를 첫번째 argument로 넘겨주고,
	- 두번째 argument로 그림을 그릴때 필요한 요소들을 모두 넘겨줍니다.
	*/
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'],
			datasets: [{
				label: 'Daily Kg',
				data: [65, 65.4, 64.5, 64.7, 64.3, 64.6,64.3],
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)'
				],
				borderColor: [
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)'
				],
				borderWidth: 1
			}]
		},
		options: {

			legend: {
				labels: {
					fontColor: "red",
					fontSize: 18
				}
			},
						maintainAspectRatio: true, // default value. false일 경우 포함된 div의 크기에 맞춰서 그려짐.
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero:false
								}
							}]
						}
					}
				});


			</script>

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



	<script> var ctx = document.getElementById('inbodyKg').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택
			type: 'line', // 챠트를 그릴 데이타
		data: { labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'], datasets: [{ label: '체중', backgroundColor: 'transparent', borderColor: 'red', data: [65, 65.4, 64.5, 64.7, 64.3, 64.6,64.3] }] }, // 옵션
		options: {
			legend: {
				labels: {
					fontColor: "red",
					fontSize: 18
				}
			}

		} });
	</script>



		<script> var ctx = document.getElementById('inbodyFat').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택
			type: 'line', // 챠트를 그릴 데이타
		data: { labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'], datasets: [{ label: '체지방률', backgroundColor: 'transparent', borderColor: 'Blue', data: [23.4, 23, 23.3, 22.9, 22.9, 22.7, 22.4] }] }, // 옵션
		options: {

			legend: {
				labels: {
					fontColor: "blue",
					fontSize: 18
				}
			}
		} });
	</script>


		<script> var ctx = document.getElementById('inbodyMuscle').getContext('2d'); var chart = new Chart(ctx, { // 챠트 종류를 선택
			type: 'line', // 챠트를 그릴 데이타
		data: { labels: ['1일차', '2일차', '3일차', '4일차', '5일차', '6일차', '7일차'], datasets: [{ label: '근육량', backgroundColor: 'transparent', borderColor: 'Green', data: [32.1, 32.3, 32.4, 32.4, 32.2, 33, 33.3] }] }, // 옵션
		options: {
			legend: {
				labels: {
					fontColor: "Green",
					fontSize: 18
				}
			}


		} });
	</script>


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
