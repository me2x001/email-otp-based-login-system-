<?php
  if(!isset($_SERVER['HTTP_REFERER'])){
    header('location:error');
    exit;
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
      <a class="active" id="login-box-link">Thank You</a>
    </div>
    <center>
    <br><br><img src="images/email.png">
    <p><b>Thanks for Registering with us please check your email to activate your account.</b></p>
    </center>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>