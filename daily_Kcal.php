<?php
  require_once("./dbconn.php");
  $user_id = 1; # 1번 가져왔다고 가정

  $i=0;
  $dailyKcal=array(); // 일별 섭취 칼로리
  $today = date("Y-m-d");

  $start = strtotime("-3 days");
  $end = strtotime("+3 days");
  $start = date('Y-m-d',$start);
  $end = date('Y-m-d',$end);

  // 오늘 기준 플마 3일
  $sql1 = "SELECT * FROM eatenfood WHERE user_id='$user_id' and eaten_day>='$start' and eaten_day<='$end' ORDER BY eaten_day";
  $result1 = $conn->query($sql1);

  if ($result1->num_rows > 0) { // 여러줄 가져오는 경우
    while($row = $result1->fetch_assoc())
    {
          $dailyKcal[$i]=$row;
          $i++;
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta charset="utf-8">
  <script src="./js/daily_kcalgraph.js"></script>
</head>
<body>
  <div id="test">
    <?php
      echo json_encode($dailyKcal);
    ?>
  </div>
</body>
</html>
