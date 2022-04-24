<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // validating if creds are empty
    $id = isset($data["id"]) ? $data["id"] : "null";
    $name = isset($data["name"]) ? $data["name"] : "null";
    $email = isset($data["email"]) ? $data["email"] : "null";
    $password = isset($data["password"]) ? $data["password"] : "null";
    $contact = isset($data["contact"]) ? $data["contact"] : "null";
    $city = isset($data["city"]) ? $data["city"] : "null";
    $cnic = isset($data["cnic"]) ? $data["cnic"] : "null";
    $business = isset($data["business"]) ? $data["business"] : "null";
    $picture = isset($data["picture"]) ? $data["picture"] : "null";
    $type = isset($data["type"]) ? $data["type"] : "null";
    $shopId = isset($data["shopId"]) ? $data["shopId"] : "null";

    if ($id) {
        if ($conn->query("SELECT * FROM users WHERE id={$id}")->num_rows > 0) {
            $sql = "UPDATE `users` SET  `name`='$name', `email`='$email', `password`='$password', `contact`='$contact', `city`='$city', `cnic`='$cnic', `business`='$business', `type`='$type', `shopId`='$shopId' WHERE `users`.`id` =" . $id;
            if ($conn->query($sql)) {
                echo  json_encode(array(
                    'Message' => "User Updated",                    
                    'id' => $id,
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "There Was Some Error While Updating The User",
                    'status' => false
                ));
            }
        } else {
            echo  json_encode(array(
                'Message' => "Not Found",
                'status' => false
            ));
        }
    }
} else {
    echo  json_encode(array(
        'Message' => "Invalid Request",
        'status' => false
    ));
}
