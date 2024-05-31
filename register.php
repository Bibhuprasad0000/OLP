<?php
require("db.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{


    $pattern="1234567890";
    $lenght= strlen($pattern)-1;
    $v_code=[];
    for($i=0;$i<6;$i++)
    {
        $index=rand(0,$lenght);
        $v_code[]=$pattern[$index];
    }
    $ver_code= implode($v_code);
    $full_name=$_POST['username'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    // chech user 
    $check="SELECT email FROM users WHERE email='$email'";
    $response=$db->query($check);

    if($response->num_rows !=0)
    {
        echo "usermatch";

    }
    else
    {
        $send_atc=mail($email,"Activation Code","veryfy your email id
        Hey User
        You nearly there. please enter this verification code on Mydrive to Continue  : 
            ".$ver_code."
        Thanks
        My drive","from:bibhups7077@gmail.com");
        if($send_atc)
        {
            $store="INSERT INTO users(full_name,email,password,activation_code)
        VALUES('$full_name','$email','$password','$ver_code')";
       if($db->query($store))
       {
           echo "success";
       }
       else
       {
          echo "failed";
       }

        }
        else{
            echo " Try again with Other Email id ";
        }
    }

    
     
    

}
else
{
    echo "Unauthorised request";
}



?>