<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

switch ($_SERVER["REQUEST_METHOD"]) {
        // Get Shops
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $conn->query("SELECT * FROM categories WHERE id = {$_GET['id']}");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_assoc());
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else {
            $result = $conn->query("SELECT * FROM categories");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_all(MYSQLI_ASSOC));
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        }
        break;
        // Delete Shops

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['name']) && isset($data['menuId'])) {

            
            $sql = "INSERT INTO `categories` (`id`, `name`, `menuId`)
            VALUES (NULL, '{$data['name']}', '{$data['menuId']}')";

            if ($conn->query($sql)) {
                $id = $conn->query("SELECT id FROM `categories` ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];
                echo  json_encode(array(
                    'id'=>$id ,
                    'Message' => "category is Created",
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "There Was Some Error While Creating The Shop",
                    'status' => false
                ));
            }
        } else {
            echo  json_encode(array(
                'Message' => "The Form was Not Filled Correctly",
                'status' => false
            ));
        }
        break;
    default:
        echo  json_encode(array(
            'Message' => "Invalid Request",
            'status' => false
        ));
        break;
}
