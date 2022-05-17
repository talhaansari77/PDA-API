<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";


if (isset($_GET['menuId'])) {
    $shopId = strip_tags($_GET['shopId']);

    $sql = "SELECT products.*, menus.name as menuName, categories.name as catName 
    FROM products, categories,menus WHERE products.menuId = menus.id 
    AND products.catId = categories.id AND products.menuId = '$shopId'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $products = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($products);
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
