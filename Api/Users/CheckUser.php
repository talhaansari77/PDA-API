<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");
include_once "../../Connection/config.php";

if (isset($_GET['email']) && isset($_GET['password'])) {
    $email = $_GET['email'];
    $password = $_GET['password'];

    if ($email && $password) {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $userInfo = $result->fetch_assoc();
            $userInfo = array(
                'user'=>$userInfo,
               'Message' => "User Found",
               'status' => true
           );
            
            echo json_encode($userInfo);
        } else {
            echo json_encode(array(
                'Message' => "User Not Found",
                'status' => false
            ));
        }
    } else {
        echo json_encode(array(
            'Message' => "Invalid Request",
            'status' => false
        ));
    }
} else {
    echo json_encode(array(
        'Message' => "Invalid Request",
        'status' => false
    ));
}
