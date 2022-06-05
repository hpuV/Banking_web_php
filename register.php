<?php

include('connect.php');

if($_SERVER["REQUEST_METHOD"]=="POST"){
    //memberdata
    $username= $_POST["username"];
    $password= $_POST["password"];
    $nickname= $_POST["nickname"];
    $gender= $_POST["gender"];
    $bday= $_POST["bday"];
    $email= $_POST["email"];
    $phone= $_POST["phone"];
    $address= $_POST["address"];

    $account = rand(0,99999999);
    $account = sprintf("%08d",$account);
    //finance
    $gold = rand(10000000,99999999);
    $cardid = rand(1000000000000000,9999999999999999);
    $stock = rand(10000000,99999999);

    //creditcard
    $safecode = rand(0,999);
    $safecode = sprintf("%03d",$safecode);

    date_default_timezone_set('Asia/Taipei');
    $year = date("Y")+3;
    $expday = $year."/".date('m/d');


    //新增帳號: 會員資料(memberdata) 資產(finance) 信用卡(debitcard) 黃金(gold) 股票(stock)
    $check="SELECT * FROM memberdata WHERE m_username='".$username."'";
    if(mysqli_num_rows(mysqli_query($db_link,$check))==0){
        $sqlmember="INSERT INTO memberdata (m_id, m_account , m_username, m_password, m_nick , m_level , m_gender , m_birthday , m_email , m_phone , m_address)
            VALUES(NULL ,'".$account."' ,'".$username."' ,'".$password."' ,'".$nickname."' , '0' ,'".$gender."' ,'".$bday."','".$email."','".$phone."','".$address."')";
        $sqlfinance="INSERT INTO financedata (f_id, m_swiftcode, m_account , m_balance, m_creditbalance, m_gold , m_cardid , m_stock)
            VALUES (NULL ,'868' ,'".$account."' ,'0'  ,'0' , '".$gold."' ,'".$cardid."' ,'".$stock."')";
        $sqldebitcard="INSERT INTO debitcarddata (d_id, m_cardid, m_account , m_expdate, m_safecode, m_creditbalance)
            VALUES (NULL ,'".$cardid."' ,'".$account."' ,'".$expday."' ,'".$safecode."' ,'0')";
        $sqlgold="INSERT INTO golddata (g_id, m_gold, m_goldnum)
            VALUES (NULL ,'".$gold."' ,'0')";
        
        $sql2330="INSERT INTO personalstockdata 
        VALUES (NULL,'".$stock."','".$account."','2330','臺積電','0');";
        $sql3008="INSERT INTO personalstockdata 
        VALUES (NULL,'".$stock."','".$account."','3008','大立光','0');";
        $sql2409="INSERT INTO personalstockdata 
        VALUES (NULL,'".$stock."','".$account."','2409','友達','0');";
        $sql2603="INSERT INTO personalstockdata 
        VALUES (NULL,'".$stock."','".$account."','2603','長榮','0');";
        $sql0050="INSERT INTO personalstockdata 
        VALUES (NULL,'".$stock."','".$account."','0050','元大臺灣50','0');";

        mysqli_query($db_link, $sqlfinance);
        mysqli_query($db_link, $sqldebitcard);
        mysqli_query($db_link, $sqlgold);

        mysqli_query($db_link, $sql2330);
        mysqli_query($db_link, $sql3008);
        mysqli_query($db_link, $sql2409);
        mysqli_query($db_link, $sql2603);
        mysqli_query($db_link, $sql0050);

        if(mysqli_query($db_link, $sqlmember)){
            header("location: registersuccpage.php");
        }else{
            echo "Error creating table: " . mysqli_error($db_link);
        }
    }
    else{
        header("location: registerfailpage.php");
    }
}


mysqli_close($db_link);

function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
    </script>"; 
    
    return false;
} 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>註冊頁面</title>
<script type="text/javascript">
    function validateForm() {
                var x = document.forms["registerForm"]["password"].value;
                var y = document.forms["registerForm"]["password_check"].value;
                if(x.length<6){
                    alert("密碼長度不足");
                    return false;
                }
                if (x != y) {
                    alert("請確認密碼是否輸入正確");
                    return false;
                }
    }

	function showOrHide(){
		var dis = document.getElementById('mapid');

		if(dis.style.display == ''){
			dis.style.display = 'none';
		}else{
			dis.style.display = '';
		}
	}
</script>
<link href="css/registerpagestyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="registerForm" method="post" action="register.php" onsubmit="return validateForm()">
<div class="container">
  <section>
    <article class="left_article">
	  <div class="bg-style1" href="#">
   	    <h1>Banking</h1>
		  <h2 class="lbl1">Name</h2>
		  <input type="text" name="nickname" id="nickname" class="txt">
		  <h2 class="lbl2">Gender</h2>
		  <select name="gender" class="select">
          	<option value="男">Male</option>
          	<option value="女">Female</option>
          	<option value="其他">Other</option>
          </select>
		  <h2 class="lbl1">Birthday</h2>
		  <input type="date" id="bday" name="bday" class="day">
		  <h2 class="lbl1">Email address</h2>
		  <input type="text" name="email" class="txt">
		  <h2 class="lbl1">Phone Number</h2>
		  <input type="text" name="phone" class="txt">
		  <h2 class="lbl1">Address</h2>
		  <input type="text" name="address" class="txtmap">
		  <a href="javascript:;" class="map-link" onclick="showOrHide()">search address</a>
		  <h2 class="lbl1">Username</h2>
		  <input type="text" name="username" class="txt">
		  <h2 class="lbl1">Password</h2>
		  <input type="password" name="password" id="password" class="txt">
		  <h2 class="lbl1">Confirm Password</h2>
		  <input type="password" name="password_check" id="password_check" class="txt">
		  <input type="submit" value="Register" name="submit" class="btn">
      	  <input type="reset" value="Reset" name="reset" class="btn2">
		  <a href="index.php" ><input type="button" value="Return to Login" class="btn2"></a>
       </div>
    </article>
	  <aside class="right_article">
	  <div id="mapid" style="display: none" class="map">
		  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29455.80915183944!2d120.47031454449525!3d22.65467805683902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346e178cae0b7a29%3A0x50bf59e1705a0a73!2z5ZyL56uL5bGP5p2x5aSn5a245rCR55Sf5qCh5Y2A!5e0!3m2!1szh-TW!2stw!4v1652279981894!5m2!1szh-TW!2stw" width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		  <h3>Click「search address」to closed the map.</h3>
      </div>
	  </aside>
	</section>
	<div class="clearfix"></div>
  	
  <footer class="secondary_header footer">
    <div class="copyright">&copy;<strong>Chin-An Liu</strong></div>
  </footer>
	<div class="content-box"></div>
</div>
</body>
</html>