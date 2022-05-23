<?php

include('connect.php');

session_start();

$levelString = array("無","用戶","管理者");

if (isset($_GET['queryString'])) {
    $queryField = $_GET["queryField"];
    $keyWord = $_GET["queryString"];
    $searchField = "";

    if (!strcmp($queryField, "mId"))
        {
            $searchField = "m_id";
        }
        else if (!strcmp($queryField, "mAccount"))
        {
            $searchField = "m_account";
        }
        else if (!strcmp($queryField, "mUsername"))
        {
            $searchField = "m_username";
        }
        else if (!strcmp($queryField, "mNickname"))
        {
            $searchField = "m_nick";
        }
        else if (!strcmp($queryField, "mLevel"))
        {
            $searchField = "m_level";
        }
        else if (!strcmp($queryField, "mGender"))
        {
            $searchField = "m_gender";
        }
        else if (!strcmp($queryField, "mBday"))
        {
            $searchField = "m_birthday";
        }
        else if (!strcmp($queryField, "mEmail"))
        {
            $searchField = "m_email";
        }
        else if (!strcmp($queryField, "mPhone"))
        {
            $searchField = "m_phone";
        }
        else if (!strcmp($queryField, "mAddress"))
        {
            $searchField = "m_address";
        }
        else
        {
            // nothing to do 
        }

        $queryString = "SELECT * FROM memberdata WHERE $searchField LIKE '%$keyWord%'";
        $result = mysqli_query($db_link,$queryString);

}else{
    $queryString = "SELECT * FROM memberdata";
    $result = mysqli_query($db_link,$queryString);
}

mysqli_close($db_link); // 連線結束

?>
<!DOCTYPE html>
<html>
<head>
    <title>搜尋系統</title>
	<style>
        
    </style>
</head>
<body>
<table>
 <tr class="headbar">
   <td>歡迎<?php
            echo $_SESSION['nickname'];
            ?>(<a href="logout.php" class="logout">登出</a>)</td>
   <td><a href="usercenter.php" class="headStr">個人資料</a></td>
   <td class="headNow"><a href="useradminmanage.php" class="headStr">會員管理</a></td>
   <td><a href="createacc.php" class="headStr">新增會員</a></td>
   <td><a href="searchresult.php?">搜尋會員資料</a></td>
 </tr>
</table><br/>
<form action="" method="get">
    <tr>
        <td>查詢欄位</td>
        <td>
            <select name="queryField">
            <option value="mId">用戶編號</option>
            <option value="mAccount">銀行帳戶</option>
            <option value="mUsername">使用者名稱</option>
            <option value="mNickname">暱稱</option>
            <option value="mLevel">等級</option>
            <option value="mGender">性別</option>
            <option value="mBday">生日</option>
            <option value="mEmail">email</option>
            <option value="mPhone">電話</option>
            <option value="mAddress">住址</option>
            </select>
        </td>
    </tr>
    <tr><td>搜尋內容: </td><td><input type="text" name="queryString" size="20"></td></tr>
    <tr><td></td><td align="right"><input type="submit" name="submit" value="搜尋"></td></tr>
    <br><br>

</form>
<table style="width: 60%;" padding= "5" border= '1' >
<tr style="border: 0px;">
	<th>用戶編號</th>
	<th>銀行帳號</th>
    <th>使用者名稱</th>
    <th>密碼</th>
    <th>暱稱</th>
    <th>等級</th>
    <th>性別</th>
	<th>生日</th>
	<th>Email</th>
    <th>電話號碼</th>
    <th>地址</th>
</tr>
<?php
    for($i=1; $i <= mysqli_num_rows($result); $i++){
        $rs = mysqli_fetch_row($result);
?>
<tr style="border: 0px;">
    <td><?php echo $rs[0]?></td>
    <td><?php echo $rs[1]?></td>
    <td><?php echo $rs[2]?></td>
    <td><?php echo $rs[3]?></td>
    <td><?php echo $rs[4]?></td>
    <td><?php echo $rs[5]?></td>
    <td><?php echo $rs[6]?></td>
    <td><?php echo $rs[7]?></td>
    <td><?php echo $rs[8]?></td>
    <td><?php echo $rs[9]?></td>
    <td><?php echo $rs[10]?></td>
</tr>
<?php
    }
    if (mysqli_num_rows($result) <= 0) {
        echo "<script>alert('搜尋不到任何符合條件的紀錄')</script>";
    }
?>
</table>
</body>
</html>