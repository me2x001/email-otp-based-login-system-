<?php
if(!isset($_SERVER['HTTP_REFERER'])){
  header('location:error');
  exit;
}
  session_start();
  $user = $_SESSION["user"];
  if($user == true){
    $_SESSION["value"] = 1;
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Main</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link href="https://fonts.googleapis.com/css?family=Oxygen:700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="images/favicon.png" type="image">
</head>
<body>

  <div class="login-box1">
    <div class="lb-header">
            <a  class = "active" >Email/Mobile Based OTP Login System</a> 
    </div>
    <div class="u-form-group2">    
          <a>&nbsp;&nbsp;&nbsp;&nbsp;Hello, <?php echo $user; ?></a><button id="login-otp" onClick="window.location='logout.php';">Log out</button><br><br>
    <div>
    <center><h2>One Time Password (OTP) based login System</h2></center>
    <center><img src="images/otp.jpg"></center>
        <h3>What is OTP ?</h3>
        <p>A one-time password (OTP) is an automatically generated numeric or alphanumeric
        string of characters that authenticates the user for a single transaction or login session.
        An OTP is more secure than a static password, especially a user-created password, which
        can be weak or reused across multiple accounts. OTP’s may replace authentication login
        information or may be used in addition to it in order to add another layer of security.</p>
        <h3>What is OTP System ?</h3>
        <p>An OTP or One Time Password System is a concept to prevent spam and Unwanted hack on website and Mobile App. 
        It helps individual users to make secured their data online on any OTP integrated website. 
        ONE TIME PASSWORD is an automatically generated numeric or alphanumeric strings which helps in authentication of a single transaction or session of particular user. 
        The number changes in a timely manner, depending on how it is configured in coding / Program.</p>
        <h3>How OTP System Works ?</h3>
        <p>OTP always works according it’s program or coding. It depends on website requirement and how that website want to integrate it to authenticate sessions or transactions of their users. 
        It can be used in Registration or Login system of Customer Panel. Most of popular website using OTP system for 
        Login and Registration of User / Customers. And Many other websites are using OTP for payment transactions and 
        other important or confidentials sessions, which helps them to prevent user sessions with unwanted hacks.</p>
        <h3>Mobile Based OTP System</h3>
        <p>When we use a Mobile SMS gateway to authenticates users or send One Time Password to Users via TEXT SMS on their mobile.
         It called Mobile based OTP System. For Mobile based OTP system you have to Buy Bulk SMS Service from SMS Service Provider. 
         Which will cost you an amount, so this is li’l bit costly for startups.</p>
        <h3>Email Based OTP system</h3>
        <p>Email is best way to send any information, but in case of OTP i will recommend you to use Mobile Based or SMS based OTP System.
         But if you don’t have a budget to buy a BULK SMS Service, so you can send your otp via Email to your users for authentication 
         of any session or transaction.</p>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
<?php
  }else{
    header("location:login.php");
  }
?>
</html>