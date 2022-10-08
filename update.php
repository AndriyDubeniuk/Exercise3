<?php
include 'connect.php';
include 'arrayrole.php';

$updateId = $_POST['updateId'];
$update_first_name = $_POST['update_first_name'];
$update_last_name = $_POST['update_last_name'];
$update_role = $_POST['update_role'];
$update_status = $_POST['update_status'];

if(!isset($updateId) || empty($updateId)) {
    $responses["status"] = false;
    $responses["error"]=["code" => 200, "message" => "id for update not found"];
    echo json_encode($responses);
} else {
    if(!isset($update_first_name) || empty($update_first_name)) {
        $responses["status"] = false;
        $responses["error"]=["code" => 201, "message" => "first name for update not found"];
        echo json_encode($responses);
    } else {
        if(!isset($update_last_name) || empty($update_last_name)) {
            $responses["status"] = false;
            $responses["error"]=["code" => 202, "message" => "last name for update not found"];
            echo json_encode($responses);
        } else {
            if(!isset($update_role) || empty($update_role)) {
                $responses["status"] = false;
                $responses["error"]=["code" => 203, "message" => "role for update not found"]; 
                echo json_encode($responses); 
            } else {
                if(!isset($update_status)) {
                    $responses["status"] = false;
                    $responses["error"]=["code" => 204, "message" => "status for update not found"];
                    echo json_encode($responses);
                } else {

                    $sql = "UPDATE `crud` SET `firstname` = '$update_first_name', `lastname` = '$update_last_name', `role` = '$update_role', `status` = '$update_status' WHERE `id`=$updateId";
                    $result = mysqli_query($conn,$sql);

                    $responses["status"] = true;
                    $responses["error"] = null;
                    $responses["user"] = ["id" => (int)$updateId, "firstname" => $update_first_name, "lastname" => $update_last_name, "statususer" => (int)$update_status, "role" => $arrRole[$update_role]];
                    echo json_encode($responses);
                    
                }
            }
        }
    }
}
?>