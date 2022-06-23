<?php
include('connect.php');

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

$account = $_SESSION["account"];
$sqlmax = "SELECT MAX(st_id) FROM statementdata";
$resultmax = mysqli_query($db_link,$sqlmax);
$row_max = mysqli_fetch_row($resultmax);
$id = $row_max['0'];

$sqlout = "SELECT * FROM statementdata WHERE st_id = '".$id."' ";
$resultout = mysqli_query($db_link,$sqlout);
$row_accout = mysqli_fetch_assoc($resultout);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ATBC Banking - 轉帳成功</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/tradesuccessstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <section>
    <article class="left_article">
	  <div class="bg-style1">
   	    <h1>Banking</h1>
		  <h2 class="lbl3">✔ 交易成功</h2>
		  <h2 class="lbl1top">轉入金額</h2>
		  <h3 class="lbl2"><?php echo $_SESSION["amounttwd"];?></h3>
		  <h4></h4>
		  <h2 class="lbl1">轉入帳號</h2>
		  <h3 class="lbl2"><?php echo $row_accout['st_tradeacc']; ?></h3>
		  <h4></h4>
		  <hr>
		  <h2 class="lbl1">轉帳日期</h2>
		  <h3 class="lbl2"><?php echo $row_accout['st_tradetime']; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1">轉出帳號</h2>
		  <h3 class="lbl2"><?php echo $account;?></h3>
		  <h4></h4>
		  <h2 class="lbl1">轉出帳號餘額</h2>
		  <h3 class="lbl2"><?php echo $row_accout['m_balance']; ?></h3>
		  <h4></h4>
		  <h2 class="lbl1">註記</h2>
		  <h3 class="lbl2"><?php echo $row_accout['st_tradenote']; ?></h3>
		  <h4></h4>
		  <a href="mainpage.php"><input type="button" value="確認" class="btn"></a>
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
<?php
  }else{
    echo "非法登入!";
    exit();
  }
?>