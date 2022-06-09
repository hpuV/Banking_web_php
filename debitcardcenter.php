<?php

include('connect.php');

session_start();

$account = $_SESSION["account"];
$sql = "SELECT * FROM debitcarddata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
$row_Login = mysqli_fetch_assoc($result);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content..="chrome=1">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 卡片資訊</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/debitcardcenterstyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body>
<div class="container">
  <header>
	 <nav class="primary_header" id="menu">
      <ul class="drop-down-title">
		<h1 class="h1title">Banking</h1>
	  </ul>
      <ul class="drop-down-menu">
        <li><img src="img/menuicon.png">
        	<ul>
            <li><a href="mainpage.php">首頁</a>
            </li>
            <li><a href="goldprice.php">黃金價格</a>
            </li>
            <li><a href="stockprice.php">股票價格</a>
            </li>
            <li><a href="userdeter.php">會員中心</a>
            </li>
            <li><a href="statementsearch.php">收支查詢</a>
            </li>
            <li><a href="logout.php">登出</a>
            </li>
       		</ul>
       </li>
      </ul>
    </nav>
  </header>
  <section>
	<div class="top-box"></div>
    <aside class="right_article">
	<img src="img/creditcard.png" class="credit">
	<div class="bg-style1">
		<h2>卡片資訊</h2>
    <div class="value"><h3><?php echo $row_Login['m_account']; ?></h3></div>
	  <div class="content"><h4>連結主帳號</h4></div>
		<div class="value"><h3><?php echo $row_Login['m_cardid']; ?></h3></div>
	  <div class="content"><h4>金融卡卡號</h4></div>
		<div class="value"><h3><?php echo $row_Login['m_expdate']; ?></h3></div>
	  <div class="content"><h4>有效日期</h4></div>
		<div class="value"><h3><?php echo $row_Login['m_safecode']; ?></h3></div>
	  <div class="content"><h4>安全碼</h4></div>
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
<?php
  }else{
     echo "非法登入!";
     exit();
}
?>