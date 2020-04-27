<?php
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location:error');
  exit;
}
session_start();
$error=NULL;
$sucess=0;
if(isset($_POST['submit_otp'])){
  //connect to database
  $mysqli = NEW MySQLi('Address','Username','Password','DB name');  //Change these database credentials with yours
  
  //collect generated otp, user name
  $generated_otp = $_POST['otp'];

  //Validate OTP 
  $result=$mysqli->query("SELECT * FROM otp WHERE otp = '$generated_otp' AND is_expired!=1 AND NOW() <= DATE_ADD(created_at, INTERVAL 1 MINUTE)");
  if($result->num_rows == 1){
    $result=$mysqli->query("UPDATE otp SET is_expired = 1 WHERE otp = '$generated_otp'");
    if($result){
      $sucess=1;
    }
  }else{
    $error="Invalid OTP";
  }
}
if($_SESSION["value"]==0){
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

  <div class="login-box">
    <div class="lb-header">
      <a class="active" id="login-box-link">Login</a>
    </div>
    <form class="otp-login" method = "POST" name="otplogin">
    <?php
        echo "Hello ".$_SESSION["user"].", Please enter your OTP.";
    ?>
      <div class="u-form-group">
        <br><br><input type="text" name="otp" placeholder="OTP" required/>
      </div>
      <div class="u-form-group">
        <button type="SUBMIT" name="submit_otp">Proceed</button>
      </div>
      <?php
        echo $error;
      ?>
    </form>
    <?php
      if($sucess==1){
        header('location:main.php');
      }
    ?> 
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
<?php
  }else{
    header("location:main.php");
  }
?>
</html>