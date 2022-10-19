<?php
include 'connect.php';

$arr_idSend = $_POST["arr_idSend"];

$id = implode(",", $arr_idSend);
$sql = "DELETE FROM `crud` WHERE `id` IN ($id)";
$result = mysqli_query($conn,$sql);

$responses["status"] = true;
$responses["error"] = null;
$responses["users"] = $arr_idSend;
echo json_encode($responses);

?>