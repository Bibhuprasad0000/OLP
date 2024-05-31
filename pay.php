<?php

require("db.php");
session_start();

$plan=$_GET['plan'];
$amt=$_GET['amt'];
$user_email=$_SESSION['user'];
$res=$db->query("SELECT * FROM users WHERE email='$user_email'");
$data=$res->fetch_assoc();
$name=$data['full_name'];



require("../src/Instamojo.php");
$api = new Instamojo\Instamojo('test_50e3d4055a94f2fa9479b5d64d5', 'test_1067716feb3047896eb162cb29f', 'https://test.instamojo.com/api/1.1/');

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => "My Drive ".$plan." plan",
        "amount" => $amt,
        "send_email" => true,
        "email" => $user_email,
        "buyer_name"=> $name,
        "redirect_url" => "http://localhost/Mydrive/php/update_plan.php?plan=".$plan
        ));
    $main_url=$response['longurl'];

    Header("location:$main_url");
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}

?>