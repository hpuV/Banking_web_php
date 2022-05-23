<?php

include('connect.php');

session_start();

//黃金存摺 帳戶資料
$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$goldacc = $_SESSION["goldacc"];

$sqlacc = "SELECT * FROM golddata WHERE m_gold = '".$goldacc."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<DOCTYPE html>
<html>
<head>
<title>黃金存摺</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
<table>
  <tr>
    <td class="title">暱稱: </td>
    <td class="content"><?php echo $nick; ?></td>
  </tr>
  <tr>
    <td class="title">黃金交易帳號: </td>
    <td class="content"><?php echo $goldacc; ?></td>
    </td>
  </tr>
  <tr>
    <td class="title">黃金數量: </td>
    <td class="content"><?php echo $row_acc['m_goldnum']; ?></td>
    </td>
  </tr>
  <tr>
  <td><a href="goldtrade.php?"><input type="button" value="買/賣黃金" style = "width:100px; height:30px; font-size: 15px;"></a></td>
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