<?php
include 'connect.php';

if (isset($_POST['updateId'])) {
    $user_id = $_POST['updateId'];

    $sql = "SELECT * FROM `crud` WHERE id = $user_id";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    if ( $count > 0 ) {
        $responses["status"] = true;
        $responses["error"] = null;
        while($row = mysqli_fetch_assoc($result)) {  
            // for multiple $row["role"] = explode(",", $row["role"]);
            $rowResp = $row;
        }
        $rowResp["id"] = intval($rowResp["id"]);
        $rowResp["status"] = intval($rowResp["status"]);
        $rowResp["role"] = intval($rowResp["role"]);
        $responses["user"] = $rowResp;
        echo json_encode($responses);
    } else {
        $responses["status"] = false;
        $responses["error"] = ["code" => 205, "message" => "This user does not exist"];
        echo json_encode($responses);
    }

} else {
    $responses["status"] = false;
    $responses["error"]=["code" => 204, "message" => "id for get not found"];
    echo json_encode($responses);
}

?>