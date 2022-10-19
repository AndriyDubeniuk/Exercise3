<?php
include 'connect.php';
include 'arrayrole.php';

if(empty($_POST['displaySend'])) {
    $responses["status"] = false;
    $responses["error"] = ["code" => 1, "message" => "Data display error"];
    echo json_encode($responses);
    exit();
}

$sql = "SELECT * FROM `crud`";
$result = mysqli_query($conn,$sql);
$users = [];
while($row = mysqli_fetch_assoc($result)) {
    array_push($users, ["id" => (int)$row['id'], "firstname" => $row['firstname'], "lastname" => $row['lastname'], "status_user" => (int)$row['status'], "role" => $arrRole[$row['role']]]);
}
$responses["status"] = true;
$responses["error"] = null;
$responses["users"] = $users;
echo json_encode($responses);
?>