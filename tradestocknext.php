<?php
include('connect.php');

session_start();

$companyid = $_SESSION["companyid"];

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
$accstock = $row_acc['m_stock'];

$sqlcom = "SELECT * FROM personalstockdata WHERE m_stock = '".$accstock."' AND s_companyid = '".$companyid."' ";
$resultcom = mysqli_query($db_link,$sqlcom);
$row_com = mysqli_fetch_assoc($resultcom);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ATBC Banking - 股票交易成功</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/tradesuccessstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <section>
    <article class="left_article">
	  <div class="bg-style1" href="#">
   	    <h1>Banking</h1>
		  <h2 class="lbl3 h2stockt">✔ <?php echo $row_accout['st_tradetype']; ?>成功</h2>
		  <h2 class="lbl1top h2stock">持股編號</h2>
		  <h3 class="lbl2 h3stock"><?php echo $accstock; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1 h2stock h2stockbg"><?php echo $row_com['s_company']; ?>股數</h2>
		  <h3 class="lbl2 h3stock h3stocksm"><?php echo $row_com['p_stocknum']; ?></h3>
		  <h4></h4>
		  <hr class="hrstock">
		  <h2 class="lbl1 h2stock">交易日期</h2>
		  <h3 class="lbl2 h3stock"><?php echo $row_accout['st_tradetime']; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1 h2stock h2stocksm">交易明細</h2>
		  <h3 class="lbl2 h3stock h3stockbg"><?php echo $row_accout['st_tradenote']; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1 h2stock">臺幣餘額</h2>
		  <h3 class="lbl2 h3stock"><?php echo $row_accout['m_balance']; ?></h3>
		  <h4></h4>
		  <a href="mainpage.php"><input type="button" value="確認" class="btn stockbtn"></a>
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