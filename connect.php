<?php
//connect database Localhost Database
/*
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
*/

//connect database CSIE Database
$db_Host = "web.csie2.nptu.edu.tw";
$db_Username = "cbe109013";
$db_Password = "cbe109013hpuv";
$db_Name = "cbe109013_bankingweb";

mysqli_report(MYSQLI_REPORT_STRICT);

try{
    $db_link = mysqli_connect($db_Host,$db_Username,$db_Password,$db_Name);
    mysqli_set_charset($db_link, 'utf8');
}catch(Exception $e){
    echo $e -> getMessage();
}
/*
if(!$db_link){
    function_alert("Oops, MySQL Connect Failed");
}else{
    //function_alert("MySQL Connected");
    mysqli_query($db_link, "SET NAMES 'utf8'");
    //echo "Connected!";
}*/

mysqli_select_db($db_link, "cbe109013_bankingweb");


?>