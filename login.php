<?php
session_start();
$error=NULL;
date_default_timezone_set("Asia/Kolkata");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

//OTP Generation for email

if(isset($_POST['submit'])){
  //Get form Data
  $email = $_POST['email'];

  //Connect to Database
  $mysqli = NEW MySQLi('Address','Username','Password','DB Name'); //Change these database credentials with yours
  
  //Sanitize Data
  $email = $mysqli->real_escape_string($email);

  $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
  if($result->num_rows == 1){
    //Collect data from database
    $row = $result->fetch_assoc();
    $uname = $row['username'];
    $verified = $row['verified'];
    $date = $row['createdate'];
    $date = strtotime($date);
    $date = date('d M Y',$date);

    if($verified == 1){
      //Generate OTP
      $otp = rand(100000,999999);
     
      //Send OTP to Email
      //configure this accordingly
      $mail = new PHPMailer(true);
      $mail->isSMTP(); 
      $mail->SMTPDebug = 0;
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587;
      $mail->SMTPSecure = 'tls';
      $mail->SMTPAuth = true;
      $mail->Username = 'example@mail.com'; //Change these with yours
      $mail->Password = 'password'; //Change these with yours
      $mail->setFrom('example@mail.com', 'Name'); //Change these with yours
      $mail->addAddress($email, $uname);
      $mail->Subject = 'OTP to Login';
      $mail->msgHTML("
                      <p>Hello ".$uname.", Your OTP to Login is : ".$otp." This OTP is valid only for 1 minute.Best Regards,<br />Project X</p>
                     ");
      if($mail->send() == true){
        $date = date('Y-m-d H:i:s');
        $result=$mysqli->query("INSERT INTO otp(otp,is_expired,created_at) VALUES('$otp',0,'$date')");
        if($result){
          $_SESSION["user"]=$uname;
          $_SESSION["value"] = 0;
          header('location:otplogin.php');
        }
      }else{
        $error = "Mailer Error";
      } 
    }else{
      $error = "This account has not yet been verified. An email was sent to $email on $date.";
    }
  }else{
    $error = "Email does not exist.";
  }
} 

//OTP Generation for mobile 

if(isset($_POST['msubmit'])){
  require('textlocal.class.php');

  //connect to database
  $mysqli = NEW MySQLi('Address','Username','Password','DB Name'); //Change these database credentials with yours

  //Get form Data
  $mobileno = $_POST['mobileno'];

  //Sanitize Data
  $mobileno = $mysqli->real_escape_string($mobileno);

  $result = $mysqli->query("SELECT * FROM users WHERE mobileno = '$mobileno'");
  if($result->num_rows == 1){
    //Collect data from database
    $row = $result->fetch_assoc();
    $uname = $row['username'];
    $email = $row['email'];
    $verified = $row['verified'];
    $date = $row['createdate'];
    $date = strtotime($date);
    $date = date('d M Y',$date);
  
    if($verified == 1){

      $textlocal = new Textlocal(false, false, 'hOJGfFgdZaw-9TaRQmwcUHNaq4tSnBUa24gua1ioQS');

      $numbers = array($_POST['mobileno']);
      $sender = 'TXTLCL';

      //Generate OTP
      $otp = rand(100000, 999999);

      $message = "Hello " . $uname . ", Your OTP to login is " . $otp . " This OTP is valid only for 1 minute."; 

      try {
          $message_status = $textlocal->sendSms($numbers, $message, $sender);
          if($message_status == 1){
            $date = date('Y-m-d H:i:s');
            $result=$mysqli->query("INSERT INTO otp(otp,is_expired,created_at) VALUES('$otp',0,'$date')");
            if($result){
              $_SESSION["user"]=$uname; 
              $_SESSION["value"] = 0; 
              header("location:otplogin.php");
            }
          }
      } catch (Exception $e) {
          $error = $e->getMessage();
      }
    }else{
      $error = "This account has not yet been verified. An email was sent to $email on $date.";
    }
  }else{
    $error = "Mobile Number does not exist.";
  }
}
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
    <form class="email-login" method = "POST" name="emaillogin" id="emaillogin">
      <div class="u-form-group1">
        <input type="email" placeholder="Email" name = "email" required/><button type="SUBMIT" name = "submit" >Log in</button>
      </div>
    </form>
    <form class="email-login" method = "POST" name = "mobilelogin" id = "mobilelogin">
      <div class="u-form-group1">
        <input type="text" placeholder="Mobile No" name = "mobileno" required/><button type="SUBMIT" name = "msubmit">Log in</button>
      </div>
      <div class="u-form-group">
        <center><p> Dont have an account? <a style="text-decoration:none" href="register.php">Sign up</a></p></center>
      </div>
      <center>
        <?php
          echo $error;
        ?>
      </center>
    </form>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>