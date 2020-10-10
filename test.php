<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <link rel="stylesheet" href="/resource/css/bootstrap.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- 폰트 -->
  <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Do+Hyeon&display=swap" rel="stylesheet">
  <script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <meta charset="utf-8">



  <style type="text/css">

    #container {width: 960px; margin: 0 auto;}
    #container #input-form {text-align: center;}
    #user-table {margin: 0 auto; text-align: center;}
    #input-form {margin-top: 10px; margin-bottom: 10px;}

    #user-table {border-collapse: collapse;}
    #user-table > thead > tr { background-color: #333; color:#fff; }
    #user-table > thead > tr > th { padding: 8px; width: 150px; }
    #user-table > tbody > tr > td { border-bottom: 1px solid gray; padding:8px; }

  </style>

  <script type="text/javascript">

    $(document).ready(function() {
      $("#keyword").keyup(function() {
        var k = $(this).val();
        $("#user-table > tbody > tr").hide();
        var temp = $("#user-table > tbody > tr > td:nth-child(5n+2):contains('" + k + "')");

        $(temp).parent().show();
      })
    })
  </script>


</head>



<body>

  <div id="container">
    <form action = updateeatenfood.php>
      <div id="input-form">
        이름 : <input type="text" id="keyword" name="food_id" />
      </div>
      <button type="submit"> 확인 </button>

      <table id="user-table">
        <thead>
          <tr>
            <th>음식번호</th>
            <th>음식이름</th>
            <th>탄수화물</th>
            <th>단백질</th>
            <th>지방</th>
            <th>칼로리</th>
          </tr>
        </thead>

        <tbody>
          <?php
          header('Content-Type:text/html; charset=UTF-8');
          $user_id=1;
          $jb_conn = mysqli_connect( 'localhost', 'root', 'toor', 'smartpt' );
          $jb_sql = "SELECT * FROM foodinfo Where user_id='$user_id';";
          $jb_result = mysqli_query( $jb_conn, $jb_sql );

          while( $jb_row = mysqli_fetch_array( $jb_result ) ) {
          echo '<tr><td>' . $jb_row[ 'food_id' ] . '</td><td>'. $jb_row[ 'food_name' ] . '</td><td>' . $jb_row[ 'food_car' ] . '</td><td>'. $jb_row[ 'food_fat' ] .'</td><td>'. $jb_row[ 'food_pro' ] .'</td><td>'. $jb_row[ 'food_calory' ] .'</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </form>




</body>
</html>
