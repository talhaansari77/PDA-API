<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // validating if creds are empty
    $id = isset($data["id"]) ? $data["id"] : "null";
    $title = isset($data["title"]) ? $data["title"] : "null";
    $imageUrls = isset($data["imageUrls"]) ? $data["imageUrls"] : "null";
    $menuId = isset($data["menuId"]) ? $data["menuId"] : "null";
    $address = isset($data["address"]) ? $data["address"] : "null";
    $categoryName = isset($data["categoryName"]) ? $data["categoryName"] : "null";
    $website = isset($data["website"]) ? $data["website"] : "null";
    $phone = isset($data["phone"]) ? $data["phone"] : "null";
    $temporarilyClosed = isset($data["temporarilyClosed"]) ? $data["temporarilyClosed"] : "null";
    $location = isset($data["location"]) ? $data["location"] : "null";
    $url = isset($data["url"]) ? $data["url"] : "null";
    $totalScore = isset($data["totalScore"]) ? $data["totalScore"] : "null";
    $reviewCount = isset($data["reviewCount"]) ? $data["reviewCount"] : "null";


   
    if ($id) {
        if ($conn->query("SELECT * FROM shops WHERE id={$id}")->num_rows > 0) {
            $sql = "UPDATE `shops` SET `title` = '$title', `imageUrls` = '$imageUrls',`menuId` = '$menuId', `address` = '$address', `categoryName` = '$categoryName', `website` = '$website', `phone` = '$phone', `temporarilyClosed` = '$temporarilyClosed', `location` = '$location',`url` = '$url', `totalScore` = '$totalScore', `reviewCount` = '$reviewCount' WHERE `id` =" . $id;
             
            if ($conn->query($sql)) {
                echo  json_encode(array(
                    'Message' => "Shop Updated",                    
                    'id' => $id,
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "There Was Some Error While Updating The Shop",
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
