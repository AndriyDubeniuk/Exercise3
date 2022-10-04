<?php
include 'connect.php';
include 'arrayrole.php';

if(isset($_POST['hiddendata']) && !empty($_POST['hiddendata'])) {
    if(isset($_POST['update_first_name']) && !empty($_POST['update_first_name'])) {
        if(isset($_POST['update_last_name']) && !empty($_POST['update_last_name'])) {
            if(isset($_POST['update_role']) && !empty($_POST['update_role'])) {
                if(isset($_POST['update_status'])) {
                    $uniqueid = $_POST['hiddendata'];
                    $firstname = $_POST['update_first_name'];
                    $lastname = $_POST['update_last_name'];
                    $status = $_POST['update_status'];
                    $role = $_POST['update_role'];

                    $sql = "UPDATE `crud` SET `firstname` = '$firstname', `lastname` = '$lastname', `role` = '$role', `status` = '$status' WHERE `id`=$uniqueid";
                    $result = mysqli_query($conn,$sql);

                    $responses["status"] = true;
                    $responses["error"] = null;
                    $responses["user"] = ["id" => (int)$_POST['hiddendata'], "firstname" => $_POST['update_first_name'], "lastname" => $_POST['update_last_name'], "statususer" => (int)$_POST['update_status'], "role" => $arrRole[$_POST['update_role']]];
                    echo json_encode($responses);
                } else {
                    $responses["status"] = false;
                    $responses["error"]=["code" => 204, "message" => "status for update not found"];
                    echo json_encode($responses);
                }
            } else {
                $responses["status"] = false;
                $responses["error"]=["code" => 203, "message" => "role for update not found"]; 
                echo json_encode($responses);
            }
        } else {
            $responses["status"] = false;
            $responses["error"]=["code" => 202, "message" => "last name for update not found"];
            echo json_encode($responses);
        }
    } else {
        $responses["status"] = false;
        $responses["error"]=["code" => 201, "message" => "first name for update not found"];
        echo json_encode($responses);
    }   
} else {
    $responses["status"] = false;
    $responses["error"]=["code" => 200, "message" => "id for update not found"];
    echo json_encode($responses);
}

?>