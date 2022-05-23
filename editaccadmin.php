<?php

include('connect.php');

session_start();

$account = $_SESSION["account"];
$sql = "SELECT * FROM memberdata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
$row_Login = mysqli_fetch_assoc($result);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['level']>=2){
?>
<DOCTYPE html>
<html>
<head>
<title>修改會員資料</title>
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
  <td class="headNow"><a href="useradminmanage.php" class="headStr">會員管理</a></td>
  <td><a href="createacc.php" class="headStr">新增會員</a></td>
 </tr>
</table><br /><br />
<?php
}else{
  echo "非法登入!";
  exit();
 }
if(isset( $row_Login['m_account'])){
  $up_id= $row_Login['m_id'];
  $up_account= $row_Login['m_account'];
  $up_username= $row_Login['m_username'];
  $up_nickname= $row_Login['m_nick'];
  $up_level= $row_Login['m_level'];
}else{
  $up_username= "";
  $up_nickname= "";
  $up_level= "1";
}

if(isset($_POST['m_username'])){
  $up_username= $_POST['m_username'];
  $up_nick= $_POST['m_nick'];
  $up_level= $_POST['m_level'];
  $sqlUPdate= "UPDATE memberdata
        SET m_username= '.$up_username.',
            m_level= '.$up_level.',
            m_nick= '.$up_nickname.'
            WHERE m_account= '.$up_account.'; ";
  
  mysqli_select_db($db_link, "phpmember");
  mysqli_query($db_link,$sqlUPdate);
  header("location:useradminmanage.php");
}

?>
<form action="" method="post" enctype="multipart/form-data">
<table class="edituser">
  <tr>
    <td class="title">帳號</td>
    <td class="content">
       <input name="m_username" type="text" value="<?php echo $up_username;?>" />
    </td>
      <input name="m_id" type="hidden" value="<?php echo $up_id;?>" />
    </td>
  </tr>
  <tr>
    <td class="title">暱稱</td> 
    <td class="content">
      <input name="m_nick" type="text" value="<?php echo $up_nickname;?>" />
    </td>
  </tr>
  <tr>
    <td class="title">等級</td>
    <td class="content">
      <select name="level" />
        <option value="0" <?php echo ($up_level==0)?"selected":"";; ?>>無</option>
        <option value="1" <?php echo ($up_level==1)?"selected":"";; ?>>用戶</option>
        <option value="2" <?php echo ($up_level==2)?"selected":"";; ?>>管理者</option>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <input name="" type="submit" value="確認修改" />
    </td>
  </tr>
</table>
</form>
</body>
</html>
