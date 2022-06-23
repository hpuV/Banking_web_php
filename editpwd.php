<?php

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content..="width=device-width, initial-scale=1">
<title>ATBC Banking - 更改密碼</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/editpwdstyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body onload="changeImg()">
<div class="container">
  <header>
	 <nav class="primary_header" id="menu">
      <ul>
        <a class="h1title">Banking</a>
        <li><a class="nav-link" href="mainpage.php">首頁</a></li>
        <li><a class="nav-link" href="goldprice.php">黃金價格</a></li>
        <li><a class="nav-link" href="stockprice.php">股票價格</a></li>
        <li><a class="nav-link" href="userdeter.php">會員中心</a></li>
        <li><a class="nav-link" href="statementsearch.php">收支查詢</a></li>
		    <li><a class="nav-link" href="logout.php">登出</a></li>
      </ul>
    </nav>
  </header>
  <section>
    <div class="top-box"></div>
      <article class="left_article">
        <?php
          session_start();

          if($_SESSION['level']>=2){
        ?>
          <h3 class="toph3"><a class="nav-info" href="useradmincenter.php">個人資料</a></h3>
        <?php
          }else{
        ?>
          <h3 class="toph3"><a class="nav-info" href="usercenter.php">個人資料</a></h3>
        <?php
          }
        ?>
        <h3><a class="nav-info" href="editacc.php">變更資料</a></h3>
        <h3><a class="nav-info" href="editpwd.php">更改密碼</a></h3>
        <?php
          if($_SESSION['level']>=2){
        ?>
        <h3><a class="nav-info" href="editaccadmin.php">會員管理</a></h3>
		    <h3><a class="nav-info" href="createacc.php">新增會員</a></h3>
		    <h3><a class="nav-info" href="searchresult.php">查詢會員</a></h3>
        <?php
          }
        ?>
      </article>
      <aside class="right_article">
        <form method="post" enctype="multipart/form-data" action= "verifypwd.php" onsubmit= "return check()">
        <div class="bg-style1">
          <h1>更改密碼</h1>
          <div class="pwd_bar">
            <h2>請輸入舊密碼</h2>
              <input type="password" name="old_password" id="old_password" class="txt">
            <h2>新密碼</h2>
              <input type="password" name="new_password" id="new_password" class="txt">
          </div>
          <div class="verify_bar">
            <input type="text" id="incode" placeholder="驗證碼" onfocus="this.value=''" onblur="if(this.value=='')this.value='驗證碼'" /><span
            id="code" title="看不清，換一張"></span>
            <div id="search_pass_link">
            </div>
            <input type="submit" id="submit" value="更改" class="btns" onmouseover="this.style.backgroundColor='#FBD534'" onmouseout="this.style.backgroundColor='#FEE45C'">
          </div>
          </div>
        </form>
        <div class="clearfix"></div>
        <div class="content-box"></div>
      </aside>
	</section>
  <footer class="tertiary_header footer">
    <div class="copyright">Copyright &copy;<strong> Chin-An Liu.</strong> All rights reserved.</div>
  </footer>
</div>
</body>
<script type="text/javascript">
		var code; //聲明一個變量用於存儲生成的驗證碼
		document.getElementById("code").onclick = changeImg;

		function changeImg() {
			var arrays = new Array(

				'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',

				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',

				'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',

				'u', 'v', 'w', 'x', 'y', 'z',

				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',

				'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',

				'U', 'V', 'W', 'X', 'Y', 'Z'

			);

			code = ''; //重新初始化驗證碼
			//alert(arrays.length);
			//隨機從數組中獲取四個元素組成驗證碼
			for (var i = 0; i < 4; i++) {
				//隨機獲取一個數組的下標
				var r = parseInt(Math.random() * arrays.length);
				code += arrays[r];
			}
			document.getElementById('code').innerHTML = code; //將驗證碼寫入指定區域

		}

		//效驗驗證碼(表單被提交時觸發)
		function check() {

			//獲取用戶輸入的驗證碼
			var input_code = document.getElementById('incode').value;

			if (input_code.toLowerCase() == code.toLowerCase()) {
				//驗證碼正確(表單提交)
        //alert("成功!");
				return true;

			}else{
			    alert("請輸入正確的驗證碼!");
			    //驗證碼不正確,表單不允許提交

			    return false;
            }

		}
	</script>
</html>
<?php
    }else{
        echo "非法登入!";
        exit();
      }
?>