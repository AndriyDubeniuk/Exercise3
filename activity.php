<?php
include 'connect.php';

if( isset($_POST['activitySend']) && !empty($_POST['activitySend'])) {
    if(isset($_POST['statusUserSend'])) {
        $status = $_POST['statusUserSend'];
        $usersExist = [];
        $usersDontExist = [];
        foreach($_POST["activitySend"] as $id) {
            $sql = "SELECT * FROM `crud` WHERE `id` = '$id'";
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            if ( $count > 0 ) {
                array_push($usersExist, ["id" => (int)$id, "status" => (int)$status]);
            } else {
                array_push($usersDontExist, ["id" => (int)$id]);
            }
        }
        if (empty($usersDontExist)) {
            foreach($usersExist as $id) {
                $idd = $id["id"];
                $sql = "UPDATE `crud` SET `status` = '$status' WHERE `id` = '$idd'";
                $result = mysqli_query($conn,$sql);
            }

            $responses["status"] = true;
            $responses["error"] = null;
            $responses["users"] = $usersExist;
            echo json_encode($responses);
        } else {
            $responses["status"] = false;
            $responses["error"] = ["code" => 52, "message" => "users does not exist", "users" => $usersDontExist];
            echo json_encode($responses);
        }

    } else {
        $responses["status"] = false;
        $responses["error"]=["code" => 51, "message" => "id for update activity not found"];
        echo json_encode($response);
    }
} else {
    $responses["status"] = false;
    $responses["error"]=["code" => 50, "message" => "activity for update activity not found"]; 
    echo json_encode($response);
}
?>