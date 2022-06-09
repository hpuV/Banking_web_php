<?php

include('connect.php');

session_start();

$username = $_SESSION["username"];
$levelNum = $_SESSION["level"];
$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];

$sql = "SELECT * FROM memberdata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
 $row_Login = mysqli_fetch_assoc($result);

$levelString = array("無","用戶","管理者");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/usercenterpagestyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body>
<div class="container">
  <header>
	 <nav class="primary_header" id="menu">
      <ul>
	  	<a class="h1title">Banking</a>
        <li><a class="nav-link" href="mainpage.php">首頁</a></li>
        <li><a class="nav-link" href="goldprice.php">黃金價格</a></li>
        <li><a class="nav-link" href="stockprice.php">股票價格</a></li>
        <li><a class="nav-link" href="userdeter.php">會員中心</a></li>
        <li><a class="nav-link" href="statementsearch.php">收支查詢</a></li>
		<li><a class="nav-link" href="logout.php">登出</a></li>
      </ul>
    </nav>
  </header>
  <section>
	<div class="top-box"></div>
	<article class="left_article">
		<h3 class="toph3"><a class="nav-info" href="usercenter.php">個人資料</a></h3>
        <h3><a class="nav-info" href="editacc.php">變更資料</a></h3>
        <h3><a class="nav-info" href="editpwd.php">更改密碼</a></h3>
	</article>
    <aside class="right_article">
	<div class="bg-style1">
	<h2>帳戶資料</h2>
		<div class="value"><h3><?php echo $account; ?></h3></div>
	    <div class="content"><h4>銀行帳戶</h4></div>
		<div class="value"><h3><?php echo $username; ?></h3></div>
	    <div class="content"><h4>使用者代號</h4></div>
		<div class="value"><h3>********</h3></div>
	    <div class="content"><h4>密碼</h4></div>
		<div class="value"><h3><?php echo $levelString[$levelNum]; ?></h3></div>
	    <div class="content"><h4>會員等級</h4></div>
		<hr>
		<h2>詳細資料</h2>
		<div class="value"><h3><?php echo $_SESSION['nickname']; ?></h3></div>
	    <div class="content"><h4>暱稱</h4></div>
		<div class="value"><h3><?php echo  $row_Login["m_gender"]; ?></h3></div>
	    <div class="content"><h4>性別</h4></div>
		<div class="value"><h3><?php echo  $row_Login["m_birthday"]; ?></h3></div>
	    <div class="content"><h4>出生日期</h4></div>
		<div class="value"><h3><?php echo  $row_Login["m_email"]; ?></h3></div>
	    <div class="content"><h4>電子郵件</h4></div>
		<div class="value"><h3><?php echo  $row_Login["m_phone"]; ?></h3></div>
	    <div class="content"><h4>行動電話</h4></div>
		<div class="value"><h3><?php echo  $row_Login["m_address"]; ?></h3></div>
	    <div class="content"><h4>居住地址</h4></div>
     </div>
	 <div class="clearfix"></div>
  	 <div class="content-box"></div>
    </aside>
	</section>
  <footer class="tertiary_header footer">
    <div class="copyright">Copyright &copy;<strong> Chin-An Liu.</strong> All rights reserved.</div>
  </footer>
</div>
</body>
</html>