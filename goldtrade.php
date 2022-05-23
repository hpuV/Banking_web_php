<?php

include('connect.php');

session_start();

$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$goldacc = $_SESSION["goldacc"];

//帳號資料
$sqlaccf = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$resultaccf = mysqli_query($db_link,$sqlaccf);
$row_accf = mysqli_fetch_assoc($resultaccf);

//黃金存摺 帳戶資料
$sqlacc = "SELECT * FROM golddata WHERE m_gold = '".$goldacc."' ";
$resultacc = mysqli_query($db_link,$sqlacc);
$row_acc = mysqli_fetch_assoc($resultacc);

//黃金價格
//獲取最大編號
$sqlmaxid = "SELECT MAX(gp_id) FROM goldpricedata";
$resultgpid = mysqli_query($db_link,$sqlmaxid);
$row_gpid = mysqli_fetch_row($resultgpid);
$gpid = $row_gpid['0'];


//獲取價格
$sqlgold = "SELECT * FROM goldpricedata WHERE gp_id = '".$gpid."' ";
$resultgold = mysqli_query($db_link,$sqlgold);
$row_gold = mysqli_fetch_assoc($resultgold);
$goldprice = $row_gold['g_price'];

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<DOCTYPE html>
<html>
<head>
<title>黃金交易</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
}else{
   echo "非法登入!";
   exit();
}

if(isset($_POST['g_buygold'])){
  if(!empty($_POST['g_buygold'])){
    $in_buygold= $_POST['g_buygold'];
    
    $goldnum = $row_acc['m_goldnum'];
    $in_goldnum = $goldnum + $in_buygold;
    $trademoney = $goldprice*$in_buygold;
    $in_balance=  $row_accf['m_balance']-$trademoney;

    date_default_timezone_set('Asia/Taipei');
    $in_tradetime= date("Y-m-d H:i:s");

    $in_type= "買進黃金";
    $in_note = "買進".$in_buygold."個黃金";

    mysqli_select_db($db_link, "phpmember");

    //交易紀錄、更新帳戶餘額
    $sqltradeacc= "INSERT INTO statementdata 
    VALUE(NULL,'$account','$in_balance','0','$trademoney','$in_tradetime','','$in_type','$in_note');";

    mysqli_query($db_link,$sqltradeacc);

    $sqlUPdateFinance= "UPDATE financedata
                SET m_balance= '".$in_balance."'
                WHERE m_account= '".$account."'; ";
    $sqlUPdateDebit= "UPDATE debitcarddata
                SET m_balance= '".$in_balance."'
                WHERE m_account= '".$account."'; ";

    mysqli_query($db_link,$sqlUPdateFinance);
    mysqli_query($db_link,$sqlUPdateDebit);

    //更新黃金資料
    $sqlUPdateGoldData= "UPDATE golddata
                SET m_goldnum= '".$in_goldnum."'
                WHERE m_gold= '".$goldacc."'; ";

    mysqli_query($db_link,$sqlUPdateGoldData);

  }else{
    $in_buygold = "0";
  }

  header("location:mainpage.php");
}

if(isset($_POST['g_sellgold'])){
  if(!empty($_POST['g_sellgold'])){
    $in_sellgold= $_POST['g_sellgold'];

    $goldnum = $row_acc['m_goldnum'];
    $in_goldnum = $goldnum - $in_sellgold;
    $trademoney = $goldprice*$in_sellgold;
    $in_balance=  $row_accf['m_balance']+$trademoney;

    date_default_timezone_set('Asia/Taipei');
    $in_tradetime= date("Y-m-d H:i:s");

    $in_type= "賣出黃金";
    $in_note = "賣出".$in_sellgold."個黃金";

    mysqli_select_db($db_link, "phpmember");

    //交易紀錄、更新帳戶餘額
    $sqltradeacc= "INSERT INTO statementdata 
    VALUE(NULL,'$account','$in_balance','$trademoney','0','$in_tradetime','','$in_type','$in_note');";

    mysqli_query($db_link,$sqltradeacc);

    $sqlUPdateFinance= "UPDATE financedata
                SET m_balance= '".$in_balance."'
                WHERE m_account= '".$account."'; ";
    $sqlUPdateDebit= "UPDATE debitcarddata
                SET m_balance= '".$in_balance."'
                WHERE m_account= '".$account."'; ";

    mysqli_query($db_link,$sqlUPdateFinance);
    mysqli_query($db_link,$sqlUPdateDebit);

    //更新黃金資料
    $sqlUPdateGoldData= "UPDATE golddata
                SET m_goldnum= '".$in_goldnum."'
                WHERE m_gold= '".$goldacc."'; ";

    mysqli_query($db_link,$sqlUPdateGoldData);
  }else{
    $in_sellgold = "0";
  }

  header("location:mainpage.php");
}

?>
<form action="" method="post" enctype="multipart/form-data">
  <tr>
    <td class="title">黃金交易帳號: </td>
    <td class="content"><?php echo $goldacc; ?></td><br/><br/>
  </tr>
  <tr>
    <td class="title">黃金持有數量: </td>
    <td class="content"><?php echo $row_acc['m_goldnum']; ?></td><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">黃金價格: </td> 
    <td class="content"><?php echo $goldprice; ?></td><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">購買黃金: </td> 
    <td class="content">
      <input name="g_buygold" type="text"/><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">賣出黃金: </td> 
    <td class="content">
      <input name="g_sellgold" type="text"/><br/><br/>
    </td>
  </tr>
  <tr>
    <td>
      <input type="submit" value="提交" />
    </td>
  </tr>
</form>
</body>
</html>
