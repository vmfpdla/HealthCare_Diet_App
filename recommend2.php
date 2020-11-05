<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="./css/jaehyun.css">

        <link
            rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
        <link
            rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">
        <link rel="stylesheet" href="/resource/css/bootstrap.css">
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
        <script src="./js/nav.js"></script>
    </style>
</script>
</head>
<body>
<nav class="navbar fixed-top">
    <p class="navp">Smart PT</p>
    <a href="userInsert3.html">
        <i class="fa fa-user-circle navi"></i>
    </a>
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
                <p class="pr" align="left;">
                    Kcal
                </p>

            </div>
            <div class="progress rounded-pill" style="height:40px;">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                    role="progressbar"
                    style="width: 60%"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    <p style="font-size:20px; font-weight: bold;">
                        1560/2600
                    </p>
                </div>
            </div>
        </div>
        <br><br>
        <div class="container">
            <div class="container" style="float:left; width: 15%;text-align: center;">
                <p class="pr" align="left;">
                    탄
                </p>

            </div>
            <div class="progress rounded-pill" style="height:30px;">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    style="width: 62.5%"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    <p class="pr">
                        250/400
                    </p>
                </div>
            </div>
        </div>
        <br><br>
        <div class="container">
            <div class="container" style="float:left; width: 15%;text-align: center;">
                <p class="pr" align="left;">
                    단
                </p>

            </div>
            <div class="progress rounded-pill" style="height:30px;">
                <div
                    class="progress-bar progress-bar-striped bg-success progress-bar-animated"
                    role="progressbar"
                    style="width: 57%"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    <p class="pr">
                        80/140
                    </p>
                </div>
            </div>
        </div>
        <br><br>
        <div class="container" style="font-weight: bold;">
            <div class="container" style="float:left; width: 15%;text-align: center;">
                <p class="pr">
                    지
                </p>
            </div>
            <div class="progress rounded-pill" style="height:30px;">
                <div
                    class="progress-bar progress-bar-striped bg-info progress-bar-animated"
                    role="progressbar"
                    style="width: 42%"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    <p class="pr">
                        30/70
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>

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

<?php

$today = date("Y-m-d");
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


  echo $is_morning . $is_lunch . $is_dinner;

?>

<div class="card">
    <div class="card-header">
        아침
    </div>
    <div class="card-body">
    <?php
            if($is_morning==1){
              $morning_kcal =0;
              $morning_car =0;
              $morning_pro =0;
              $morning_fat =0;

            	while($row = $result3->fetch_assoc()) {
                if ($row['eaten_serving']==0){
                     $morning_kcal = $morning_kcal+$row['food_calory']*0.5;
                     $morning_car = $morning_car+$row['food_car']*0.5;
                     $morning_pro = $morning_pro+$row['food_pro']*0.5;
                     $morning_fat = $morning_fat+$row['food_fat']*0.5;
               }
               else{
                     $morning_kcal = $morning_kcal+$row['food_calory']*$row['eaten_serving'];
                     $morning_car = $morning_car+$row['food_car']*$row['eaten_serving'];
                     $morning_pro = $morning_pro+$row['food_pro']*$row['eaten_serving'];
                     $morning_fat = $morning_fat+$row['food_fat']*$row['eaten_serving'];
               }
                if($row['eaten_serving']==0){
                  echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."<br>(0.5 인분)";
          	      echo nl2br("\n\n");
                }
                else{
                  echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."<br>(".$row['eaten_serving']." 인분)";
          	      echo nl2br("\n\n");
               	}
              }
		  }
		  else{

			echo ' <form action="morning_diet.php" method="POST"><input type="number" id="inputKcal" name="inputKcal" size="20"><button>입력</button></form>';


		  }

		  
          ?>

    </div>
</div>

<br><br>
<div class="card">
    <div class="card-header">
        점심
    </div>
    <div class="card-body">
        <p style="width: 100%;">
        <?php
    		if($is_lunch==1){
   			   $lunch_kcal =0;
		      $lunch_car =0;
		      $lunch_pro =0;
		      $lunch_fat =0;
		      while($row = $result4->fetch_assoc()) {
		        if ($row['eaten_serving']==0){
		          $lunch_kcal = $lunch_kcal+$row['food_calory']*0.5;
    		      $lunch_car = $lunch_car+$row['food_car']*0.5;
         		  $lunch_pro = $lunch_pro+$row['food_pro']*0.5;
       				$lunch_fat = $lunch_fat+$row['food_fat']*0.5;
        		}
      			else{
         			$lunch_kcal = $lunch_kcal+$row['food_calory']*$row['eaten_serving'];
         			$lunch_car =  $lunch_car+$row['food_car']*$row['eaten_serving'];
         			$lunch_pro =  $lunch_pro+$row['food_pro']*$row['eaten_serving'];
         			$lunch_fat =  $lunch_fat+$row['food_fat']*$row['eaten_serving'];
         				if($row['eaten_serving']==0){
         				 echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."<br>(0.5 인분)";
	  					echo nl2br("\n\n");
      					}
      			else{
         		 echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."<br>(".$row['eaten_serving']." 인분)";
	  				echo nl2br("\n\n");
     	 			}
    			}
     		 }
		}
		else{
			echo '<form action="lunch_diet.php" method="POST"><input type="number" id="inputKcal" name="inputKcal" size="20"><button>입력</button></form>';
		}
    ?>

        </div>
    </div>
</div>
<br><br>
<div class="card">
    <div class="card-header">
        저녁
    </div>
    <div class="card-body">
        <?php
	        if($is_dinner==1){
				$dinner_kcal =0;
				$dinner_car =0;
				$dinner_pro =0;
				$dinner_fat =0;
				while($row = $result5->fetch_assoc()) {
				  if ($row['eaten_serving']==0){
					$dinner_kcal = $dinner_kcal+$row['food_calory']*0.5;
					$dinner_car = $dinner_car+$row['food_car']*0.5;
					$dinner_pro = $dinner_pro+$row['food_pro']*0.5;
					$dinner_fat = $dinner_fat+$row['food_fat']*0.5;
				 }
				else{
					$dinner_kcal = $dinner_kcal+$row['food_calory']*$row['eaten_serving'];
					$dinner_car =  $dinner_car+$row['food_car']*$row['eaten_serving'];
					$dinner_pro =  $dinner_pro+$row['food_pro']*$row['eaten_serving'];
					$dinner_fat =  $dinner_fat+$row['food_fat']*$row['eaten_serving'];
					if($row['eaten_serving']==0){
					  echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."<br>(0.5 인분)";
				echo nl2br("\n\n");
				  }
				  else{
					  echo $row['food_name'] ."  ". $row['food_calory']*$row['eaten_serving']."  Kcal"."<br>(".$row['eaten_serving']." 인분)";
				echo nl2br("\n\n");
						}
			  		}
				}
			  }
			  else{
				echo '<form action="dinner_diet.php" method="POST"><input type="number" id="inputKcal" name="inputKcal" size="20"><button>입력</button></form>';
	
			  }

		?>
			
    </div>
</div>
<br><br>
<nav class="navbar fixed-bottom navd">
    <a href="index.php">
        <div class="navIcons" style="text-align:center;">
            <br/>
            <i class="navIcon fas fa-home navdi" id="navHome" aria-hidden="true"></i>
            <p class="navName navdp">
                Home
            </p>
        </div>
    </a>
    <a href="recommend.php">
        <div class="navIcons" style="text-align:center;">
            <br/>
            <i class="navIcon fas fa-utensils navdi" id="navDiet" aria-hidden="true"></i>
            <p class="navName navdp">
                Diet
            </p>
        </div>
    </a>
    <a href="miband.php">
        <div class="navIcons" style="text-align:center;">
            <br/>
            <i class="navIcon fas fa-heartbeat navdi" id="navMiband" aria-hidden="true"></i>
            <p class="navName navdp">
                Miband
            </p>
        </div>
    </a>
    <a href="static.php">
        <div class="navIcons" style="text-align:center;">
            <br/>
            <i class="navIcon far fa-chart-bar navdi" id="navChart" aria-hidden="true"></i>
            <p class="navName navdp">
                Chart
            </p>
        </div>
    </a>
</nav>
</body>
</html>
