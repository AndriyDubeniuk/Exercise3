<?php
include 'connect.php';

if(isset($_POST['statusUserSend']) && !empty($_POST['statusUserSend'])) {
    if( isset($_POST['activitySend']) && !empty($_POST['activitySend'])) {
        $unique = $_POST['activitySend'];
        $status = $_POST['statusUserSend'];
        $sql = "UPDATE `crud` SET `status` = '$status' WHERE `id`='$unique'";
        $result = mysqli_query($conn,$sql);
        $responses["status"] = "true";
        $responses["error"] = "null";
        $responses["id"] = $_POST['activitySend'];
        $responses["statususer"] = $_POST['statusUserSend'];
        echo json_encode($responses);
    } else {
        $responses["status"] = "false";
        $responses["error"]=["code" => "51", "message" => "activity for update activity not found"];
        echo json_encode($response);
    }
} else {
    $responses["status"] = "false";
    $responses["error"]=["code" => "50", "message" => "id for update activity not found"];
    echo json_encode($response);
}


?>