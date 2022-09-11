<?php
include 'connect.php';

if(isset($_POST['deleteSend']) && !empty($_POST['deleteSend'])) {
    $unique = $_POST['deleteSend'];
    $sql = "DELETE FROM `crud` WHERE id = $unique";
    $result = mysqli_query($conn,$sql);
    $response["status"] = "true";
    $response["error"] = "null";
    $response["id"] = $_POST['deleteSend'];
    print_r($response);
}
else {
    $response["status"] = "false";
    $response["error"]=["code" => "100", "message" => "user id is empty"];
}

?>