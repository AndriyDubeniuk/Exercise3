<?php
include 'connect.php';

if(isset($_POST['statusUserSend']) && !empty($_POST['statusUserSend'])) {
    if( isset($_POST['activitySend']) && !empty($_POST['activitySend'])) {
        $status = $_POST['statusUserSend'];
        $responses["status"] = "true";
        $responses["error"] = "null";
        $users = [];
        foreach($_POST["activitySend"] as $id) {
            $sql = "UPDATE `crud` SET `status` = '$status' WHERE `id`='$id'";
            $result = mysqli_query($conn,$sql);
            array_push($users, ["id" => $id, "status" => $status]);
        }
        $responses["users"] = $users;
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