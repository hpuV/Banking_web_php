<?php

include('connect.php');

session_start();

//轉出帳號資料(這個登入者)
$account = $_SESSION["account"];
$sqlout = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$resultout = mysqli_query($db_link,$sqlout);
$row_accout = mysqli_fetch_assoc($resultout);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<DOCTYPE html>
<html>
<head>
<title>臺幣轉帳</title>
<link href="user.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
}else{
  echo "非法登入!";
  exit();
 }

if(isset($_POST['c_accin'])){
  //更新資料
  $in_accin= $_POST['c_accin'];
  $in_amount= $_POST['c_amountin'];
  $in_note= $_POST['c_notein'];
  $in_type= "臺幣轉帳";
  $in_balanceOutacc= $row_accout['m_balance']-$in_amount;

  date_default_timezone_set('Asia/Taipei');
  $in_tradetime= date("Y-m-d H:i:s");

  //轉入帳號資料
  $account = $_SESSION["account"];
  $sqlin = "SELECT * FROM financedata WHERE m_account = '".$in_accin."' ";
  $resultin = mysqli_query($db_link,$sqlin);
  $row_accin = mysqli_fetch_assoc($resultin);
  $in_balanceInacc= $row_accin['m_balance']+$in_amount;

  mysqli_select_db($db_link, "phpmember");

  //轉出帳號(這個登入者)
  //編號 帳號出 餘額 收入 支出 時間 帳號入 註記
  $sqlOutacc= "INSERT INTO statementdata 
  VALUE(NULL,'$account','$in_balanceOutacc','0','$in_amount','$in_tradetime','$in_accin','$in_type','$in_note');";
  
  //轉入帳號
  //編號 帳號入 餘額 收入 支出 時間 帳號出 註記
  $sqlInacc= "INSERT INTO statementdata 
  VALUE(NULL,'$in_accin','$in_balanceInacc','$in_amount','0','$in_tradetime','$account','$in_type','$in_note');";

  mysqli_query($db_link,$sqlOutacc);
  mysqli_query($db_link,$sqlInacc);

  //更新資料financedata, debitcarddata - 轉出帳號(這個登入者)
  $sqlUPdateFinanceOut= "UPDATE financedata
              SET m_balance= '".$in_balanceOutacc."'
              WHERE m_account= '".$account."'; ";
  $sqlUPdateDebitOut= "UPDATE debitcarddata
              SET m_balance= '".$in_balanceOutacc."'
              WHERE m_account= '".$account."'; ";

  mysqli_query($db_link,$sqlUPdateFinanceOut);
  mysqli_query($db_link,$sqlUPdateDebitOut);
  
  //更新資料financedata, debitcarddata - 轉入帳號
  $sqlUPdateFinanceIn= "UPDATE financedata
              SET m_balance= '".$in_balanceInacc."'
              WHERE m_account= '".$in_accin."'; ";
  $sqlUPdateDebitIn= "UPDATE debitcarddata
              SET m_balance= '".$in_balanceInacc."'
              WHERE m_account= '".$in_accin."'; ";

  mysqli_query($db_link,$sqlUPdateFinanceIn);
  mysqli_query($db_link,$sqlUPdateDebitIn);
  header("location:mainpage.php");
}

?>
<form action="" method="post" enctype="multipart/form-data">
<div class="form">
  <tr>
    <td class="title">轉出帳號: </td>
    <td class="content"><?php echo $account; ?></td><br/><br/>
  </tr>
  <tr>
    <td class="title">可用餘額: </td>
    <td class="content"><?php echo $row_accout['m_balance']; ?></td><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">轉入帳號: </td> 
    <td class="content">
      <input name="c_accin" type="text" placeholder="銀行代碼/帳號"/><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">轉入金額: </td> 
    <td class="content">
      <input name="c_amountin" type="text"/><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">註記: </td>
    <td class="content">
      <input name="c_notein" type="text" placeholder="顯示於交易紀錄限7個字"/><br/><br/>
    </td>
  </tr>
  <tr>
    <td>
      <input type="submit" value="提交" />
    </td>
  </tr>
  </div>
</form>
</body>
</html>
