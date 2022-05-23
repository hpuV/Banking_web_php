<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

  if($_SESSION["level"]>=2){
    header("location:useradmincenter.php");

  }else{
    header("location:usercenter.php");
  }
?>
 </table>
</body>
</html>
<?php
  }else{
     echo "非法登入!";
     exit();
}
?>


