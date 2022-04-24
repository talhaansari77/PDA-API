<?php
//! Its working
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "./Connection/config.php";

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo  json_encode(array(
        
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'status' => true,
    ));
}else{
    echo  json_encode(array(
        
       
        'Error' => "Error",
        'status' => false,
    ));
}
