<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'mail/Exception.php';
  require 'mail/PHPMailer.php';
  require 'mail/SMTP.php'; 
  $error = NULL;

  if(isset($_POST['submit'])){
    //Get form data
    $uname = $_POST['uname'];
    $mno = $_POST['mno'];
    $email = $_POST['email'];

    if(strlen($uname)<5){
      $error = "Username must be atleast 5 Characters";
    }else if(!is_numeric($mno)){
      $error = "Please enter Valid Mobile Number";
    }else if($mno < 1000000000 or $mno > 9999999999){
      $error = "Please enter Valid Mobile Number";
    }else{
      //Form is valid

      //Connect to database
      $mysqli = NEW MySQLi('Address','Username','Password','DB Name'); //Change these database credentials with yours

      //Sanitize Form Data
      $uname = $mysqli->real_escape_string($uname);
      $mno = $mysqli->real_escape_string($mno);
      $email = $mysqli->real_escape_string($email);

      //Generate VKey
      $vkey = md5(time().$uname);
      
      //Insert Account into Database
      $insert = $mysqli->query("INSERT INTO users(username,mobileno,email,vkey)VALUES('$uname','$mno','$email','$vkey')");
      if($insert){
        //Send email
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
        $mail->Subject = 'Email Verification';
        $mail->msgHTML("
        <p>Hi ".$_POST['uname'].",</p>
        <p>Thanks for Registering with us, You are one step away to activate your account.</p>
        <a href='http://localhost/project/verify.php?vkey=$vkey'>Click here to activate</a>
        <p>Best Regards,<br />Project X</p>
        ");
        if($mail->send() == true){
          header('location:thankyou.php');
        }else{
          $error = "Mailer Error";
        }
      }else{
        $error=$mysqli->error;
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

  <div class="login-box">
    <div class="lb-header">
      <a class="active" id="signup-box-link">Sign Up</a>
    </div>
    <form class="email-signup" method="POST" id="signup">
     <div class="u-form-group">
        <input type="text" name="uname" placeholder="Username" required/>
      </div>
      <div class="u-form-group">
        <input type="mobileno" name="mno" placeholder="Mobile No" required/>
      </div>
      <div class="u-form-group">
        <input type="email" name="email" placeholder="Email" required/>
      </div>
      <div class="u-form-group">
        <button type="SUBMIT" name="submit">Sign Up</button>
      </div>
      <div class="u-form-group">
      <center><p> Already Registered ? <a style="text-decoration:none" href="login.php" class="forgot-password">Login</a></p></center>
      </div>
    </form>
    <center>
    <?php
        echo $error;
    ?>
    </center>
  </div>

</body>
</html>