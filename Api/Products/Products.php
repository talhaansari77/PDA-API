<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

switch ($_SERVER["REQUEST_METHOD"]) {
        // Get Shops
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $conn->query("SELECT * FROM products WHERE id = {$_GET['id']}");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_assoc());
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else {
            $result = $conn->query("SELECT * FROM products");

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
        if (isset($data['title']) && isset($data['description']) && isset($data['price']) && is_uploaded_file($_FILES["picture"]["tmp_name"])) {

            // INSERT INTO `products` (`id`, `title`, `description`, `price`, `imageUrl`, `menuId`) 
            // VALUES (NULL, 'porudjaksjd', 'qwewqeqwe', '151.00', 'dasd', '00');
            // SELECT id FROM `categories` ORDER BY id DESC LIMIT 1;
            ////////////////////////////////
            // Receiving the Image here 
            $file_name = $_FILES["picture"]["name"];
            $file_temp = $_FILES["picture"]["tmp_name"];
            $file_ext = explode(".", $file_name);
            $file_actual_ext = strtolower(end($file_ext));
            $file_new_name = uniqid('', true) . "." . $file_actual_ext;
            # this is the actual destination from you take the file and move it.
            $file_destination = "Uploads/imgs/" . $file_new_name;
            $file_destinationG = "https://" . $_SERVER['SERVER_NAME'] . "/" . $file_destination;



            $sql = "INSERT INTO `products` (`id`, `title`, `description`, `price`, `imageUrl`, `menuId`, `catId`, `shopId`) 
            VALUES (NULL, '{$data['title']}', '{$data['description']}', '{$data['price']}', '{$file_destinationG}', '{$data['menuId']}', '{$data['catId']}' ,'{$data['shopId']}')";
            //upload image before insert
            if (move_uploaded_file($file_temp, $file_destination)) {
                if ($conn->query($sql)) {
                    $id = $conn->query("SELECT id FROM `products` ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];

                    echo  json_encode(array(
                        'id' => $id,
                        'Message' => "product is Created",
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
                    'Message' => "There was a Problem While Uploading Image",
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
