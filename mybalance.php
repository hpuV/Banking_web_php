<?php

include('connect.php');

session_start();

$username = $_SESSION["username"];
$levelNum = $_SESSION["level"];
$account = $_SESSION["account"];

$sql = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$result = mysqli_query($db_link,$sql);
$row_Login = mysqli_fetch_assoc($result);

$levelString = array("無","用戶","管理者");

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

?>
<DOCTYPE html>
<html>
<head>
<title>會員中心</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
 <table>
  <tr class="headbar">
    <td><a href="twdtransfer.php">臺幣轉帳</a></td>
    <td><a href="statementsearch.php">收支管理</a></td>
  </tr>
 </table><br /><br />
 <table class="userInfo">
  <tr>
    <td class="colTitle">銀行帳號: </td>
    <td class="colLeft"><?php echo $account; ?></td>
  </tr>
  <tr>
    <td class="colTitle">臺幣帳戶餘額: </td>
    <td class="colLeft"><?php echo $row_Login["m_balance"]; ?></td>
  </tr>
  <tr>
    <td><a href='debitcardcenter.php'>
      <input type="button" value="金融卡卡片管理" style = "width:120px; height:30px; font-size: 15px;">
    </a></td>
</tr>
</table>
<?php
  }else{
     echo "非法登入!";
     exit();
}
?>
</body>
</html>

