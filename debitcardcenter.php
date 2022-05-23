<?php

include('connect.php');

session_start();

$account = $_SESSION["account"];
$sql = "SELECT * FROM debitcarddata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
$row_Login = mysqli_fetch_assoc($result);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<DOCTYPE html>
<html>
<head>
<title>會員中心</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
 <table class="userInfo">
  <tr>
    <td class="colTitle">金融卡卡號: </td>
    <td class="colLeft"><?php echo $row_Login['m_cardid']; ?></td>
  </tr>
  <tr>
    <td class="colTitle">連結主帳號: </td>
    <td class="colLeft"><?php echo $row_Login['m_account']; ?></td>
  </tr>
  <tr>
    <td class="colTitle">有效日期: </td>
    <td class="colLeft"><?php echo $row_Login['m_expdate']; ?></td>
  </tr>
  <tr>
    <td class="colTitle">安全碼: </td>
    <td class="colLeft"><?php echo $row_Login['m_safecode']; ?></td>
  </tr>
 </table>
</body>
</html>
<?php
  }else{
     echo "非法登入!";
     exit();
}
?>
　
