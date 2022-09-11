<?php
include 'connect.php';

if(isset($_POST['activitySend']) && !empty($_POST['activitySend']) && isset($_POST['statusUserSend']) && !empty($_POST['statusUserSend'])) {
    $unique = $_POST['activitySend'];
    $status = $_POST['statusUserSend'];
    $sql = "UPDATE `crud` SET `status` = '$status' WHERE `id`='$unique'";
    $result = mysqli_query($conn,$sql);
    $response["status"] = "true";
    $response["error"] = "null";
    $response["id"] = $_POST['activitySend'];
    $response["statusUser"] = $_POST['statusUserSend'];
    print_r($response);
}

?>