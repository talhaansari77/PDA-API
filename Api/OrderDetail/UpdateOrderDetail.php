<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // validating if orderList are empty
    if (isset($data['orderList'])) {
        // orderLIst To Update OrderDetail
        $orderList = json_decode(json_encode($data['orderList']));
        $status = $data['status'];
        //error counter
        $errors = 0;
        foreach ($orderList as $order) {
            $cost = $order->cost ? $order->cost : 0;
            //making query to update orderDetail
            $sql = "UPDATE `orderdetail` SET `title` = '{$order->title}', 
            `description` = '{$order->description}', `qty` = '{$order->qty}', `cost` = '{$cost}', 
            `price` = '{$order->price}', `type` = '{$order->type}', `status` = '{$status}', 
            `imageUrl` = '{$order->imageUrl}', `orderId` = '{$order->orderId}', `shopId` = '{$order->shopId}'  
            WHERE `id` =" . $order->id;
            //Store while checking error 
            $errors = $conn->query($sql) ? $errors : $errors + 1;
        }

        if ($errors == 0) {
            echo  json_encode(array(
                'Message' => "Orders Updated Successfully",
                'status' => true
            ));
        } else {
            echo  json_encode(array(
                'Message' => "There were {$errors} Error While Updating The Order",
                'status' => false
            ));
        }
    } else {
        echo  json_encode(array(
            'Message' => "Not Found",
            'status' => false
        ));
    }
} else {
    echo  json_encode(array(
        'Message' => "Invalid Request",
        'status' => false
    ));
}
