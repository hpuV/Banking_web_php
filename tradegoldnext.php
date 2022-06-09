<?php
include('connect.php');

session_start();

$account = $_SESSION["account"];
$sqlmax = "SELECT MAX(st_id) FROM statementdata";
$resultmax = mysqli_query($db_link,$sqlmax);
$row_max = mysqli_fetch_row($resultmax);
$id = $row_max['0'];

$sqlout = "SELECT * FROM statementdata WHERE st_id = '".$id."' ";
$resultout = mysqli_query($db_link,$sqlout);
$row_accout = mysqli_fetch_assoc($resultout);

$sqlacc = "SELECT * FROM financedata WHERE m_account = '".$row_accout['m_account']."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);
$accgold = $row_acc['m_gold'];

$sqlgold = "SELECT * FROM golddata WHERE m_gold = '".$accgold."' ";
$resultgold = mysqli_query($db_link,$sqlgold);
$row_gold = mysqli_fetch_assoc($resultgold);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Banking</title>
<link href="css/tradesuccessstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <section>
    <article class="left_article">
	  <div class="bg-style2" href="#">
   	    <h1>Banking</h1>
		  <h2 class="lbl3 h2goldt">✔ <?php echo $row_accout['st_tradetype']; ?>成功</h2>
		  <h2 class="lbl1top h2gold">黃金存摺</h2>
		  <h3 class="lbl2 h3gold"><?php echo $accgold; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1 h2gold">黃金數量</h2>
		  <h3 class="lbl2 h3gold"><?php echo $row_gold['m_goldnum']; ?></h3>
		  <h4></h4>
		  <hr class="hrgold">
		  <h2 class="lbl1 h2gold">交易日期</h2>
		  <h3 class="lbl2 h3gold"><?php echo $row_accout['st_tradetime']; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1 h2gold">交易明細</h2>
		  <h3 class="lbl2 h3gold"><?php echo $row_accout['st_tradenote']; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1 h2gold">臺幣餘額</h2>
		  <h3 class="lbl2 h3gold"><?php echo $row_accout['m_balance']; ?></h3>
		  <h4></h4>
		  <a href="mainpage.php"><input type="button" value="確認" class="btn goldbtn"></a>
       </div>
    </article>
	</section>
	<div class="clearfix"></div>
  	
  <footer class="secondary_header footer">
    <div class="copyright">&copy;<strong>Chin-An Liu</strong></div>
  </footer>
	<div class="content-box"></div>
</div>
</body>
</html>