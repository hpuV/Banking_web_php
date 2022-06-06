<?php

include('connect.php');

// Define variables and initialize with empty values
$username= $_POST["username"];
$passwd= $_POST["password"];
//增加hash可以提高安全性
$password_hash=password_hash($password,PASSWORD_DEFAULT);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $sql = "SELECT * FROM memberdata WHERE m_username = '".$username."' ";
    $result = mysqli_query($db_link,$sql);
    $row_Login = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result)==1 && $passwd ==  $row_Login["m_password"]){
        session_start();
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        //這些是之後可以用到的變數

        $_SESSION["id"] =  $row_Login["m_id"];
        $_SESSION["account"]=  $row_Login["m_account"];
        $_SESSION["username"] =  $row_Login["m_username"];
        $_SESSION["nickname"]=  $row_Login["m_nick"];
        $_SESSION["password"] =  $row_Login["m_password"];
        $_SESSION["level"]=  $row_Login["m_level"];
        
        //header("location:welcome.php");
        header("location:mainpage.php");
    }else{
            function_alert("帳號或密碼錯誤"); 
        }
}
    else{
        function_alert("Something wrong"); 
    }

    // Close connection
    mysqli_close($link);

function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
     window.location.href='index.php';
    </script>"; 
    return false;
} 

?>
