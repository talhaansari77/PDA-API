<?php 
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");


$data = file_get_contents("Pharmacy.json");

if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
    echo json_encode(array_slice(json_decode($data), 0, $limit));
}else{
    echo $data;
}

?>