<?php

	require_once("./dbconn.php");

  $gender = $_POST['inputGender'];
  $age = $_POST['inputAge'];
  $weight = $_POST['inputWeight'];
  $height = $_POST['inputHeight'];
  $exercise = $_POST['inputExercise'];
  $miscale = $_POST['inputMiscale'];
  $kcal = $_POST['inputCalory'];


  $user_code = abc; # 1번 가져왔다고 가정

  if($exercise==1.12) $exercise=2;
  else if($exercise==1.25) $exercise=3;
  else if($exercise==1.45) $exercise=4;

  $sql = "INSERT INTO user(user_code,user_gender,user_age,user_height,user_weight,user_goal,user_check_inbody,user_check_exercise) values ('$user_code','$user_gender','$user_age','$user_height','$user_weight','$kcal','$miscale','$exercise')";
  $signup = mysqli_query($conn,$sql);

  $sql1 = "SELECT * FROM user WHERE user_id='$user_id'";
  $result1 = $conn->query($sql1);

  if ($result1->num_rows > 0) { // 여러줄 가져오는 경우

    while($row1 = $result1->fetch_assoc()) {
      $_SESSION['user_id']=$row1['user_id'];
    }
  } else {
    echo "유저 접속 오류";
  }

	$conn->close();

  if($isset($_SESSION['user_id']))
  {
    header('Location:./index.php');
  }


?>
