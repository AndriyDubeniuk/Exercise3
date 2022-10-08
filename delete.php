<?php
include 'connect.php';

$arr_idSend = $_POST["arr_idSend"];

if(isset($arr_idSend)) {
    $responses["status"] = true;
    $responses["error"] = null;
    $users = [];
        foreach($arr_idSend as $id) {
            $sql = "DELETE FROM `crud` WHERE `id` = $id";
            $result = mysqli_query($conn,$sql);
            array_push($users, (int)$id);
            
        }
        $responses["users"] = $users;
        echo json_encode($responses);
} else {
    $responses["status"] = false;
    $responses["error"]=["code" => 100, "message" => "id for delete not found"];
    echo json_encode($responses);
}

?>