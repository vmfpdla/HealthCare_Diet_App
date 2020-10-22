<!DOCTYPE html>
<html>

<head>
  
 

  <link rel="stylesheet" href="./css/jaehyun.css">


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css">
  <link rel="stylesheet" href="/resource/css/bootstrap.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <meta charset="utf-8">
	 <script src="./js/nav.js"></script>

</head>

<body>
  <nav class="navbar fixed-top">
    <p class="navp">Smart PT</p>
    <a href="userInsert3.html"><i class="fa fa-user-circle navi"></i></a>
  </nav>
  <br><br><br>
  <div class="card">
    <div class="card-header">
      오늘의 운동
    </div>
    <div class="card-body">
      <div class="container">
        <div style="height:100px; text-align:center;">
          <div>
            <i class="fas fa-walking mifi"></i>
            <p class="mif">걷기</p>
            <p> 3분 / 150 Kcal </p>
          </div>
          <div>
            <i class="fas fa-swimmer mifi"></i>
            <p class="mif">수영</p>
            <p> 2분 / 130 Kcal </p>
          </div>
          <div>
            <i class="fas fa-biking mifi"></i>
            <p class="mif">자전거</p>
            <p> 2분 / 130 Kcal </p>
          </div>
          <div>
            <i class="fas fa-swimmer mifi"></i>
            <p class="mif">줄넘기</p>
            <p> 2분 / 130 Kcal </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container" style="margin:5% 0 0 15%;">
    <div class="progress rounded-pill" style="height:40px; float:left; width: 80%; margin-top:1%;">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
        <p class="pr"> 800/1400 Kcal</p>
      </div>
    </div>

  </div>

  <div id="notification_div" style="position:absolute; right:10%; width:150px;">
    <i class="fas fa-exclamation-circle misi"></i>
    <p style="font-size:15px;">총 278 Kcal 초과</p>
  </div>

  <br><br>

  <div class="card">
    <div class="card-header">
      추천 운동
    </div>
    <div class="card-body">
      <div class="container">
        <div style="height:600px; text-align:center;">
          <div id="exercise">
            <h3 class="mip">걷기</h3>
            <p class="mipp"> 70 분 / 278 Kcal</p>
          </div>
          <div id="exercise">
            <h3 class="mip">수영</h3>
            <p class="mipp"> 70 분 / 278 Kcal</p>
          </div>
          <div id="exercise">
            <h3 class="mip">자전거</h3>
            <p class="mipp"> 70 분 / 278 Kcal</p>
          </div>
          <div id="exercise">
            <h3 class="mip">줄넘기</h3>
            <p class="mipp"> 70 분 / 278 Kcal</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <br /><br /><br />
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
