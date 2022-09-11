<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$db = "exercise";

$conn = new mysqli($servername, $username, $password, $db);

if(!$conn){
    die(mysqli_error($conn));
}
?>