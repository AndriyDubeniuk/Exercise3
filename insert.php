<?php
include 'connect.php';
include 'arrayrole.php';

extract($_POST);

if(isset($_POST['first_nameSend']) && !empty($_POST['first_nameSend'])) {
    if(isset($_POST['last_nameSend']) && !empty($_POST['last_nameSend'])) {
        if(isset($_POST['roleSend']) && !empty($_POST['roleSend'])) {
            if(isset($_POST['statusSend'])) {

                    // for multiple $roles = implode(',',$roleSend);
                    $sql = "INSERT INTO `crud` (`firstname`, `lastname`, `role`, `status`) VALUES ('$first_nameSend', '$last_nameSend', '$roleSend', '$statusSend')";
                    $result = mysqli_query($conn,$sql);
                    $lastid = mysqli_insert_id($conn);
                    $role = $arrRole[$_POST['roleSend']];
                    
                    $responses["status"] = true;
                    $responses["error"] = null;
                    $responses["user"] = ["id" => $lastid, "firstname" => $_POST['first_nameSend'], "lastname" => $_POST['last_nameSend'], "statususer" => (int)$_POST['statusSend'], "role" => $role];
                    
                    echo json_encode($responses);

                } else {
                    $responses["status"] = false;
                    $responses["error"]=["code" => 104, "message" => "status for add not found"];
                    echo json_encode($responses);
                }
            } else {
                $responses["status"] = false;
                $responses["error"]=["code" => 103, "message" => "role for add not found"];
                echo json_encode($responses);
            }
        } else {
            $responses["status"] = false;
            $responses["error"]=["code" => 102, "message" => "last name for add not found"];
            echo json_encode($responses);
        }
    } else {
        $responses["status"] = false;
        $responses["error"]=["code" => 101, "message" => "first name for add not found"];
        echo json_encode($responses);
    }

?>