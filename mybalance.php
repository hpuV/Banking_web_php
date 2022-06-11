<?php

include('connect.php');

session_start();

$username = $_SESSION["username"];
$levelNum = $_SESSION["level"];
$account = $_SESSION["account"];

$sql = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
$row_Login = mysqli_fetch_assoc($result);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  $balance = $row_Login["m_balance"];
  $balance = number_format($balance);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 臺幣存款</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/mybalancestyle.css" rel="stylesheet" type="text/css">
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
    <div class="clearfix"></div>
  </header>
  <section>
	<div class="top-box"></div>
	<div class="left_article">
		<h3 class="first"><a class="nav-info" href="twdtransfer.php">臺幣轉帳</a></h3>
        <h3 class="second"><a class="nav-info" href="debitcardcenter.php">金融卡管理</a></h3>  
	</div>
	<div class="clearfix"></div>
    <aside class="right_article">
	<div class="bg-style1">
		<h2>我的臺幣</h2>
		<div class="value"><h3><?php echo $account; ?></h3></div>
	    <div class="content"><h4>銀行帳戶</h4></div>
		<div class="value"><h3><?php echo $balance; ?></h3></div>
	    <div class="content"><h4>臺幣帳戶餘額</h4></div>
		<hr>
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