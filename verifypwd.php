<?php

include('connect.php');

session_start();

$account = $_SESSION["account"];
$password = $_SESSION["password"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
  if($_SESSION['level']<=0){
    function_alert("不要改密碼呦 σ`∀´)σ");
  }else{
    $oldpassword = $_POST['old_password'];

    if($oldpassword == $password){
      $up_password= $_POST['new_password'];
      $sqlUPdate= "UPDATE memberdata SET m_password = '".$up_password."' WHERE m_account= '".$account."';";
      
      $updateDB = mysqli_query($db_link,$sqlUPdate);
      if($updateDB){
        header("location: verifypwdsuccess.php");
        exit;

      }else{
        echo "Error creating table: " . mysqli_error($db_link);
      }
    }else{
      header("location: verifypwdfail.php");
    }
  }
}

mysqli_close($db_link);

function function_alert($message) { 
      
    // Display the alert box  
    echo "<script>alert('$message');
    window.location.href='editpwd.php';
    </script>"; 
    
    return false;
}
?>