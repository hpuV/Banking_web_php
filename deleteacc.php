<?php

include('connect.php');

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['level']>=2){
?>
<DOCTYPE html>
<html>
<head>
<title>刪除會員資料</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
<table>
 <tr class="headbar">
  <td>歡迎<?php
          echo $_SESSION['nickname']; 
          ?>(<a href="logout.php" class="logout">登出</a>)
  </td>
  <td><a href="usercenter.php" class="headStr">個人資料</a></td>
  <td class="headNow"><a href="editaccadmin.php" class="headStr">會員管理</a></td>
  <td><a href="createacc.php" class="headStr">新增會員</a></td>
 </tr>
</table><br /><br />
<?php
}else{
  echo "非法登入!";
  exit();
 }

$de_account = $_SESSION["sess_account"];
//echo $de_id;
$sqlDelete= "DELETE FROM memberdata WHERE m_account = '".$de_account."'";
mysqli_select_db($db_link, "phpmember");

if(array_key_exists("yes",$_POST)){
  mysqli_query($db_link,$sqlDelete);
  header("location:editaccadmin.php");
}

if(array_key_exists("no",$_POST)){
  header("location:editaccadmin.php");
}

?>
<form method="post">
<table class="deleteuser">
  <tr>
    <td colspan="2" align="center">是否要刪除帳號</td>
  </tr>
  <tr>
    <td>
      <input name="yes" type="submit" value="是" />
    </td>
    <td>
      <input name="no" type="submit" value="否" />
    </td>
  </tr>
</table>
</form>
</body>
</html>
