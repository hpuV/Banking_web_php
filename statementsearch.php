<?php

include('connect.php');

session_start();

$levelString = array("無","用戶","管理者");

$account= $_SESSION["account"];
$keyWord1 = "";
$fieldString = "";

if (isset($_GET['queryField'])) {
    $queryField = $_GET["queryField"];
    

        if (!strcmp($queryField, "mTwd"))
        {
            $keyWord1 = "轉帳";
            $fieldString = "mTwd";
        }
        else if (!strcmp($queryField, "mStock"))
        {
            $keyWord1 = "股票";
            $fieldString = "mStock";
        }
        else if (!strcmp($queryField, "mGold"))
        {
            $keyWord1 = "黃金";
            $fieldString = "mGold";
        }
}

    if(isset($_GET["sday"])){
        $keyWord2 = $_GET["sday"];
    }else{
        $keyWord2 = "";
    }

    $sqlquery = "SELECT * FROM statementdata WHERE st_tradetype LIKE '%$keyWord1%' AND m_account = $account AND st_tradetime LIKE '%$keyWord2%'";
    $resultnolimit = mysqli_query($db_link,$sqlquery);

    $data_nums = mysqli_num_rows($resultnolimit); //統計總比數
    $per = 10; //每頁顯示項目數量
    $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page-1)*$per; //每一頁開始的資料序號

    $queryString = "SELECT * FROM statementdata WHERE st_tradetype LIKE '%$keyWord1%' AND m_account = $account AND st_tradetime LIKE '%$keyWord2%' LIMIT $start, $per"; 
    $resultlimit = mysqli_query($db_link,$queryString);

    $pageFirst= "?queryField=$fieldString&sday=$keyWord2&submit=搜尋&page=1";
    $pageList= "?queryField=$fieldString&sday=$keyWord2&submit=搜尋&page=";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/mainpagestyle.css" rel="stylesheet" type="text/css">
<link href="css/statementsearchstyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body>
<div class="container">
  <header>
	 <nav class="primary_header" id="menu">
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
	<div class="top-box"></div>
    <aside class="right_article">
	<div class="bg-style1">
		<form action="" method="get">
			<div class="search">
			<h2 class="field">查詢欄位</h2>
				<select name="queryField" class= "select">
				<option value="mTwd">轉帳交易</option>
				<option value="mStock">股票交易</option>
				<option value="mGold">黃金交易</option>
				</select>
			</div>
			<div class="searchday">
			<h2 class="content">搜尋日期</h2>
				<input type="month" id="sday" name="sday" class="day">
				<input type="submit" name="submit" value="搜尋" class= "btn">
			</div>
			<div class="clearfix"></div>
		</form>
		<table class="userlist">
			<tr>
				<th class="title">交易日期</th>
				<th class="title">存入</th>
				<th class="title">支出</th>
				<th class="title">結餘</th>
				<th class="title">轉入帳號</th>
				<th class="title">類型</th>
				<th class="title">註記</th>
			</tr>
            <?php
                //輸出資料內容
                while ($row = mysqli_fetch_array ($resultlimit))
                {
            ?>
			<tr>
				<td><?php echo $row['st_tradetime']; ?></td>
				<td><?php echo $row['st_income']; ?></td>
				<td><?php echo $row['st_outcome']; ?></td>
				<td><?php echo $row['m_balance']; ?></td>
				<td><?php echo $row['st_tradeacc']; ?></td>
				<td><?php echo $row['st_tradetype']; ?></td>
				<td><?php echo $row['st_tradenote']; ?></td>
			</tr>
            <?php
                }
            ?>
		</table>
     </div>
	 <div class="clearfix"></div>
	 <div class="page">
        <div class="top"><?php echo '共 '.$data_nums.' 筆 在 '.$page.' 頁 共 '.$pages.' 頁';?></div>
        <div class="sec">
			<?php echo "<a href=$pageFirst>首頁</a>";?>
			第<?php
            for( $i=1 ; $i<=$pages ; $i++ ) {
                if ( $page-3 < $i && $i < $page+3 ) {
                    echo "<a href=$pageList".$i.">".$i."</a>";
                }
            }?>
			<?php echo " 頁 <a href=$pageList".$pages.">末頁</a>";?>
		</div>
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
