<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";


switch ($_SERVER["REQUEST_METHOD"]) {
        // Get Users
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $conn->query("SELECT * FROM users WHERE id = {$_GET['id']}");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_assoc());
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else {
            $result = $conn->query("SELECT * FROM users");

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

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['type']) && $data['type'] == 'seller') {
            if (isset($data['name']) && isset($data['email']) && isset($data['password']) && isset($data['type']) && isset($data['city']) && isset($data['cnic']) && isset($data['business']) && isset($data['contact'])) {

                if (!$conn->query("SELECT * FROM users WHERE email='{$data['email']}'")->num_rows) {
                    $sql = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `city`, `cnic`, `business`, `picture`, `type`, `shopId`) 
                    VALUES (NULL, '{$data['name']}', '{$data['email']}', '{$data['password']}', '{$data['contact']}', '{$data['city']}', '{$data['cnic']}', '{$data['business']}', 'image', '{$data['type']}', '0')";

                    if ($conn->query($sql)) {
                        $id = $conn->query("SELECT id FROM `users` ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];

                        echo  json_encode(array(
                            'id' => $id,
                            'Message' => "User is Created",
                            'status' => true
                        ));
                    } else {
                        echo  json_encode(array(
                            'Message' => "There Was Some Error While Creating The User",
                            'status' => false
                        ));
                    }
                } else {
                    echo  json_encode(array(
                        'Message' => "User Already Exist",
                        'status' => false
                    ));
                }
            } else {
                echo  json_encode(array(
                    'Message' => "The Form was Not Filled Correctly",
                    'status' => false
                ));
            }
        } else {
            // Regular User
            if (isset($data['name']) && isset($data['email']) && isset($data['password'])) {

               
                
                if (!$conn->query("SELECT * FROM users WHERE email='{$data['email']}'")->num_rows) {
                    $sql = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `city`, `cnic`, `business`, `picture`, `type`,`shopId`) 
                    VALUES (NULL, '{$data['name']}', '{$data['email']}', '{$data['password']}', '', '', '', '', 'image', '{$data['type']}','0')";

                    if ($conn->query($sql)) {
                        $id = $conn->query("SELECT id FROM `users` ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];

                        echo  json_encode(array(
                            'id' => $id,
                            'Message' => "User is Created",
                            'status' => true
                        ));
                    } else {
                        echo  json_encode(array(
                            'Message' => "There Was Some Error While Creating The User",
                            'status' => false
                        ));
                    }
                } else {
                    echo  json_encode(array(
                        'Message' => "User Already Exist",
                        'status' => false
                    ));
                }
            } else {
                echo  json_encode(array(
                    'Message' => "The Form was Not Filled Correctly",
                    'status' => false
                ));
            }
        }
        break;
    default:
        echo  json_encode(array(
            'Message' => "Invalid Request",
            'status' => false
        ));
        break;
}
