<?php
include 'connect.php';

if (isset($_POST['updateId'])) {
    $user_id = $_POST['updateId'];

    $sql = "SELECT * FROM `crud` WHERE id =$user_id";
    $result = mysqli_query($conn,$sql);
    $response = array();
    while($row = mysqli_fetch_assoc($result)) {
        $response=$row;
    }
    echo json_encode($response);
}

if(isset($_POST['hiddendata']) && !empty($_POST['hiddendata'])) {
    if(isset($_POST['update_first_name']) && !empty($_POST['update_first_name'])) {
        if(isset($_POST['update_last_name']) && !empty($_POST['update_last_name'])) {
            if(isset($_POST['update_status']) && !empty($_POST['update_status'])) {
                if(isset($_POST['update_role']) && !empty($_POST['update_role'])) {
                    $uniqueid = $_POST['hiddendata'];
                    $firstname = $_POST['update_first_name'];
                    $lastname = $_POST['update_last_name'];
                    $status = $_POST['update_status'];
                    $role = $_POST['update_role'];

                    $sql = "UPDATE `crud` SET `firstname` = '$firstname', `lastname` = '$lastname', `role` = '$role', `status` = '$status' WHERE `id`=$uniqueid";

                    $result = mysqli_query($conn,$sql);

                    $response["status"] = "true";
                    $response["error"] = "null";
                    $response["user"] = ["id" => $_POST['hiddendata'], "firstname" => $_POST['update_first_name'], "lastname" => $_POST['update_last_name'], "statususer" => $_POST['update_status'], "role" => $_POST['update_role']];
                    print_r($response);

                } else {
                    $response["status"] = "false";
                    $response["error"]=["code" => "204", "message" => "role for update not found"];
                    print_r($response);
                }
            } else {
                $response["status"] = "false";
                $response["error"]=["code" => "203", "message" => "status for update not found"];
                print_r($response);
            }
        } else {
            $response["status"] = "false";
            $response["error"]=["code" => "202", "message" => "last name for update not found"];
            print_r($response);
        }
    } else {
        $response["status"] = "false";
        $response["error"]=["code" => "201", "message" => "first name for update not found"];
        print_r($response);
    }
    
}

?>