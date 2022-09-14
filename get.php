<?php
include 'connect.php';

if (isset($_POST['updateId'])) {
    $user_id = $_POST['updateId'];

    $sql = "SELECT * FROM `crud` WHERE id = $user_id";
    $result = mysqli_query($conn,$sql);
    $responses["status"] = "true";
    $responses["error"] = "null";
    while($row = mysqli_fetch_assoc($result)) {
        $responses["user"] = $row;
    }
    echo json_encode($responses);
} else {
    $responses["status"] = "false";
    $responses["error"]=["code" => "204", "message" => "id for get not found"];
    echo json_encode($responses);
}

?>