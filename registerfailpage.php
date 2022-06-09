<?php
	header("Refresh: 10; url=register.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ATBC Banking</title>
<link rel="icon" href="img/ATBClogo.ico" type="image/x-icon">
<link rel="shortcut icon" href="img/ATBClogo.ico" type="image/x-icon">
<link href="css/mainpagestyle.css" rel="stylesheet" type="text/css">
<link href="css/registernextpagestyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <div class="cssload-loader">
		<div class="cssload-inner cssload-one"></div>
		<div class="cssload-inner cssload-two"></div>
		<div class="cssload-inner cssload-three"></div>
	  </div>
  <section>
    <article class="succ_article">
	  <div class="bg-style1" href="#">
		  <h1 class="lbl1">Account has been used!</h1>
		  <h2>3秒後將自動跳轉頁面</h2>
		  <h2 class="lbl2"><a href="register.php" class="lbl-link">未成功跳轉頁面請點擊此</a></h2>
       </div>
    </article>
	</section>

</div>
</body>
</html>
