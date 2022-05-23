<?php

include('connect.php');

session_start();

$username = $_SESSION["username"];
$levelNum = $_SESSION["level"];
$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];

$sqlmember = "SELECT * FROM memberdata WHERE m_account = '".$account."' ";
$sqlfinance = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$m_result = mysqli_query($db_link,$sqlmember);
$f_result = mysqli_query($db_link,$sqlfinance);
$m_row_Login = mysqli_fetch_assoc($m_result);
$f_row_Login = mysqli_fetch_assoc($f_result);

$_SESSION["goldacc"] = $f_row_Login['m_gold'];
$_SESSION["stockacc"] = $f_row_Login['m_stock'];

$levelString = array("無","用戶","管理者");

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
   $balance = $f_row_Login["m_balance"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>首頁</title>
<link href="css/mainpagestyle.css" rel="stylesheet" type="text/css">
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
  <section>
  <h1 class="noDisplay">Main Content</h1>
    <article class="left_article">
      <h2>您好，<?php echo $nick; ?></h2>
	  <div class="bg-style1">
   	    <h3 class="h3row1">臺幣存款</h3>
		  <h5><a class="lbl-link" href="mybalance.php">資產總額</a></h5>
		  <p><?php echo $balance; ?></p>
       </div>
	   <div class="bg-style1">
       		<h3 class="h3row2"><a class="lbl-link" href="debitcardcenter.php">金融卡</a></h3>
      </div>
		<div class="bg-style1">
   	    <h3 class="h3row3"><a class="lbl-link" href="goldcenter.php">黃金存摺</a></h3>
       </div>
	   <div class="bg-style1">
		   <h3 class="h3row4"><a class="lbl-link" href="stockcenter.php">股票</a></h3>
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
<?php
  }else{
     echo "非法登入!";
     exit();
}
?>
