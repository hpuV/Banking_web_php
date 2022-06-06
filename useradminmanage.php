<?php

include('connect.php');

session_start();

$levelString = array("無","用戶","管理者");

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['level']>=2){

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content..="chrome=1">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>銀行網站</title>
<link href="css/useradminmanagestyle.css" rel="stylesheet" type="text/css">
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
		<h3><a class="nav-info" href="useradminmanage.php">會員管理</a></h3>
		<h3><a class="nav-info" href="createacc.php">新增會員</a></h3>
		<h3><a class="nav-info" href="searchresult.php">查詢會員</a></h3>
	</article>
    <aside class="right_article">
	<div class="bg-style1">
	<?php
		$sql="SELECT * FROM memberdata";
		$ro = mysqli_query($db_link,$sql);
	?>
	<?php
		while($row=mysqli_fetch_assoc($ro)){
	?>
			<table>
				<tr>
					<th class="title">編號:</th>
					<td><?php echo $row['m_id']; ?></td>
				</tr>
				<tr>
					<th class="title">帳號:</th>
					<td><?php echo $row['m_username']; ?></td>
				</tr>
				<tr>
					<th class="title">暱稱:</th>
					<td><?php echo $row['m_nick']; ?></td>
				<tr>
					<th class="title">身份:</th>
					<td><?php echo $levelString[$row['m_level']]; ?></td>
				</tr>
			</table>
	<?php
  		};
	?>
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
<?php
}else{
	exit;
}
?>