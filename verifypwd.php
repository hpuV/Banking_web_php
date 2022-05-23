<?php

include('connect.php');

session_start();

$account = $_SESSION["account"];
$password = $_SESSION["password"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $oldpassword = $_POST['old_password'];

  if($oldpassword == $password){
    $up_password= $_POST['new_password'];
    $sqlUPdate= "UPDATE memberdata SET m_password = '".$up_password."' WHERE m_account= '".$account."';";
    
    mysqli_select_db($db_link, "phpmember");
    $updateDB = mysqli_query($db_link,$sqlUPdate);
    if($updateDB){
      echo "更改成功!<br> 3秒後將自動跳轉至登入頁面<br>";
      echo "<a href='logout.php'>未成功跳轉頁面請點擊此</a>";
      header("refresh:32;url=logout.php");
      exit;

    }else{
      echo "Error creating table: " . mysqli_error($db_link);
    }
  }else{
    echo "舊密碼輸入錯誤!<br> 3秒後將自動跳轉頁面<br>";
    echo "<a href='editpwd.php'>未成功跳轉頁面請點擊此</a>";
    header("refresh:32;url=editpwd.php");
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