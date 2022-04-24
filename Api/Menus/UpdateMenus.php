<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // validating if creds are empty
    $id = isset($data["id"]) ? $data["id"] : "null";
    $name = isset($data["name"]) ? $data["name"] : "null";

   
    if ($id) {
        if ($conn->query("SELECT * FROM menus WHERE id={$id}")->num_rows > 0) {
            $sql = "UPDATE `menus` SET `name` = '$name' WHERE `id` =" . $id;
             
            if ($conn->query($sql)) {
                echo  json_encode(array(
                    'Message' => "menus Updated",                    
                    'id' => $id,
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "There Was Some Error While Updating The menus",
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
