<?php
include 'connect.php';

if(isset($_POST['deleteSend']) && !empty($_POST['deleteSend'])) {
    $unique = $_POST['deleteSend'];
    $sql = "DELETE FROM `crud` WHERE id = $unique";
    $result = mysqli_query($conn,$sql);
    $responses["status"] = "true";
    $responses["error"] = "null";
    $responses["id"] = $_POST['deleteSend'];
    echo json_encode($responses);
}
else {
    $responses["status"] = "false";
    $responses["error"]=["code" => "100", "message" => "id for delete not found"];
    echo json_encode($responses);
}

?>