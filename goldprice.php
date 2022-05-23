<?php

include('connect.php');

session_start();

//黃金價格
//獲取價格
$sqlgold = "SELECT * FROM goldpricedata ";
$resultgold = mysqli_query($db_link,$sqlgold);
$row_gold = mysqli_fetch_assoc($resultgold);
$stockprice = $row_gold['g_price'];
$updatetime = $row_gold['g_date'];

?>
<DOCTYPE html>
<html>
<head>
<title>黃金價格</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
<table class="userInfo">
  <tr>
    <td class="colTitle">更新時間: </td>
    <td class="colLeft"><?php echo $updatetime; ?></td>
  </tr>
  <tr>
    <td class="colTitle">每公克/價格: </td>
    <td class="colLeft"><?php echo $stockprice; ?></td>
  </tr>
</table>
</body>
</html>

