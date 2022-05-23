<?php

include('connect.php');

session_start();

$sqlcompanyid = "SELECT * FROM stockdata ORDER BY s_id ASC;";
$resultsid = mysqli_query($db_link,$sqlcompanyid);

?>
<DOCTYPE html>
<html>
<head>
<title>股票價格</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
<table style="width: 60%;" padding= "5" border= '1'>
<tr style="border: 0px;">
    <th style="text-align: center;">公司編號</th>
	  <th style="text-align: center;">公司名稱</th>
    <th style="text-align: center;">股/元</th>
    <th style="text-align: center;">更新時間</th>
</tr>
    <?php
      for($i=1; $i <= mysqli_num_rows($resultsid); $i++){
        $rs = mysqli_fetch_row($resultsid);
    ?>
    <tr>
        <td style="text-align: center;"><?php echo $rs[1] ?></td>
        <td style="text-align: center;"><?php echo $rs[2] ?></td>
        <td style="text-align: center;"><?php echo $rs[3] ?></td>
        <td style="text-align: center;"><?php echo $rs[4] ?></td>
    </tr>
    <?php
      }
    ?>
</table>
</body>
</html>

