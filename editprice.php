<?php

include('connect.php');

session_start();

if(isset($_GET['dataid'])){
  $dataid = $_GET['dataid'];
  $sql = "SELECT * FROM memberdata WHERE m_id = '".$dataid."' ";
  $result = mysqli_query($db_link,$sql);
  $row_Login = mysqli_fetch_assoc($result);

  $up_account = $row_Login['m_account'];
  $_SESSION["sess_account"] = $up_account;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 更新股票</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/editaccadminstyle.css" rel="stylesheet" type="text/css">
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
	<article class="left_article">
    <h3 class="toph3"><a class="nav-info" href="useradmincenter.php">個人資料</a></h3>
    <h3><a class="nav-info" href="editacc.php">變更資料</a></h3>
    <h3><a class="nav-info" href="editpwd.php">更改密碼</a></h3>
		<h3><a class="nav-info" href="editaccadmin.php">會員管理</a></h3>
		<h3><a class="nav-info" href="createacc.php">新增會員</a></h3>
		<h3><a class="nav-info" href="searchresult.php">查詢會員</a></h3>
	</article>
  <?php

    $msg = "更新資訊";

    function get_Stock_price($getID){
      $url =
      "https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch=tse_".$getID.".tw&";
      $data = file_get_contents($url);
      $data = json_decode($data,true);
      if(!empty($data['msgArray'][0]['z'])){
        $updata = $data['msgArray'][0]['z'];
      }else{
        $updata = "";
      }
      return $updata;
    }
    
  if(isset($_GET['submit'])){
    date_default_timezone_set('Asia/Taipei');
    $tradetime= date("Y-m-d H:i:s");

    $up_2330 = get_Stock_price(2330);
    $up_3008 = get_Stock_price(3008);
    $up_2409 = get_Stock_price(2409);
    $up_2603 = get_Stock_price(2603);
    $up_0050 = get_Stock_price(0050);
    
    $sqlUP2330 = "UPDATE stockdata
              SET s_price= '".$up_2330."',
                  s_time= '".$tradetime."'
                  WHERE s_companyid= '2330'; ";

    $sqlUP3008 = "UPDATE stockdata
              SET s_price= '".$up_3008."',
                  s_time= '".$tradetime."'
                  WHERE s_companyid= '3008'; ";
    
    $sqlUP2409 = "UPDATE stockdata
              SET s_price= '".$up_2409."',
                  s_time= '".$tradetime."'
                  WHERE s_companyid= '2409'; ";
    
    $sqlUP2603 = "UPDATE stockdata
              SET s_price= '".$up_2603."',
                  s_time= '".$tradetime."'
                  WHERE s_companyid= '2603'; ";

    $sqlUP0050 = "UPDATE stockdata
              SET s_price= '".$up_0050."',
                  s_time= '".$tradetime."'
                  WHERE s_companyid= '0050'; ";
    
      if(mysqli_query($db_link,$sqlUP2330) && mysqli_query($db_link,$sqlUP3008) && mysqli_query($db_link,$sqlUP2409)
      && mysqli_query($db_link,$sqlUP2603) && mysqli_query($db_link,$sqlUP0050)
      ){
        $msg = "股價更新成功"." - 更新時間".$tradetime;
      }else{
        $msg = "更新失敗!";
      }
  }
  ?>
  <aside class="right_article">
  <form action="" method="get">
	<div class="bg-style1">
		<h1>更新股票價格</h1>
		  <h2 class="lbl2"><?php echo $msg;?></h2>
		  <input type="submit" value="更新" name="submit" class="updatebtn">
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