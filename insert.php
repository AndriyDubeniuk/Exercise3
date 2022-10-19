<?php
include 'connect.php';
include 'arrayrole.php';

$first_nameSend = $_POST['first_nameSend'];
$last_nameSend = $_POST['last_nameSend'];
$roleSend = $_POST['roleSend'];
$statusSend = $_POST['statusSend'];

if(empty($first_nameSend)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 101, "message" => "first name for add not found"];
    echo json_encode($responses);
    exit();
}

if(empty($last_nameSend)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 102, "message" => "last name for add not found"];
    echo json_encode($responses);
    exit();
}

if(empty($roleSend)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 103, "message" => "role for add not found"];
    echo json_encode($responses);
    exit();
}

if(!isset($statusSend)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 104, "message" => "status for add not found"];
    echo json_encode($responses);
    exit();
}

$sql = "INSERT INTO `crud` (`firstname`, `lastname`, `role`, `status`) VALUES ('$first_nameSend', '$last_nameSend', '$roleSend', '$statusSend')";
$result = mysqli_query($conn,$sql);
$lastid = mysqli_insert_id($conn);
$role = $arrRole[$roleSend];

$responses["status"] = true;
$responses["error"] = null;
$responses["user"] = ["id" => $lastid, "firstname" => $first_nameSend, "lastname" => $last_nameSend, "statususer" => (int)$statusSend, "role" => $role];

echo json_encode($responses);
?>