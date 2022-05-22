<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin:*");

include_once "./Connection/config.php";


if (is_uploaded_file($_FILES["picture"]["tmp_name"])) {
    $id = $_GET['id'];
    $table = $_GET['table'];
    $image='';
    // Receiving the Image here 
    $file_name = $_FILES["picture"]["name"];
    $file_temp = $_FILES["picture"]["tmp_name"];
    $file_ext = explode(".", $file_name);
    $file_actual_ext = strtolower(end($file_ext));
    $file_new_name = uniqid('', true) . "." . $file_actual_ext;
    # this is the actual destination from you take the file and move it.
    $file_destination = "Uploads/imgs/" . $file_new_name;
    $file_destinationG = "https://".$_SERVER['SERVER_NAME']."/".$file_destination;
    # change database column name to the one you want to save the file name in.
    if($table == "users"){
        $image="picture";
    } else if($table == "shops"){
        $image = "imageUrls";
    }
    # uploading here
    if (move_uploaded_file($file_temp, $file_destination)) {
        // Upadting Image
        $sql = "UPDATE ".$table." SET  ".$image."='$file_destinationG' WHERE `id` =" . $id;
        $conn->query($sql);
        // sending Response
        echo  json_encode(array(
            'imageName' => $file_destinationG,
            'Message' => "Image Uploaded Successfully",
            'status' => true
        ));
    } else {
        echo  json_encode(array(
            'Message' => "There was a Problem While Uploading Image",
            'status' => false
        ));
    }
} else {
    echo  json_encode(array(
        'Message' => "Please Add The Image to Uploade",
        'status' => false
    ));
}
