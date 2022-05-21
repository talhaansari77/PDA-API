<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['shopId'])) {

    $shopId = $data['shopId'];

    $sql = "SELECT orders.*,orderdetail.shopId from orders, orderdetail 
    WHERE orders.id = orderdetail.orderId AND orderdetail.shopId = {$shopId} 
    GROUP BY orderdetail.orderId";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(array(
            'orders' => $orders,
            'status' => true
        ));
    } else {
        echo  json_encode(array(
            'Message' => "Not Found",
            'status' => false
        ));
    }
} else {
    echo  json_encode(array(
        'Message' => "Not Found",
        'status' => false
    ));
}
