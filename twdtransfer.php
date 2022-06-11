<?php

include('connect.php');

session_start();

//轉出帳號資料(這個登入者)
$account = $_SESSION["account"];
$sqlout = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$resultout = mysqli_query($db_link,$sqlout);
$row_accout = mysqli_fetch_assoc($resultout);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  $balance = $row_accout["m_balance"];
  $balance = number_format($balance);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 臺幣轉帳</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/twdtransferstyle.css" rel="stylesheet" type="text/css">
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
  <?php
  }else{
    echo "非法登入!";
    exit();
  }

  if(isset($_POST['accin'])){
    if($row_accout['m_balance'] <= 0){
      function_alert("餘額不足無法交易");
    }else{
      //更新資料
      $in_accin= $_POST['accin'];
      $in_amount= $_POST['amountin'];
      $in_note= $_POST['notein'];
      $in_type= "臺幣轉帳";
      $in_balanceOutacc= $row_accout['m_balance']-$in_amount;

      if($in_balanceOutacc < 0){
        function_alert("餘額不足無法交易");
      }else{

        date_default_timezone_set('Asia/Taipei');
        $in_tradetime= date("Y-m-d H:i:s");

        //session 資料
        $_SESSION["amounttwd"] = $in_amount;

        //轉入帳號資料
        $account = $_SESSION["account"];
        $sqlin = "SELECT * FROM financedata WHERE m_account = '".$in_accin."' ";
        $resultin = mysqli_query($db_link,$sqlin);
        $row_accin = mysqli_fetch_assoc($resultin);
        $in_balanceInacc= $row_accin['m_balance']+$in_amount;

        mysqli_select_db($db_link, "phpmember");
        //轉出帳號(這個登入者)
        //編號 帳號出 餘額 收入 支出 時間 帳號入 註記
        $sqlOutacc= "INSERT INTO statementdata 
        VALUE(NULL,'$account','$in_balanceOutacc','0','$in_amount','$in_tradetime','$in_accin','$in_type','$in_note');";
        
        //轉入帳號
        //編號 帳號入 餘額 收入 支出 時間 帳號出 註記
        $sqlInacc= "INSERT INTO statementdata 
        VALUE(NULL,'$in_accin','$in_balanceInacc','$in_amount','0','$in_tradetime','$account','$in_type','$in_note');";

        mysqli_query($db_link,$sqlOutacc);
        mysqli_query($db_link,$sqlInacc);

        //更新資料financedata, debitcarddata - 轉出帳號(這個登入者)
        $sqlUPdateFinanceOut= "UPDATE financedata
                    SET m_balance= '".$in_balanceOutacc."'
                    WHERE m_account= '".$account."'; ";
        $sqlUPdateDebitOut= "UPDATE debitcarddata
                    SET m_balance= '".$in_balanceOutacc."'
                    WHERE m_account= '".$account."'; ";

        mysqli_query($db_link,$sqlUPdateFinanceOut);
        mysqli_query($db_link,$sqlUPdateDebitOut);
        
        //更新資料financedata, debitcarddata - 轉入帳號
        $sqlUPdateFinanceIn= "UPDATE financedata
                    SET m_balance= '".$in_balanceInacc."'
                    WHERE m_account= '".$in_accin."'; ";
        $sqlUPdateDebitIn= "UPDATE debitcarddata
                    SET m_balance= '".$in_balanceInacc."'
                    WHERE m_account= '".$in_accin."'; ";

        mysqli_query($db_link,$sqlUPdateFinanceIn);
        mysqli_query($db_link,$sqlUPdateDebitIn);
        header("location:tradetwdnext.php");
      }
    }
  }

  function function_alert($message) {
    echo "<script>alert('$message');
    window.location.href='twdtransfer.php';
    </script>"; 
    return false;
  }

  ?>
	<form action="" method="post" enctype="multipart/form-data">
  <div class="bg-style1">
		<h2>臺幣轉帳</h2>
	    <div class="content"><h3>轉出帳號</h3></div>
		<div class="value"><h4><?php echo $row_accout['m_account']; ?></h4></div>
	    <div class="content"><h3>可用餘額</h3></div>
		<div class="value"><h4><?php echo $balance; ?></h4></div>
		<hr>
		<h3 class="lbl1">轉入帳號</h3>
		<input type="text" name="accin" placeholder="銀行代碼/帳號" class="txt">
		<h3 class="lbl1">轉入金額</h3>
		<input type="text" name="amountin" class="txt">
		<h3 class="lbl1">註記</h3>
		<input type="text" name="notein" placeholder="顯示於交易紀錄限7個字" class="txt">
		<div class="box"></div>
		<input type="submit" value="提交" class= "btn">
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