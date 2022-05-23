<?php

include('connect.php');

session_start();

$levelString = array("無","用戶","管理者");

$account= $_SESSION["account"];
$keyWord1 = "";
$fieldString = "";

if (isset($_GET['queryField'])) {
    $queryField = $_GET["queryField"];
    

        if (!strcmp($queryField, "mTwd"))
        {
            $keyWord1 = "轉帳";
            $fieldString = "mTwd";
        }
        else if (!strcmp($queryField, "mStock"))
        {
            $keyWord1 = "股票";
            $fieldString = "mStock";
        }
        else if (!strcmp($queryField, "mGold"))
        {
            $keyWord1 = "黃金";
            $fieldString = "mGold";
        }
}

    if(isset($_GET["sday"])){
        $keyWord2 = $_GET["sday"];
    }else{
        $keyWord2 = "";
    }

    $sqlquery = "SELECT * FROM statementdata WHERE st_tradetype LIKE '%$keyWord1%' AND m_account = $account AND st_tradetime LIKE '%$keyWord2%'";
    $resultnolimit = mysqli_query($db_link,$sqlquery);

    $data_nums = mysqli_num_rows($resultnolimit); //統計總比數
    $per = 5; //每頁顯示項目數量
    $pages = ceil($data_nums/$per); //取得不小於值的下一個整數
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page-1)*$per; //每一頁開始的資料序號

    $queryString = "SELECT * FROM statementdata WHERE st_tradetype LIKE '%$keyWord1%' AND m_account = $account AND st_tradetime LIKE '%$keyWord2%' LIMIT $start, $per"; 
    $resultlimit = mysqli_query($db_link,$queryString);

    $pageFirst= "?queryField=$fieldString&sday=$keyWord2&submit=搜尋&page=1";
    $pageList= "?queryField=$fieldString&sday=$keyWord2&submit=搜尋&page=";

?>
<!DOCTYPE html>
<html>
<head>
    <title>轉帳紀錄系統</title>
	<style>
        
    </style>
</head>
<body>
<form id="search" action="" method="get">
    <tr>
        <td>查詢欄位: </td>
        <td>
            <select name="queryField">
            <option value="mTwd">轉帳交易</option>
            <option value="mStock">股票交易</option>
            <option value="mGold">黃金交易</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="title">日期: </td> 
        <td class="content">
        <input type="month" id="sday" name="sday">
        </td>
    </tr>
<tr><td align="right"><input type="submit" name="submit" value="搜尋"></td></tr>
</form>
<table style="width: 60%;" padding= "5" border= '1'>
<tr style="border: 0px;">
    <th style="text-align: center;">日期</th>
	<th style="text-align: center;">收入</th>
    <th style="text-align: center;">支出</th>
    <th style="text-align: center;">結餘</th>
    <th style="text-align: center;">轉入帳號</th>
    <th style="text-align: center;">類型</th>
    <th style="text-align: center;">註記</th>
</tr>
<?php
//輸出資料內容
while ($row = mysqli_fetch_array ($resultlimit))
{
?>
    
    <tr>
        <td style="text-align: center;"><?php echo $row['st_tradetime']; ?></td>
        <td style="text-align: center;"><?php echo $row['st_income']; ?></td>
        <td style="text-align: center;"><?php echo $row['st_outcome']; ?></td> 
        <td style="text-align: center;"><?php echo $row['m_balance']; ?></td>            
        <td style="text-align: center;"><?php echo $row['st_tradeacc']; ?></td> 
        <td style="text-align: center;"><?php echo $row['st_tradetype']; ?></td> 
        <td style="text-align: center;"><?php echo $row['st_tradenote']; ?></td>
    </tr>

<?php 
    }
?>
</table>
<br/>
<?php
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁';
    echo "<br /><a href=$pageFirst>首頁</a> ";
    echo "第 ";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if ( $page-3 < $i && $i < $page+3 ) {
            echo "<a href=$pageList".$i.">".$i."</a> ";
        }
    } 
    echo " 頁 <a href=$pageList".$pages.">末頁</a><br /><br />";
?>
</body>
</html>