<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data["id"])) {
        $id = $data["id"] ? $data["id"] : 0;
        if ($id) {
            if ($conn->query("SELECT * FROM `products` WHERE id={$id}")->num_rows > 0) {
                $result = $conn->query("DELETE FROM `products` WHERE id = {$id}");
                echo  json_encode(array(
                    'Message' => "products Deleted",
                    'id' => $id,
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'id' => $id,
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
} else {
    echo  json_encode(array(
        'Message' => "Invalid Request",
        'status' => false
    ));
}
