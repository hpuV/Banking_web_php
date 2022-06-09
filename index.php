<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: mainpage.php");
    exit;  //記得要跳出來，不然會重複轉址過多次
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ATBC Banking</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/loginpagestyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form method="post" action="login.php">
<div class="container">
  <section>
    <article class="left_article">
	  <div class="bg-style1" href="#">
   	    <h1>Banking</h1>
		  <h2 class="lbl1">Account</h2>
		  <input type="text" name="username" class="txt">
		  <h2 class="lbl2">Password</h2>
		  <input name="password" type="password" class="pass">
		  <input type="submit" value="Login" name="submit" class="btn">
		  <p class="leftp"><a href="register.php" class="lbl-link">No account? Sign up!</a></p>
		  <div class="testacc">
			<p class="rightp"><a class="testacc-link">Test Account Infomation</a></p>
			<div class="clearfix"></div>
			<div class="testaccfield">
				<h1 class="val">Account:</h1>
				<h2 class="con">testacc</h2>
				<div class="clearfix"></div>
				<h1 class="val">Password:</h1>
				<h2 class="con">testacc</h2>
				<div class="clearfix"></div>
			</div>
		 </div>
       </div>
    </article>
	</section>
</form>
	<div class="clearfix"></div>
  <footer class="secondary_header footer">
    <div class="copyright">&copy;<strong>Chin-An Liu</strong></div>
  </footer>
	<div class="content-box"></div>
</div>
</body>
</html>