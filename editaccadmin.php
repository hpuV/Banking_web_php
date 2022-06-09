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
<title>ATBC Banking - 會員管理</title>
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
    if(isset($up_account)){
      $up_id= $row_Login['m_id'];
      $up_username= $row_Login['m_username'];
      $up_nickname= $row_Login['m_nick'];
      $up_level= $row_Login['m_level'];
    }else{
      $up_username= "";
      $up_nickname= "";
      $up_level= "0";
    }

    if(isset($_POST['username'])){
      $up_username= $_POST['username'];
      $up_nick= $_POST['nickname'];
      $up_level= $_POST['level'];
      $sqlUPdate= "UPDATE memberdata
            SET m_username= '.$up_username.',
                m_level= '.$up_level.',
                m_nick= '.$up_nickname.',
                WHERE m_account= '.$up_account.'; ";
      
      mysqli_select_db($db_link, "phpmember");
      mysqli_query($db_link,$sqlUPdate);
      header("location:editaccadmin.php");
    }
  ?>
  <aside class="right_article">
	<form action="" method="get">
	<div class="search">
		<h1 class="lbl1">資料編號</h1>
		<input type="text" name="dataid" class="txt">
		<input name="submit" type="submit" value="搜索" class= "btn"/>
	</div>
	</form>
	<div class="clearfix"></div>
  <form action="" method="post" enctype="multipart/form-data">
	<div class="bg-style1">
		<h1>更改資料</h1>
		  <h2 class="lbl2">帳號</h2>
		  <input type="text" name="username" value="<?php echo $up_username;?>" class="txt2">
		  <h2 class="lbl2">名稱</h2>
		  <input type="text" name="nickname" id="nickname" value="<?php echo $up_nickname;?>" class="txt2">
		  <h2 class="lbl3">等級</h2>
		  <select name="level" class="select">
          	<option value="0">無</option>
          	<option value="1" selected>用戶</option>
          	<option value="2">管理者</option>
          </select>
		  <div class="box"></div>
		  <input type="submit" value="確認修改" name="submit" class="editbtn">
		  <a href="deleteacc.php"><input type="" value="刪除" name="" class="editbtn"></a>
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