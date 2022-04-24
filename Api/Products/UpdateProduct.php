<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // validating if creds are empty
    $id = isset($data["id"]) ? $data["id"] : "null";
    $title = isset($data["title"]) ? $data["title"] : "null";
    $description = isset($data["description"]) ? $data["description"] : "null";
    $price = isset($data["price"]) ? $data["price"] : "null";
    $imageUrl = isset($data["imageUrl"]) ? $data["imageUrl"] : "null";
    $menuId = isset($data["menuId"]) ? $data["menuId"] : "null";
    $catId = isset($data["catId"]) ? $data["catId"] : "null";
    $shopId = isset($data["shopId"]) ? $data["shopId"] : "null";
// INSERT INTO `products` (`id`, `title`, `description`, `price`, `imageUrl`, `menuId`) 

   
    if ($id) {
        if ($conn->query("SELECT * FROM products WHERE id={$id}")->num_rows > 0) {
            $sql = "UPDATE `products` SET `title` = '$title', `description` = '$description', `price` = '$price', `imageUrl` = '$imageUrl', `menuId` = '$menuId', `catId` = '$catId', `shopId` = '$shopId' WHERE `id` =" . $id;
             
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
        'Message' => "Invalid Request",
        'status' => false
    ));
}
