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
    $address = isset($data["address"]) ? $data["address"] : "null";
    $date = isset($data["date"]) ? $data["date"] : "null";
    // $shopId = isset($data["shopId"]) ? $data["shopId"] : "null";

   
    if ($id) {
        if ($conn->query("SELECT * FROM orders WHERE id={$id}")->num_rows > 0) {
            $sql = "UPDATE `orders` SET `name` = '$name', `email` = '$email', `address` = '$address', `date` = '$date' WHERE `id` =" . $id;
             
            if ($conn->query($sql)) {
                echo  json_encode(array(
                    'Message' => "order Updated",                    
                    'id' => $id,
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "There Was Some Error While Updating The order",
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
