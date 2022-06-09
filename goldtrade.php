<?php

include('connect.php');

session_start();

$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$goldacc = $_SESSION["goldacc"];

//帳號資料
$sqlaccf = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$resultaccf = mysqli_query($db_link,$sqlaccf);
$row_accf = mysqli_fetch_assoc($resultaccf);

//黃金存摺 帳戶資料
$sqlacc = "SELECT * FROM golddata WHERE m_gold = '".$goldacc."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);

//黃金價格
//獲取最大編號
$sqlmaxid = "SELECT MAX(gp_id) FROM goldpricedata";
$resultgpid = mysqli_query($db_link,$sqlmaxid);
$row_gpid = mysqli_fetch_row($resultgpid);
$gpid = $row_gpid['0'];


//獲取價格
$sqlgold = "SELECT * FROM goldpricedata WHERE gp_id = '".$gpid."' ";
$resultgold = mysqli_query($db_link,$sqlgold);
$row_gold = mysqli_fetch_assoc($resultgold);
$goldprice = $row_gold['g_price'];

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content..="chrome=1">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/goldtradestyle.css" rel="stylesheet" type="text/css">
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
  <?php
  }else{
    echo "非法登入!";
    exit();
  }

  if(isset($_POST['g_buygold'])){
    if(!empty($_POST['g_buygold'])){
      $in_buygold= $_POST['g_buygold'];
      
      $goldnum = $row_acc['m_goldnum'];
      $in_goldnum = $goldnum + $in_buygold;
      $trademoney = $goldprice*$in_buygold;
      $in_balance=  $row_accf['m_balance']-$trademoney;

      date_default_timezone_set('Asia/Taipei');
      $in_tradetime= date("Y-m-d H:i:s");

      $in_type= "買進黃金";
      $in_note = "買進".$in_buygold."個黃金";

      mysqli_select_db($db_link, "phpmember");

      //交易紀錄、更新帳戶餘額
      $sqltradeacc= "INSERT INTO statementdata 
      VALUE(NULL,'$account','$in_balance','0','$trademoney','$in_tradetime','','$in_type','$in_note');";

      mysqli_query($db_link,$sqltradeacc);

      $sqlUPdateFinance= "UPDATE financedata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
      $sqlUPdateDebit= "UPDATE debitcarddata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";

      mysqli_query($db_link,$sqlUPdateFinance);
      mysqli_query($db_link,$sqlUPdateDebit);

      //更新黃金資料
      $sqlUPdateGoldData= "UPDATE golddata
                  SET m_goldnum= '".$in_goldnum."'
                  WHERE m_gold= '".$goldacc."'; ";

      mysqli_query($db_link,$sqlUPdateGoldData);

    }else{
      $in_buygold = "0";
    }

    header("location:tradegoldnext.php");
  }

  if(isset($_POST['g_sellgold'])){
    if(!empty($_POST['g_sellgold'])){
      $in_sellgold= $_POST['g_sellgold'];

      $goldnum = $row_acc['m_goldnum'];
      $in_goldnum = $goldnum - $in_sellgold;
      $trademoney = $goldprice*$in_sellgold;
      $in_balance=  $row_accf['m_balance']+$trademoney;

      date_default_timezone_set('Asia/Taipei');
      $in_tradetime= date("Y-m-d H:i:s");

      $in_type= "賣出黃金";
      $in_note = "賣出".$in_sellgold."個黃金";

      mysqli_select_db($db_link, "phpmember");

      //交易紀錄、更新帳戶餘額
      $sqltradeacc= "INSERT INTO statementdata 
      VALUE(NULL,'$account','$in_balance','$trademoney','0','$in_tradetime','','$in_type','$in_note');";

      mysqli_query($db_link,$sqltradeacc);

      $sqlUPdateFinance= "UPDATE financedata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
      $sqlUPdateDebit= "UPDATE debitcarddata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";

      mysqli_query($db_link,$sqlUPdateFinance);
      mysqli_query($db_link,$sqlUPdateDebit);

      //更新黃金資料
      $sqlUPdateGoldData= "UPDATE golddata
                  SET m_goldnum= '".$in_goldnum."'
                  WHERE m_gold= '".$goldacc."'; ";

      mysqli_query($db_link,$sqlUPdateGoldData);
    }else{
      $in_sellgold = "0";
    }

    header("location:tradegoldnext.php");
  }

  ?>
	<form action="" method="post" enctype="multipart/form-data">
  <div class="bg-style1">
		<h2>黃金交易</h2>
	    <div class="content"><h3>黃金帳戶</h3></div>
		<div class="value"><h4><?php echo $goldacc; ?></h4></div>
		<div class="content"><h3>持有數量</h3></div>
		<div class="value"><h4><?php echo $row_acc['m_goldnum']; ?></h4></div>
		<div class="content"><h3>黃金價格</h3></div>
		<div class="value"><h4><?php echo $goldprice; ?></h4></div>
		<span id="tab-1">1</span>
		<span id="tab-2">2</span>
		<span id="tab-3">3</span>
		<span id="tab-4">4</span>
		<div id="tab">
			<!-–頁籤按鈕-–>
			<ul>
				<li><a href="#tab-1">買進</a></li>
				<li><a href="#tab-2">賣出</a></li>
			</ul>
			<!-–頁籤的內容區塊-–>
			<div class="tab-content-1">
				<p>購買黃金</p>
				<input type="text" name="g_buygold" class="txt">
				<div class="box"></div>
				<input type="submit" value="交易" class= "btn">
			</div>
			<div class="tab-content-2">
				<p>賣出黃金</p>
				<input type="text" name="g_sellgold" class="txt">
				<div class="box"></div>
				<input type="submit" value="交易" class= "btn">
			</div>
		</div>
  </div>
  </form>
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