<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // Receiving the Image here 
    $file_name = $_FILES["picture"]["name"];
    $file_temp = $_FILES["picture"]["tmp_name"];
    $file_ext = explode(".", $file_name);
    $file_actual_ext = strtolower(end($file_ext));
    $file_new_name = uniqid('', true) . "." . $file_actual_ext;
    # this is the actual destination from you take the file and move it.
    $file_destination = "../../Uploads/imgs/" . $file_new_name;
    $file_destinationG = "https://" . $_SERVER['SERVER_NAME'] . "/" . $file_destination;

    // validating if creds are empty
    $id = isset($_POST["id"]) ? $_POST["id"] : "null";
    $title = isset($_POST["title"]) ? $_POST["title"] : "null";
    $description = isset($_POST["description"]) ? $_POST["description"] : "null";
    $price = isset($_POST["price"]) ? $_POST["price"] : "null";
    // $imageUrl = isset($_POST["imageUrl"]) ? $_POST["imageUrl"] : "null";
    $menuId = isset($_POST["menuId"]) ? $_POST["menuId"] : "null";
    $catId = isset($_POST["catId"]) ? $_POST["catId"] : "null";
    $shopId = isset($_POST["shopId"]) ? $_POST["shopId"] : "null";
    // INSERT INTO `products` (`id`, `title`, `description`, `price`, `imageUrl`, `menuId`) 

    if (move_uploaded_file($file_temp, $file_destination)) {
        if ($id) {
            if ($conn->query("SELECT * FROM products WHERE id={$id}")->num_rows > 0) {
                $sql = "UPDATE `products` SET `title` = '$title', `description` = '$description', `price` = '$price', `imageUrl` = '$file_destinationG', `menuId` = '$menuId', `catId` = '$catId', `shopId` = '$shopId' WHERE `id` =" . $id;

                if ($conn->query($sql)) {
                    echo  json_encode(array(
                        'Message' => "products Updated",
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
            'Message' => "There was a Problem While Uploading Image",
            'status' => false
        ));
    }
} else {
    echo  json_encode(array(
        'Message' => "Invalid Request",
        'status' => false
    ));
}
