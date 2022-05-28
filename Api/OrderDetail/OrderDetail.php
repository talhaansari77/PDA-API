<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

// print_r( json_decode('{"1":"failed","2":[1,2,3]}', true));
switch ($_SERVER["REQUEST_METHOD"]) {
        // Get Shops
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $conn->query("SELECT * FROM orderdetail WHERE id = {$_GET['id']}");

            if ($result->num_rows > 0) {
                echo  json_encode($result->fetch_assoc());
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else if (isset($_GET['orderId']) && isset($_GET['shopId'])) {
            // SELECT orders.*,orderdetail.shopId from orders, orderdetail 
            // WHERE orders.id = orderdetail.orderId AND orderdetail.shopId = 1 
            // AND orderdetail.status in (SELECT `status` FROM orderdetail 
            // WHERE status="pending") GROUP BY orderdetail.orderId
            $result = $conn->query("SELECT * FROM orderdetail WHERE orderId = {$_GET['orderId']} AND shopId = {$_GET['shopId']}");

            if ($result->num_rows > 0) {
                echo  json_encode(array(
                    'orders' => $result->fetch_all(MYSQLI_ASSOC),
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else if (isset($_GET['orderId'])) {
            $result = $conn->query("SELECT * FROM orderdetail WHERE orderId = {$_GET['orderId']} ");

            if ($result->num_rows > 0) {
                echo  json_encode(array(
                    'orders' => $result->fetch_all(MYSQLI_ASSOC),
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "Not Found",
                    'status' => false
                ));
            }
        } else {
            $result = $conn->query("SELECT * FROM orderdetail");

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
        if (isset($data['selectedItems'])  && isset($data['orderId'])) {

            //error counter
            $errors = 0;
            //cartItems
            $cartItems = json_decode(json_encode($data['selectedItems']));
            foreach ($cartItems as $item) {
                $cost = $item->cost ? $item->cost : 0;
                $sql = "INSERT INTO `orderdetail` (`id`, `title`, `description`, `qty`,`cost`, `price`, `type`, `status`, `imageUrl`, `orderId`, `shopId`) 
                VALUES (NULL, '{$item->title}', '{$item->description}', '1', '{$cost}', '{$item->price}', '{$item->catName}', 'pending', '{$item->imageUrl}', '{$data['orderId']}', '{$item->shopId}')";
                //Store
                $errors = $conn->query($sql) ? $errors : $errors + 1;
            }

            if ($errors == 0) {
                echo  json_encode(array(
                    'Message' => "Order Registered Successfully",
                    'status' => true
                ));
            } else {
                echo  json_encode(array(
                    'Message' => "There were {$errors} Error While Creating The Order",
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
