<?php
include 'connect.php';

extract($_POST);

if(isset($_POST['first_nameSend']) && !empty($_POST['first_nameSend'])) {
    if(isset($_POST['last_nameSend']) && !empty($_POST['last_nameSend'])) {
        if(isset($_POST['statusSend']) && !empty($_POST['statusSend'])) {
            if(isset($_POST['roleSend']) && !empty($_POST['roleSend'])) {

                    $sql = "INSERT INTO `crud` (`firstname`, `lastname`, `role`, `status`) values ('$first_nameSend', '$last_nameSend', '$roleSend', '$statusSend')";
                    $result = mysqli_query($conn,$sql);

                    $response["status"] = "true";
                    $response["error"] = "null";
                    $response["user"] = ["firstname" => $_POST['first_nameSend'], "lastname" => $_POST['last_nameSend'], "statususer" => $_POST['statusSend'], "role" => $_POST['roleSend']];
                    print_r($response);

                } else {
                    $response["status"] = "false";
                    $response["error"]=["code" => "104", "message" => "role for add not found"];
                    print_r($response);
                }
            } else {
                $response["status"] = "false";
                $response["error"]=["code" => "103", "message" => "status for add not found"];
                print_r($response);
            }
        } else {
            $response["status"] = "false";
            $response["error"]=["code" => "102", "message" => "last name for add not found"];
            print_r($response);
        }
    } else {
        $response["status"] = "false";
        $response["error"]=["code" => "101", "message" => "first name for add not found"];
        print_r($response);
    }

?>