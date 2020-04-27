<?php
$error = "";
if(isset($_GET['vkey'])){
  //Process Verification
  $vkey = $_GET['vkey'];
  $mysqli = NEW MySQLi('Address','Username','Password','DB name');  //Change these database credentials with yours

  $result_set = $mysqli->query("SELECT verified,vkey FROM users WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");
  if($result_set->num_rows == 1){
    //Validate Email
    $update = $mysqli->query("UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
    if(!$update){
      $error = $mysqli->error;
    }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Log in</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

  <div class="login-box">
    <div class="lb-header">
      <a class="active" id="login-box-link">Activated</a>
    </div>
    <center>
    <br><br><img src="images/success.png">
    <p><b>Sucessfully Verified!!</b></p>
    <div class="u-form-group">
        <button id="login-otp" onClick="window.location='login.php';" >Log in</button><br><br>
    </div>
    </center>
    <center>
    <?php
      echo $error;
      }else{
    ?>
    </center>
    <head>
  <meta charset="UTF-8">
  <title>Log in</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
  </head>
  </div>
  <div class="login-box">
    <div class="lb-header">
      <a class="active" id="login-box-link">Invalid</a>
    </div>
    <center>
    <br><br><img src="images/invalid.png">
    <br><br><br><p><b>Invalid !!</b></p>
    <p>This Account is Already Verified or Invalid.</p>
    </center>
    <center>
    <?php
      echo $error;
      }
    }else{
      header('location:error.html');
    }
    ?>
    </center>

  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>