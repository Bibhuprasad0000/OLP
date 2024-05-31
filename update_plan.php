<?php
require("db.php");
session_start();
$user_email=$_SESSION['user'];


$storage="";
$plan=$_GET['plan'];
if($plan=="silver")
{ 
$storage=51200;
}
else if($plan=="gold")
{
$storage=102400;
}
else if($plan=="premium")
{
$storage=0;
}




$purchase_date=Date('y-m-d');
$update="UPDATE users SET plans='$plan',storage='$storage',purchase_date='$purchase_date' WHERE email='$user_email'";
if($db->query($update))
{
    header("Location:../profile.php");

}
else{
    echo "update failed ";
}


?>