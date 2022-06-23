<?php

include('connect.php');

session_start();

//個人股票 帳戶資料
$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$stockacc = $_SESSION["stockacc"];

$sqlacc = "SELECT * FROM personalstockdata WHERE m_stock = '".$stockacc."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content..="chrome=1">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 個人股倉</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/stockcenterstyle.css" rel="stylesheet" type="text/css">
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
  <aside class="right_article">
	<div class="bg-style1">
		<h2>個人股倉</h2>
	    <div class="content"><h3>暱稱</h3></div>
		<div class="value"><h4><?php echo $nick; ?></h4></div>
	    <div class="content"><h3>持股編號</h3></div>
		<div class="value"><h4><?php echo $stockacc; ?></h4></div>
		<div class="box"></div>
		<a href="stocktrade.php"><input type="submit" value="股票交易" class= "btn"></a>
    <?php
        $queryString = "SELECT * FROM personalstockdata WHERE m_stock = '".$stockacc."'  ORDER BY p_id ASC";
        $result = mysqli_query($db_link,$queryString);
    ?>
		<table>
			<tr>
				<th class="title">臺股代號</th>
				<th class="title">公司名稱</th>
				<th class="title">持有股數</th>
			</tr>
      <?php
          for($i=1; $i <= mysqli_num_rows($result); $i++){
              $rs = mysqli_fetch_row($result);
      ?>
			<tr>
				<td><?php echo $rs[3]?></td>
				<td><?php echo $rs[4]?></td>
				<td><?php echo $rs[5]?></td>
			</tr>
      <?php
          }
          if (mysqli_num_rows($result) <= 0) {
              echo "<script>alert('搜尋不到任何符合條件的紀錄')</script>";
          }
      ?>
		</table>
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