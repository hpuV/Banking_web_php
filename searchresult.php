<?php

include('connect.php');

session_start();

$levelString = array("無","用戶","管理者");

if (isset($_GET['queryString'])) {
    $queryField = $_GET["queryField"];
    $keyWord = $_GET["queryString"];
    $searchField = "";

    if (!strcmp($queryField, "mId"))
        {
            $searchField = "m_id";
        }
        else if (!strcmp($queryField, "mAccount"))
        {
            $searchField = "m_account";
        }
        else if (!strcmp($queryField, "mUsername"))
        {
            $searchField = "m_username";
        }
        else if (!strcmp($queryField, "mNickname"))
        {
            $searchField = "m_nick";
        }
        else if (!strcmp($queryField, "mLevel"))
        {
            $searchField = "m_level";
        }
        else if (!strcmp($queryField, "mGender"))
        {
            $searchField = "m_gender";
        }
        else if (!strcmp($queryField, "mBday"))
        {
            $searchField = "m_birthday";
        }
        else if (!strcmp($queryField, "mEmail"))
        {
            $searchField = "m_email";
        }
        else if (!strcmp($queryField, "mPhone"))
        {
            $searchField = "m_phone";
        }
        else if (!strcmp($queryField, "mAddress"))
        {
            $searchField = "m_address";
        }
        else
        {
            // nothing to do 
        }

        $queryString = "SELECT * FROM memberdata WHERE $searchField LIKE '%$keyWord%'";
        $result = mysqli_query($db_link,$queryString);

        $data_nums = mysqli_num_rows($result); //統計總比數
        $per = 10; //每頁顯示項目數量
        $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
        if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
            $page=1; //則在此設定起始頁數
        } else {
            $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
        }
        $start = ($page-1)*$per; //每一頁開始的資料序號

        $queryString = "SELECT * FROM memberdata WHERE $searchField LIKE '%$keyWord%' LIMIT $start, $per"; 
        $result = mysqli_query($db_link,$queryString);

        $pageFirst= "?queryField=$searchField&submit=搜尋&page=1";
        $pageList= "?queryField=$searchField&submit=搜尋&page=";

}else{
    $queryString = "SELECT * FROM memberdata";
    $result = mysqli_query($db_link,$queryString);

    $data_nums = mysqli_num_rows($result); //統計總比數
    $per = 10; //每頁顯示項目數量
    $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page-1)*$per; //每一頁開始的資料序號

    $queryString = "SELECT * FROM memberdata LIMIT $start, $per"; 
    $result = mysqli_query($db_link,$queryString);

    $pageFirst= "?page=1";
    $pageList= "?page=";
}

mysqli_close($db_link); // 連線結束

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
<link href="css/searchresultstyle.css" rel="stylesheet" type="text/css">
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
    <aside class="right_article">
	<div class="bg-style1">
		<form action="" method="get">
			<div>
			<h2 class="field">查詢欄位</h2>
				<select name="queryField" class= "select">
				<option value="mId">用戶編號</option>
				<option value="mAccount">銀行帳戶</option>
				<option value="mUsername">使用者名稱</option>
				<option value="mNickname">暱稱</option>
				<option value="mLevel">等級</option>
				<option value="mGender">性別</option>
				<option value="mBday">生日</option>
				<option value="mEmail">email</option>
				<option value="mPhone">電話</option>
				<option value="mAddress">住址</option>
				</select>
			</div>
			<div class="clearfix"></div>
			<div>
			<h2 class="content">搜尋內容</h2>
				<input type="text" name="queryString" class= "txt">
				<input type="submit" name="submit" value="搜尋" class= "btn">
			</div>
			<div class="clearfix"></div>
		</form>
		<table class="userlist">
			<tr>
				<th class="title">用戶編號</th>
				<th class="title">銀行帳號</th>
				<th class="title">使用者名稱</th>
				<th class="title">密碼</th>
				<th class="title">暱稱</th>
				<th class="title">等級</th>
				<th class="title">性別</th>
				<th class="title">生日</th>
				<th class="title">Email</th>
				<th class="title">電話號碼</th>
				<th class="title">地址</th>
			</tr>
            <?php
                //輸出資料內容
                while ($row = mysqli_fetch_array ($result))
                {
            ?>
                    <tr>
                        <td><?php echo $row['m_id']; ?></td>
                        <td><?php echo $row['m_account']; ?></td>
                        <td><?php echo $row['m_username']; ?></td> 
                        <td><?php echo $row['m_password']; ?></td>            
                        <td><?php echo $row['m_nick']; ?></td> 
                        <td><?php echo $row['m_level']; ?></td> 
                        <td><?php echo $row['m_gender']; ?></td>
                        <td><?php echo $row['m_birthday']; ?></td>
                        <td><?php echo $row['m_email']; ?></td>
                        <td><?php echo $row['m_phone']; ?></td>
                        <td><?php echo $row['m_address']; ?></td>
                    </tr>
            <?php
                }
                if (mysqli_num_rows($result) <= 0) {
                    echo "<script>alert('搜尋不到任何符合條件的紀錄')</script>";
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
    </aside>
	</section>
  <footer class="tertiary_header footer">
    <div class="copyright">Copyright &copy;<strong> Chin-An Liu.</strong> All rights reserved.</div>
  </footer>
</div>
</body>
</html>
