<?php

include('connect.php');

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['level']>=2){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 新增會員</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<script type="text/javascript">
	function showOrHide(){
		var dis = document.getElementById('mapid');

		if(dis.style.display == ''){
			dis.style.display = 'none';
		}else{
			dis.style.display = '';
		}
	}
</script>
<link href="css/createaccstyle.css" rel="stylesheet" type="text/css">
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
      <h3><a class="nav-info" href="editprice.php">更新股票</a></h3>
  </article>
  <aside class="right_article">
  <?php
    }else{
      echo "非法登入!";
      exit();
    }

  if(isset($_POST['username'])){
    $in_username= $_POST['username'];
    $in_password= $_POST['password'];
    $in_nickname=$_POST['nickname'];
    $in_level= $_POST['level'];
    $in_gender= $_POST['gender'];
    $in_bday= $_POST['bday'];
    $in_email= $_POST['email'];
    $in_phone= $_POST['phone'];
    $in_address= $_POST['address'];

    $in_account = rand(10,99999999);
    $in_account = sprintf("%09d",$in_account);

    $sql="INSERT INTO memberdata 
            VALUE(NULL,'$in_account','$in_username','$in_password','$in_nickname','$in_level','$in_gender','$in_bday','$in_email','$in_phone','$in_address');";

    if(mysqli_query($db_link,$sql)){
      function_alert("Create Account Successfully!");
    }else{
      function_alert("Error creating table: ".mysqli_error($db_link));
    }
  }

  function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='createacc.php';
    </script>"; 
    
    return false;
  }
  ?>
  <form action="" method="post" enctype="multipart/form-data">
	<div class="bg-style1">
   	    <h1>新增會員</h1>
		  <h2 class="lbl1">帳號</h2>
		  <input type="text" name="username" class="txt">
		  <h2 class="lbl1">密碼</h2>
		  <input type="password" name="username" class="txt">
		  <h2 class="lbl2">等級</h2>
		  <select name="level" class="select">
          <option value="0">無</option>
          <option value="1">用戶</option>
          <option value="2">管理者</option>
          </select>
		  <h2 class="lbl1">名稱</h2>
		  <input type="text" name="nickname" id="nickname" class="txt">
		  <h2 class="lbl2">性別</h2>
		  <select name="gender" class="select">
          	<option value="男">Male</option>
          	<option value="女">Female</option>
          	<option value="其他">Other</option>
          </select>
		  <h2 class="lbl1">生日</h2>
		  <input type="date" id="bday" name="bday" class="day">
		  <h2 class="lbl1">電子信箱</h2>
		  <input type="text" name="email" class="txt">
		  <h2 class="lbl1">手機號碼</h2>
		  <input type="text" name="phone" class="txt">
		  <h2 class="lbl1">地址</h2>
		  <input type="text" name="address" class="txtmap">
		  <a href="javascript:;" class="map-link" onclick="showOrHide()">搜尋地址</a>
		  <input type="submit" value="新增會員" name="submit" class="btn">
       </div>
	 <div class="clearfix"></div>
	  <div id="mapid" style="display: none" class="map">
		  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29455.80915183944!2d120.47031454449525!3d22.65467805683902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346e178cae0b7a29%3A0x50bf59e1705a0a73!2z5ZyL56uL5bGP5p2x5aSn5a245rCR55Sf5qCh5Y2A!5e0!3m2!1szh-TW!2stw!4v1652279981894!5m2!1szh-TW!2stw" width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		  <h3>點選「搜尋地址」關閉Google地圖</h3>
      </div>
    </aside>
	</section>
  <footer class="tertiary_header footer">
    <div class="copyright">Copyright &copy;<strong> Chin-An Liu.</strong> All rights reserved.</div>
  </footer>
</div>
</form>
</body>
</html>