<?php

include('connect.php');

session_start();

$sqlcompanyid = "SELECT * FROM stockdata ORDER BY s_id ASC;";
$resultsid = mysqli_query($db_link,$sqlcompanyid);

function get_Stock_price(){
  $url =
  "https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch=tse_2330.tw&";
  $data = file_get_contents($url);
  $data = json_decode($data,true);
  echo $data['msgArray'][0]['z'];
  
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ATBC Banking - 股票價格</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/stockpricestyle.css" rel="stylesheet" type="text/css">
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
		<div class="clearfix"></div>
	   	<table>
        <tr>
          <th class="title">臺股代號</th>
          <th class="title">公司名稱</th>
          <th class="title">股票成交價</th>
          <th class="title">更新時間</th>
        </tr>
        <?php
          for($i=1; $i <= mysqli_num_rows($resultsid); $i++){
            $rs = mysqli_fetch_row($resultsid);
        ?>
        <tr>
          <td><?php echo $rs[1] ?></td>
          <td><?php echo $rs[2] ?></td>
          <td><?php echo $rs[3] ?></td>
          <td><?php echo $rs[4] ?></td>
        </tr>
        <?php
          }
        ?>
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