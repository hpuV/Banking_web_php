<?php

include('connect.php');

session_start();

//黃金存摺 帳戶資料
$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$goldacc = $_SESSION["goldacc"];

$sqlacc = "SELECT * FROM golddata WHERE m_gold = '".$goldacc."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 黃金存摺</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/goldcenterstyle.css" rel="stylesheet" type="text/css">
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
	<div class="bg-style1">
		<h2>黃金存摺</h2>
	    <div class="content"><h3>暱稱</h3></div>
		<div class="value"><h4><?php echo $nick; ?></h4></div>
	    <div class="content"><h3>黃金帳戶</h3></div>
		<div class="value"><h4><?php echo $goldacc; ?></h4></div>
		<div class="content"><h3>持有數量(單位: 公克)</h3></div>
		<div class="value"><h4><?php echo $row_acc['m_goldnum']; ?></h4></div>
		<div class="box"></div>
		<a href="goldtrade.php?"><input type="button" value="黃金交易" class= "btn"></a>
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