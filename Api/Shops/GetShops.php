<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "../../Connection/config.php";


if (isset($_GET['limit'])) {
    $limit = strip_tags($_GET['limit']);
    $result = $conn->query("SELECT * FROM shops");

    if ($result->num_rows > 0) {
        $shops = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(array_slice($shops, 0, $limit));
    } else {
        echo  json_encode(array(
            'Message' => "Not Found",
            'status' => false
        ));
    }
}
