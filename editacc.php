<?php

include('connect.php');

session_start();

$account = $_SESSION["account"];
$sql = "SELECT * FROM memberdata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
$row_Login = mysqli_fetch_assoc($result);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 變更資料</title>
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
<link href="css/editaccstyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body>
<?php
if(isset($row_Login['m_account'])){
  $up_id= $row_Login['m_id'];
  $up_account= $row_Login['m_account'];
  $up_username= $row_Login['m_username'];
  $up_nickname= $row_Login['m_nick'];
  $up_level= $row_Login['m_level'];
  $up_gender= $row_Login['m_gender'];
  $up_bday= $row_Login['m_birthday'];
  $up_email= $row_Login['m_email'];
  $up_phone= $row_Login['m_phone'];
  $up_address= $row_Login['m_address'];
}else{
  $up_username= "";
  $up_nickname= "";
  $up_level= "1";
  $up_gender= "";
  $up_bday= "";
  $up_email= "";
  $up_phone= "";
  $up_address= "";
}

if(
isset($_POST['m_username']) || isset($_POST['m_nick']) || isset($_POST['m_gender']) || isset($_POST['m_bday'])
|| isset($_POST['m_email']) || isset($_POST['m_phone']) || isset($_POST['m_address'])
){
  if($_SESSION["level"]<=0){
    $up_username= $row_Login['m_username'];
    $up_nickname= $_POST['m_nick'];
    $up_gender= $_POST['m_gender'];
    $up_bday= $_POST['m_bday'];
    $up_email= $_POST['m_email'];
    $up_phone= $_POST['m_phone'];
    $up_address= $_POST['m_address'];

    $sqlUPdate= "UPDATE memberdata
          SET m_username= '".$up_username."',
              m_nick= '".$up_nickname."',
              m_gender = '".$up_gender."',
              m_birthday = '".$up_bday."',
              m_email = '".$up_email."',
              m_phone = '".$up_phone."',
              m_address = '".$up_address."'
              WHERE m_account= '".$up_account."'; ";
    
    mysqli_select_db($db_link, "phpmember");
    if(mysqli_query($db_link,$sqlUPdate)){
      function_alert("更改成功!");
    }else{
      function_alert("更改失敗!");
    }
  }else{
    $up_username= $_POST['m_username'];
    $up_nickname= $_POST['m_nick'];
    $up_gender= $_POST['m_gender'];
    $up_bday= $_POST['m_bday'];
    $up_email= $_POST['m_email'];
    $up_phone= $_POST['m_phone'];
    $up_address= $_POST['m_address'];

    $sqlUPdate= "UPDATE memberdata
          SET m_username= '".$up_username."',
              m_nick= '".$up_nickname."',
              m_gender = '".$up_gender."',
              m_birthday = '".$up_bday."',
              m_email = '".$up_email."',
              m_phone = '".$up_phone."',
              m_address = '".$up_address."'
              WHERE m_account= '".$up_account."'; ";
    
    mysqli_select_db($db_link, "phpmember");
    if(mysqli_query($db_link,$sqlUPdate)){
      function_alert("更改成功!");
    }else{
      function_alert("更改失敗!");
    }
  }
}

function function_alert($message) { 
      
  // Display the alert box  
  echo "<script>alert('$message');
   window.location.href='editacc.php';
  </script>"; 
  
  return false;
}
?>
<form name="registerForm" method="post" action="" onsubmit="return validateForm()">
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
    <?php
      if($_SESSION['level']>=2){
    ?>
      <h3 class="toph3"><a class="nav-info" href="useradmincenter.php">個人資料</a></h3>
    <?php
      }else{
    ?>
      <h3 class="toph3"><a class="nav-info" href="usercenter.php">個人資料</a></h3>
    <?php
      }
    ?>
    <h3><a class="nav-info" href="editacc.php">變更資料</a></h3>
    <h3><a class="nav-info" href="editpwd.php">更改密碼</a></h3>
    <?php
      if($_SESSION['level']>=2){
    ?>
      <h3><a class="nav-info" href="editaccadmin.php">會員管理</a></h3>
		  <h3><a class="nav-info" href="createacc.php">新增會員</a></h3>
		  <h3><a class="nav-info" href="searchresult.php">查詢會員</a></h3>
    <?php
      }
    ?>
	</article>
    <aside class="right_article">
      <div class="bg-style1">
          <h1>更改資料</h1>
          <h2 class="lbl1">登入帳號</h2>
          <input name="m_username" type="text" value="<?php echo $up_username;?>" class="txt">
          <h2 class="lbl1">名稱</h2>
          <input name="m_nick" type="text"  value="<?php echo $up_nickname;?>" class="txt">
          <h2 class="lbl2">性別</h2>
          <select name="m_gender" class="select">
            <option value="男">Male</option>
            <option value="女">Female</option>
            <option value="其他">Other</option>
          </select>
          <h2 class="lbl1">生日</h2>
          <input type="date" id="bday" name="m_bday" value="<?php echo $up_bday;?>" class="day">
          <h2 class="lbl1">電子信箱</h2>
          <input name="m_email" type="text"  value="<?php echo $up_email;?>" class="txt">
          <h2 class="lbl1">手機號碼</h2>
          <input name="m_phone" type="text"  value="<?php echo $up_phone;?>" class="txt">
          <h2 class="lbl1">地址</h2>
          <input type="text" name="m_address" value="<?php echo $up_address;?>" class="txtmap">
          <a href="javascript:;" class="map-link" onclick="showOrHide()">查詢地圖</a>
          <input type="submit" value="確認修改" name="submit" class="btn">
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