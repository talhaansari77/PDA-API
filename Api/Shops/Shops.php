<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";


switch ($_SERVER["REQUEST_METHOD"]) {
        // Get Shops
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $conn->query("SELECT * FROM shops WHERE id = {$_GET['id']}");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_assoc());
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else {
            $result = $conn->query("SELECT * FROM shops");

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
        if (isset($data['title']) &&  isset($data['address']) && isset($data['categoryName']) && isset($data['phone'])) {
            // INSERT INTO `shops` (`id`, `title`, `imageUrls`, `menuId`, `address`, `categoryName`, `website`, `phone`, `temporarilyClosed`, `location`, `parmanentlyClosed`, `url`, `totalScore`, `reviewCount`, `sellerId`) 
            // VALUES (NULL, 'asd', 'asd', '0', 'asd', 'asd', 'asd', '0asdas', 'asd', 'fsa', 'asd', 'akdjhajsdkjashdkhoiwuiqowurohkasdjkh', '232', '32', '0'); -->

            $title = isset($data["title"]) ? $data["title"] : "null";
            $imageUrls = isset($data["imageUrls"]) ? $data["imageUrls"] : "null";
            $menuId = isset($data["menuId"]) ? $data["menuId"] : "null";
            $address = isset($data["address"]) ? $data["address"] : "null";
            $categoryName = isset($data["categoryName"]) ? $data["categoryName"] : "null";
            $website = isset($data["website"]) ? $data["website"] : "null";
            $phone = isset($data["phone"]) ? $data["phone"] : "null";
            $temporarilyClosed = isset($data["temporarilyClosed"]) ? $data["temporarilyClosed"] : "null";
            $parmanentlyClosed = isset($data["parmanentlyClosed"]) ? $data["parmanentlyClosed"] : "null";
            $location = isset($data["location"]) ? $data["location"] : "null";
            $url = isset($data["url"]) ? $data["url"] : "null";
            $totalScore = isset($data["totalScore"]) ? $data["totalScore"] : "null";
            $reviewCount = isset($data["reviewCount"]) ? $data["reviewCount"] : "null";

            if (!$conn->query("SELECT * FROM `shops` WHERE title='{$data['title']}'")->num_rows) {
                $sql = "INSERT INTO `shops` (`id`, `title`, `imageUrls`, `menuId`, `address`, `categoryName`, `website`, `phone`, `temporarilyClosed`, `location`, `parmanentlyClosed`, `url`, `totalScore`, `reviewCount`)
                VALUES (NULL, '$title', '$imageUrls', '0', '$address', '$categoryName', '$website', '$phone', '$temporarilyClosed', '$location', '$parmanentlyClosed', '$url', '$totalScore', '$reviewCount')";

                if ($conn->query($sql)) {
                    $id = $conn->query("SELECT id FROM `shops` ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];

                    echo  json_encode(array(
                        'id' => $id,
                        'Message' => "Shop is Created",
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
                    'Message' => "Shop Already Exist",
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
