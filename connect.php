<?php
//connect database
$db_Host = "localhost";
$db_Username = "admin";
$db_Password = "Qaz~!@123";
$db_Name = "phpmember";


$db_link = mysqli_connect($db_Host,$db_Username,$db_Password,$db_Name); 
if(!$db_link){
    function_alert("Oops, MySQL Connect Failed");
}else{
    //function_alert("MySQL Connected");
    mysqli_query($db_link, "SET NAMES 'utf8'");
}

$db = mysqli_select_db($db_link, "phpmember");

?>