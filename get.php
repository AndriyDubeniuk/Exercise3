<?php
include 'connect.php';

$updateId = $_POST['updateId'];

if (empty($updateId)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 204, "message" => "id for get not found"];
    echo json_encode($responses);
    exit();
}

$sql = "SELECT * FROM `crud` WHERE id = $updateId";
$result = mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);

if ( $count == 0 ) {
    $responses["status"] = false;
    $responses["error"] = ["code" => 205, "message" => "This user does not exist"];
    echo json_encode($responses);
    exit();
}

while($row = mysqli_fetch_assoc($result)) {  
    $rowResp = $row;
}
$rowResp["id"] = intval($rowResp["id"]);
$rowResp["status"] = intval($rowResp["status"]);
$rowResp["role"] = intval($rowResp["role"]);
$responses["status"] = true;
$responses["error"] = null;
$responses["user"] = $rowResp;
echo json_encode($responses);



?>