<?php

include('connect.php');

session_start();

//黃金價格
//獲取價格
$sqlgold = "SELECT * FROM goldpricedata ";
$resultgold = mysqli_query($db_link,$sqlgold);
$row_gold = mysqli_fetch_assoc($resultgold);
$stockprice = $row_gold['g_price'];
$updatetime = $row_gold['g_date'];

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
<link href="css/mainpagestyle.css" rel="stylesheet" type="text/css">
<link href="css/goldpricestyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <header>
    <nav class="secondary_header" id="menu">
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
  <div class="top-box"></div>
  <section>
    <article class="left_article">
	  <div class="bg-style1" href="#">
		<h2>掛牌時間:</h2>
		<h2 class="lefth2"><?php echo $updatetime; ?></h2>
		<div class="clearfix"></div>
	   	<table>
			<tr>
				<td rowspan="2" class="top">品名/規格</td>
				<td class="top">單位: 新臺幣元</td>
			</tr>
			<tr>
				<td class="top">1公克</td>
			</tr>
			<tr>
				<td rowspan="2">黃金存摺</td>
				<td>賣出價格</td>
			</tr>
			<tr>
				<td><?php echo $stockprice; ?></td>
			</tr>
		</table>
       </div>
    </article>
	</section>
	<div class="clearfix"></div>
  	<div class="content-box"></div>
  <footer class="secondary_header footer">
    <div class="copyright">Copyright &copy;<strong> Chin-An Liu.</strong> All rights reserved.</div>
  </footer>
</div>
</body>
</html>