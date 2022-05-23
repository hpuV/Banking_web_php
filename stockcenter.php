<?php

include('connect.php');

session_start();

//個人股票 帳戶資料
$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$stockacc = $_SESSION["stockacc"];

$sqlacc = "SELECT * FROM personalstockdata WHERE m_stock = '".$stockacc."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<DOCTYPE html>
<html>
<head>
<title>個人股票</title>
</head>
<body>
<?php
}else{
  echo "非法登入!";
  exit();
}

  $queryString = "SELECT * FROM personalstockdata WHERE m_stock = '".$stockacc."'  ORDER BY p_id ASC";
  $result = mysqli_query($db_link,$queryString);

//mysqli_close($db_link); // 連線結束

?>
<table>
  <tr>
    <td class="title">暱稱: </td>
    <td class="content"><?php echo $nick; ?></td>
  </tr>
  <tr>
    <td class="title">持股編號: </td>
    <td class="content"><?php echo $stockacc; ?></td>
    </td>
  </tr>
  <tr>
    <td class="title">[持股數量] </td>
    </td>
  </tr>
</table>
<table style="width: 60%;" padding= "5" border= '1' >
<tr style="border: 0px;">
    <th>公司名稱</th>
    <th>股數</th>
</tr>
<?php
    for($i=1; $i <= mysqli_num_rows($result); $i++){
        $rs = mysqli_fetch_row($result);
?>
<tr style="border: 0px;">
    <td><?php echo $rs[4]?></td>
    <td><?php echo $rs[5]?></td>
</tr>
<?php
    }
    if (mysqli_num_rows($result) <= 0) {
        echo "<script>alert('搜尋不到任何符合條件的紀錄')</script>";
    }
?>
<tr>
  <td><a href="stocktrade.php?"><input type="button" value="買/賣股票" style = "width:100px; height:30px; font-size: 15px;"></a></td>
</tr>
</table>
</body>
</html>