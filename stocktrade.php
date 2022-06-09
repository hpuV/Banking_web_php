<?php

include('connect.php');

session_start();

$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$goldacc = $_SESSION["goldacc"];
$stockacc = $_SESSION["stockacc"];
$_SESSION['stockbuynum'] = "1";
$_SESSION['stocksellnum'] = "1";

//帳號資料
$sqlaccf = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$resultaccf = mysqli_query($db_link,$sqlaccf);
$row_accf = mysqli_fetch_assoc($resultaccf);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content..="chrome=1">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 股票交易</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/stocktradestyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body>
<?php
}else{
  echo "非法登入!";
  exit();
}

$companyid = "";
$stockprice = "0";
$companyname = "";

//搜尋股票編號 獲得股票價格
if (isset($_GET['searchid'])) {

  $companyid = $_GET["searchid"];
  
  $_SESSION["companyid"] = $companyid;

  //公司 股票資料
  $sqlcom = "SELECT * FROM stockdata WHERE s_companyid = '".$companyid."' ";
  $resultcom = mysqli_query($db_link,$sqlcom);
  $row_com = mysqli_fetch_assoc($resultcom);
  
  //股票編號不為空 有股票資料
  if(!empty($row_com['s_id'])){

    $companyname = $row_com['s_company'];

    //股票價格
    //獲取最大編號
    $sqlmaxid = "SELECT MAX(s_id) FROM stockdata WHERE s_companyid = '".$companyid."' ";
    $resultsid = mysqli_query($db_link,$sqlmaxid);
    $row_sid = mysqli_fetch_row($resultsid);
    $sid = $row_sid['0'];

    //獲取價格
    $sqlstock = "SELECT * FROM stockdata WHERE s_id = '".$sid."' ";
    $resultstock = mysqli_query($db_link,$sqlstock);
    $row_stock = mysqli_fetch_assoc($resultstock);
    $stockprice = $row_stock['s_price'];

    $sqlcheck= "SELECT * FROM personalstockdata WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."' GROUP BY s_companyid HAVING count(*) > 0;";
    $resultnorepeat = mysqli_query($db_link,$sqlcheck);
    $row_repeat = mysqli_fetch_assoc($resultnorepeat);
    if(!empty($row_repeat['s_companyid'])){
      //股票資料重複
      //echo "Data Repeat";
    }else{
      //股票資料沒重複
      $sqlpersonstock="INSERT INTO personalstockdata (p_id, m_stock, m_account, s_companyid , s_company, p_stocknum)
              VALUES (NULL ,'".$stockacc."' ,'".$account."' ,'".$companyid."' ,'".$companyname."' ,'0')";
      mysqli_query($db_link,$sqlpersonstock);
      //echo "Data Inserted";
    }

  }else{

    $companyid = "";
    $stockprice = "0";
    $companyname = "查無資料";
  }
}

//輸入商品之股票帳號資料
$sqlaccs = "SELECT * FROM personalstockdata WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."';";
$resultaccs = mysqli_query($db_link,$sqlaccs);
$row_accs = mysqli_fetch_assoc($resultaccs);

//增加/減少購買數量
if (isset($_POST['delbuy'])) {
  $_SESSION["stockbuynum"] = $_POST["numPostB"]-1;
  if($_SESSION["stockbuynum"] < 1){
    $_SESSION["stockbuynum"] = 1;
  }
}

if(isset($_POST['addbuy'])){
  $_SESSION["stockbuynum"] = $_POST["numPostB"]+1;
}

if (isset($_POST['delsell'])) {
  $_SESSION["stocksellnum"] = $_POST["numPostS"]-1;
  if($_SESSION["stocksellnum"] < 1){
    $_SESSION["stocksellnum"] = 1;
  }
}

if(isset($_POST['addsell'])){
  $_SESSION["stocksellnum"] = $_POST["numPostS"]+1;
}

mysqli_select_db($db_link, "phpmember");
  //echo $_POST['onoffswitch'];
  //更新股票買進資料
if(isset($_POST['submittradebuy'])){
  if($row_accout['m_balance'] <= 0){
    function_alert("餘額不足無法交易");
  }else{
    if(!empty($companyid)){
      $in_buy= $_POST["numPostB"];
      $stocknum = $row_accs['p_stocknum'];
      $trademoney = $stockprice*$in_buy*1000;

      date_default_timezone_set('Asia/Taipei');
      $in_tradetime= date("Y-m-d H:i:s");

        $in_stocknum = $stocknum + $in_buy;
        $in_balance=  $row_accf['m_balance']-$trademoney;

        $in_type= "買進股票";
        $in_note = "買進".$companyname."股票".$in_buy."張";

        //更新帳戶餘額
        $sqlUPdateFinance= "UPDATE financedata
                    SET m_balance= '".$in_balance."'
                    WHERE m_account= '".$account."'; ";
        $sqlUPdateDebit= "UPDATE debitcarddata
                    SET m_balance= '".$in_balance."'
                    WHERE m_account= '".$account."'; ";

        mysqli_query($db_link,$sqlUPdateFinance);
        mysqli_query($db_link,$sqlUPdateDebit);

        //交易紀錄
        $sqltradeacc= "INSERT INTO statementdata 
        VALUE('','$account','$in_balance','0','$trademoney','$in_tradetime','','$in_type','$in_note');";

        mysqli_query($db_link,$sqltradeacc);

        //更新股票資料
        $sqlUPdateStockData= "UPDATE personalstockdata
                    SET p_stocknum = '".$in_stocknum."'
                    WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."';";

        mysqli_query($db_link,$sqlUPdateStockData);

        header("location:tradestocknext.php");
    }else{
      function_alert("商品編號不能空白");
    }
  }
}

if(isset($_POST['submittradesell'])){
  if($row_accout['m_balance'] <= 0){
    function_alert("餘額不足無法交易");
  }else{
    if(!empty($companyid)){
      $in_buy= $_POST["numPostS"];
      $stocknum = $row_accs['p_stocknum'];
      $trademoney = $stockprice*$in_buy*1000;

      date_default_timezone_set('Asia/Taipei');
      $in_tradetime= date("Y-m-d H:i:s");
      
      $in_stocknum = $stocknum - $in_buy;
      //echo $in_stocknum;
      $in_balance=  $row_accf['m_balance']+$trademoney;

      $in_type= "賣出股票";
      $in_note = "賣出".$companyname."股票".$in_buy."張";
    
      //更新帳戶餘額
      $sqlUPdateFinance= "UPDATE financedata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
      $sqlUPdateDebit= "UPDATE debitcarddata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
    
      mysqli_query($db_link,$sqlUPdateFinance);
      mysqli_query($db_link,$sqlUPdateDebit);
    
      //交易紀錄
      $sqltradeacc= "INSERT INTO statementdata 
      VALUE('','$account','$in_balance','$trademoney','0','$in_tradetime','','$in_type','$in_note');";
    
      mysqli_query($db_link,$sqltradeacc);

      //更新股票資料
      $sqlUPdateStockData= "UPDATE personalstockdata
                  SET p_stocknum = '".$in_stocknum."'
                  WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."'; ";

      mysqli_query($db_link,$sqlUPdateStockData);

      header("location:tradestocknext.php");
    }else{
      function_alert("商品編號不能空白");
    }
  }
}

function function_alert($message) {
  // Display the alert box  
  echo "<script>alert('$message');
  window.location.href='editpwd.php';
  </script>"; 
  return false;
}

?>
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
    <form action="" method="get">
		<h2>證券交易</h2>
	    <div class="content"><h3>持股編號</h3></div>
		<div class="value"><h4>stockacc</h4></div>
		<div class="content"><h3>商品</h3></div>
		<div class="value"><h4><?php echo $companyname;?></h4></div>
		<input name="searchid" type="text"  placeholder="請輸入商品編號" value="<?php echo $companyid;?>" class="searchtxt">
    <input type="submit" value="搜尋" id="search" class="searchbtn">
    </form>
    <form action="" method="post">
		<span id="tab-1">1</span>
		<span id="tab-2">2</span>
		<span id="tab-3">3</span>
		<span id="tab-4">4</span>
		<div id="tab">
			<!-–頁籤按鈕-->
			<ul>
				<li><a href="#tab-1" class="buyp">買進</a></li>
				<li><a href="#tab-2" class="sellp">賣出</a></li>
			</ul>
			<!-–頁籤的內容區塊-->
			<div class="tab-content-1">
				<p class="buyp">買進股票</p>
				<input type="submit" name="delbuy" value="-" class= "numbtn add">
				<input type="text" name="numPostB" value="<?php echo $_SESSION["stockbuynum"]?>" class="txt">
				<input type="submit" name="addbuy" value="+" class= "numbtn">
				<p class="contentp buyp">1單位1000股</p>
				<p class="contentp buyp">價格: <?php echo $stockprice;?></p>
				<div class="box"></div>
				<input type="submit" value="下單" name="submittradebuy" class= "btn">
			</div>
			<div class="tab-content-2">
				<p class="sellp">買出股票</p>
				<input type="submit" name="delsell" value="-" class= "numbtn add">
				<input type="text" name="numPostS" value="<?php echo $_SESSION["stocksellnum"]?>" class="txt">
				<input type="submit" name="addsell" value="+" class= "numbtn">
				<p class="contentp sellp">1單位1000股</p>
				<p class="contentp sellp">價格: <?php echo $stockprice;?></p>
				<div class="box"></div>
				<input type="submit" value="下單" name="submittradesell" class= "btn">
			</div>
		</div>
    </form>
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