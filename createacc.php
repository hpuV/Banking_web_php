<?php

include('connect.php');

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['level']>=2){
?>
<DOCTYPE html>
<html>
<head>
<title>新增會員</title>
<link href="user.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
  function showOrHide(){
    var dis = document.getElementById('mapid')

    if(dis.style.display == ''){
     dis.style.display = 'none';
    }else{
      dis.style.display = '';
    }
  }
            
</script>
</head>
<body>
 <table>
  <tr class="headbar">
    <td>歡迎<?php
             echo $_SESSION['nickname']; 
           ?>(<a href="logout.php" class="logout">登出</a>)
    </td>
    <td><a href="usercenter.php" class="headStr">個人資料</a></td>
    <td><a href="useradminmanage.php" class="headStr">會員管理</a></td>
    <td class="headNow">
      <a href="createacc.php" class="headStr">新增會員</a>
    <td><a href="searchresult.php?">搜尋會員資料</a></td>
    </td>
  </tr>
 </table><br /><br />
<?php
  }else{
     echo "非法登入!";
     exit();
  }

$settime=strtotime('+7 hours');
$gettime=date('YmdHis',$settime);

if(!empty($_POST['m_username'])){
  $in_username= $_POST['m_username'];
  $in_password= $_POST['m_password'];
  $in_nickname=$_POST['m_nick'];
  $in_level= $_POST['m_level'];
  $in_gender= $_POST['m_gender'];
  $in_bday= $_POST['m_bday'];
  $in_email= $_POST['m_email'];
  $in_phone= $_POST['m_phone'];
  $in_address= $_POST['m_address'];

  $in_account = rand(10,99999999);
  $in_account = sprintf("%09d",$in_account);

    $sql="INSERT INTO memberdata 
          VALUE(NULL,'$in_account','$in_username','$in_password','$in_nickname','$in_level','$in_gender','$in_bday','$in_email','$in_phone','$in_address');";
    mysqli_query($db_link,$sql);
}
?>
<form action="" method="post"  enctype="multipart/form-data">
<div class="form">
  <tr>
    <td class="title">性別：</td> 
      <td class="content">
        <select name="m_gender" />
          <option value="男">男性</option>
          <option value="女">女性</option>
          <option value="其他">其他</option>
        </select><br/><br/>
      </td>
    </tr>
  <tr>
    <td class="title">生日：</td> 
      <td class="content">
        <input type="date" id="bday" name="m_bday" value=""><br/><br/>
      </td>
  </tr>
  <tr>
    <td class="title">Email: </td> 
    <td class="content">
      <input name="m_email" type="text"  value="" /><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">電話: </td> 
    <td class="content">
      <input name="m_phone" type="text"  value="" /><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">住址：</td> 
      <td class="content">
        <input type="text" name="m_address" value="">
          <a href="javascript:;" onclick="showOrHide()">查詢地圖</a><br/><br/>
      </td>
  </tr>
  <tr>
    <td class="title">帳號: </td>
    <td class="content">
       <input name="m_username" type="text" value="" /><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">密碼</td>
    <td class="content"><input name="m_password" type="password" value="" /></td><br/><br/>
  </tr>
  <tr>
    <td class="title">暱稱: </td> 
    <td class="content">
      <input name="m_nick" type="text"  value="" /><br/><br/>
    </td>
  </tr>
  <tr>
    <td class="title">等級</td>
    <td class="content">
      <select name="m_level" />
        <option value="0">無</option>
        <option value="1">用戶</option>
        <option value="2">管理者</option>
      </select><br/><br/>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center;">
      <input name="" type="submit" value="確認新增" />
    </td>
  </tr>
  </div>
</form>
<form>
  <div id="mapid" style="display: none" class="map">
    <iframe
      src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3681.674937442897!2d120.50265221479374!3d22.665905285134848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346e178cae0b7a29%3A0x50bf59e1705a0a73!2z5ZyL56uL5bGP5p2x5aSn5a245rCR55Sf5qCh5Y2A!5e0!3m2!1szh-TW!2stw!4v1651384709604!5m2!1szh-TW!2stw"
      width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
      <!-- 嵌入 Google map -->
  </div>
</form>
<style>
  .map{
    float: left;
    width:600px;
    line-height:50px;
    padding:20px;
  }
  .form{
    display: inline-block;
    width: 350px;        
    line-height: 20px;
    padding:20px;
    float: left;
    margin-right:10px;
  }
</style>
</form>
</body>
</html>
