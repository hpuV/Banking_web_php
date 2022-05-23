<?php

include('connect.php');

session_start();

$nick = $_SESSION["nickname"];
$account = $_SESSION["account"];
$goldacc = $_SESSION["goldacc"];
$stockacc = $_SESSION["stockacc"];
$_SESSION['stockbuynum'] = "1";

//帳號資料
$sqlaccf = "SELECT * FROM financedata WHERE m_account = '".$account."' ";
$resultaccf = mysqli_query($db_link,$sqlaccf);
$row_accf = mysqli_fetch_assoc($resultaccf);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<DOCTYPE html>
<html>
<head>
<title>證券交易</title>
<link href="user.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
  function changebuy(){
    var dis = document.getElementById('divtrade');

    dis.className = dis.className + " redstyle";  // this adds the class
    dis.className = dis.className.replace(" greenstyle", ""); // this removes the class

  }
  function changesell(){
    var dis = document.getElementById('divtrade');

    dis.className = dis.className + " greenstyle";  // this adds the class
    dis.className = dis.className.replace(" redstyle", ""); // this removes the class

  }
  function Hidediv(){
    var dis = document.getElementById('divtrade');

    if(dis.style.display == ''){
      dis.style.display = 'none';
    }else{
      dis.style.display = 'none';
    }
  }
  function Showdiv(){
    var dis = document.getElementById('divtrade');

    if(dis.style.display == ''){
      dis.style.display = '';
    }else{
      dis.style.display = '';
    }
  }
  
</script>
</head>
<body>
<?php
}else{
  echo "非法登入!";
  exit();
}

$companyid = "";
$stockprice = "0";
$companyname = "";

//搜尋股票編號 獲得股票價格
if (isset($_GET['searchid'])) {

  $companyid = $_GET["searchid"];
  
  //公司 股票資料
  $sqlcom = "SELECT * FROM stockdata WHERE s_companyid = '".$companyid."' ";
  $resultcom = mysqli_query($db_link,$sqlcom);
  $row_com = mysqli_fetch_assoc($resultcom);
  
  //股票編號不為空 有股票資料
  if(!empty($row_com['s_id'])){

  $companyname = $row_com['s_company'];

  //股票價格
  //獲取最大編號
  $sqlmaxid = "SELECT MAX(s_id) FROM stockdata WHERE s_companyid = '".$companyid."' ";
  $resultsid = mysqli_query($db_link,$sqlmaxid);
  $row_sid = mysqli_fetch_row($resultsid);
  $sid = $row_sid['0'];

  //獲取價格
  $sqlstock = "SELECT * FROM stockdata WHERE s_id = '".$sid."' ";
  $resultstock = mysqli_query($db_link,$sqlstock);
  $row_stock = mysqli_fetch_assoc($resultstock);
  $stockprice = $row_stock['s_price'];

  $sqlcheck= "SELECT * FROM personalstockdata WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."' GROUP BY s_companyid HAVING count(*) > 0;";
  $resultnorepeat = mysqli_query($db_link,$sqlcheck);
  $row_repeat = mysqli_fetch_assoc($resultnorepeat);
  if(!empty($row_repeat['s_companyid'])){
    //股票資料重複
    //echo "Data Repeat";
  }else{
    //股票資料沒重複
    $sqlpersonstock="INSERT INTO personalstockdata (p_id, m_stock, m_account, s_companyid , s_company, p_stocknum)
            VALUES (NULL ,'".$stockacc."' ,'".$account."' ,'".$companyid."' ,'".$companyname."' ,'0')";
    mysqli_query($db_link,$sqlpersonstock);
    //echo "Data Inserted";
  }

  /*
  echo "<script language=\"JavaScript\">"; 
  echo "Showdiv()";
  echo "</script>";*/

  }else{

    $companyid = "";
    $stockprice = "0";
    $companyname = "查無資料";

    /*
    echo "<script language=\"JavaScript\">"; 
    echo "Hidediv()";
    echo "</script>";*/
    
  }
}

//輸入商品之股票帳號資料
$sqlaccs = "SELECT * FROM personalstockdata WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."';";
$resultaccs = mysqli_query($db_link,$sqlaccs);
$row_accs = mysqli_fetch_assoc($resultaccs);

//增加/減少購買數量
if (isset($_POST['del'])) {
  $_SESSION["stockbuynum"] = $_POST["numPost"]-1;
  if($_SESSION["stockbuynum"] < 1){
    $_SESSION["stockbuynum"] = 1;
  }
}

if(isset($_POST['add'])){
  $_SESSION["stockbuynum"] = $_POST["numPost"]+1;
}

mysqli_select_db($db_link, "phpmember");
  //echo $_POST['onoffswitch'];
  //更新股票買進資料
if(isset($_POST['submittrade'])){
  if(isset($_POST['change'])){
    $decision = $_POST['change'];

    $in_buy= $_POST["numPost"];
    $stocknum = $row_accs['p_stocknum'];
    $trademoney = $stockprice*$in_buy;

    date_default_timezone_set('Asia/Taipei');
    $in_tradetime= date("Y-m-d H:i:s");

      if($decision == "buy"){
      $in_stocknum = $stocknum + $in_buy;
      $in_balance=  $row_accf['m_balance']-$trademoney;

      $in_type= "買進股票";
      $in_note = "買進".$companyname."股票".$in_buy."張";

      //更新帳戶餘額
      $sqlUPdateFinance= "UPDATE financedata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
      $sqlUPdateDebit= "UPDATE debitcarddata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";

      mysqli_query($db_link,$sqlUPdateFinance);
      mysqli_query($db_link,$sqlUPdateDebit);

      //交易紀錄
      $sqltradeacc= "INSERT INTO statementdata 
      VALUE('','$account','$in_balance','0','$trademoney','$in_tradetime','','$in_type','$in_note');";

      mysqli_query($db_link,$sqltradeacc);

      //更新股票資料
      $sqlUPdateStockData= "UPDATE personalstockdata
                  SET p_stocknum = '".$in_stocknum."'
                  WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."';";

      mysqli_query($db_link,$sqlUPdateStockData);

      function_alert($in_note);
    
    }else if($decision == "sell"){
      $in_stocknum = $stocknum - $in_buy;
      //echo $in_stocknum;
      $in_balance=  $row_accf['m_balance']+$trademoney;

      $in_type= "賣出股票";
      $in_note = "賣出".$companyname."股票".$in_buy."張";
    
      //更新帳戶餘額
      $sqlUPdateFinance= "UPDATE financedata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
      $sqlUPdateDebit= "UPDATE debitcarddata
                  SET m_balance= '".$in_balance."'
                  WHERE m_account= '".$account."'; ";
    
      mysqli_query($db_link,$sqlUPdateFinance);
      mysqli_query($db_link,$sqlUPdateDebit);
    
      //交易紀錄
      $sqltradeacc= "INSERT INTO statementdata 
      VALUE('','$account','$in_balance','$trademoney','0','$in_tradetime','','$in_type','$in_note');";
    
      mysqli_query($db_link,$sqltradeacc);

      //更新股票資料
      $sqlUPdateStockData= "UPDATE personalstockdata
                  SET p_stocknum = '".$in_stocknum."'
                  WHERE m_stock= '".$stockacc."' AND s_companyid= '".$companyid."'; ";

      mysqli_query($db_link,$sqlUPdateStockData);

      function_alert($in_note);
    
    }
  }
}

function function_alert($message) {
  // Display the alert box  
  echo "<script>alert('$message');</script>"; 
  return false;
}

?>
<form action="" method="get">
  <tr>
    <td class="title">持股編號: </td>
    <td class="content"><?php echo $stockacc; ?></td><br/><br/>
  </tr>
  <tr>
    <td class="title">商品: </td>
    <td class="content">
      <input name="searchid" type="text"  placeholder="請輸入商品編號" value="<?php echo $companyid;?>"/>
       <?php echo $companyname;?></br>
       <input type="submit" value="搜尋" id="search"/>
    </td>
  </tr>
</form>
<form action="" method="post">
<div>
    <td class="title">買賣: </td> 
</div>
<fieldset>
    <div>
      <input class="radionin" type="radio" id="buy" value="buy" name="change"
             checked>
      <label class="raionlbl" for="buy">買進</label>
    </div>
    <div>
      <input class="radionin" type="radio" id="sell" value="sell" name="change">
      <label class="raionlbl" for="sell">賣出</label>
    </div>
</fieldset>
<div id="divtrade">
    <input type="submit" name="del" value="-" id="del"/>
    <input type="text" name="numPost" value="<?php echo $_SESSION["stockbuynum"]?>" />
    <input type="submit" name="add" value="+" id="add"/>
    <p>價格: <?php echo $stockprice;?></p>
    <input type="submit" value="下單" name="submittrade" id="submittrade"/>
</div>
</form>
<style>
    .greenstyle {
        border:2px green solid;
    }
    .redstyle {
        border:2px red solid;
    }
    p,label .radiolbl{
        
    }

    input .radionin{

    }
</style>
</body>
</html>
