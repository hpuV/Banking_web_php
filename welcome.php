<?php
session_start();  //很重要，可以用的變數存在session裡
$nick = $_SESSION["nickname"];
echo "<h1>您好  ".$nick."</h1>";
echo "<a href='usercenter.php'>用戶中心</a><br>";
echo "<a href='logout.php'>登出</a>";
?>