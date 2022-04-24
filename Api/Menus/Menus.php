<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";


switch ($_SERVER["REQUEST_METHOD"]) {
        // Get menus
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $conn->query("SELECT * FROM menus WHERE id = {$_GET['id']}");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_assoc());
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else {
            $result = $conn->query("SELECT * FROM menus");

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
        // Delete menus

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['name'])) {
           
            $name = isset($data["name"]) ? $data["name"] : "null";
            

            if (!$conn->query("SELECT * FROM menus WHERE `name`='{$data['name']}'")->num_rows) {
                $sql = "INSERT INTO `menus` (`id`, `name`) VALUES (NULL, '$name')";

                if ($conn->query($sql)) {
                    $id = $conn->query("SELECT id FROM `menus` ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];

                    echo  json_encode(array(
                        'id' => $id,
                        'Message' => "Menus is Created",
                        'status' => true
                    ));
                } else {
                    echo  json_encode(array(
                        'Message' => "There Was Some Error While Creating The Menus",
                        'status' => false
                    ));
                }
            } else {
                echo  json_encode(array(
                    'Message' => "Menus Already Exist",
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
