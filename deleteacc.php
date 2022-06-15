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
<title>ATBC Banking - 是非題之刪除會員</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/deleteaccstyle.css" rel="stylesheet" type="text/css">
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
  <div class="top-box"></div>
  <div class="cssload-loader">
		<div class="cssload-inner cssload-one"></div>
		<div class="cssload-inner cssload-two"></div>
		<div class="cssload-inner cssload-three"></div>
	  </div>
    <?php
      }else{
        echo "非法登入!";
        exit();
      }

      $de_account = $_SESSION["sess_account"];
      //echo $de_id;
      $sqlDelete= "DELETE FROM memberdata WHERE m_account = '".$de_account."'";

      if(array_key_exists("yes",$_POST)){
        if(mysqli_query($db_link,$sqlDelete)){
          function_alert("刪除成功!");
        }else{
          function_alert("刪除失敗!");
        }
      }

      if(array_key_exists("no",$_POST)){
        header("location:editaccadmin.php");
      }


      function function_alert($message) { 
      
        echo "<script>alert('$message');
         window.location.href='editaccadmin.php';
        </script>"; 
        
        return false;
      }
    ?>
  <section>
  <form method="post">
    <article class="succ_article">
	  <div class="bg-style1" href="#">
		  <h1 class="lbl1">是否要刪除帳號</h1>
		  <div class="option">
		  <h2 class="leftBtn"><input name="yes" type="submit" value="是" class="btn"></h2>
		  <h2 class="rightBtn"><input name="no" type="submit" value="否" class="btn"></h2>
		  </div>
		  <div class="clearfix"></div>
       </div>
    </article>
  </form>
  </section>
	 <div class="clearfix"></div>
  	 <div class="content-box"></div>
  <footer class="tertiary_header footer">
    <div class="copyright">Copyright &copy;<strong> Chin-An Liu.</strong> All rights reserved.</div>
  </footer>
</div>
</body>
</html>