<?php
include 'connect.php';

$activitySend = $_POST['activitySend'];
$statusUserSend = $_POST['statusUserSend'];

if(empty($activitySend)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 50, "message" => "id for update activity not found"]; 
    echo json_encode($response);
    exit();
}

if(!isset($statusUserSend)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 51, "message" => "activity for update activity not found"];
    echo json_encode($response);
    exit();
}

$id = implode(",", $activitySend);
$sql = "SELECT * FROM `crud` WHERE `id` IN ($id)";
$result = mysqli_query($conn,$sql);
$id_count = mysqli_num_rows($result);

if ($id_count != count($activitySend)) {
    $responses["status"] = false;
    $responses["error"] = ["code" => 52, "message" => "Some users does not exist"];
    echo json_encode($responses);
    exit();
}

$sql = "UPDATE `crud` SET `status` = '$statusUserSend' WHERE `id` IN ($id)";
$result = mysqli_query($conn,$sql);

$responses["status"] = true;
$responses["error"] = null;
$responses["users"] = $activitySend;
$responses["status_user"] = (int)$statusUserSend;
echo json_encode($responses);
?>