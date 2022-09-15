<?php
include 'connect.php';

if(isset($_POST['displaySend']) && !empty($_POST['displaySend'])) {
    $table = "";
    $sql = "SELECT * FROM `crud`";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)) {
        $table .= '<tr id="row_'.$row['id'].'">
        <td class="align-middle">
            <div class="custom-control custom-control-inline custom-checkbox custom-control-naeless m-0 align-top">
                <input type="checkbox" class="custom-control-input check-action" id="item_'.$row['id'].'" value='.$row['id'].'>
                <label class="custom-control-label" for="item_'.$row['id'].'"></label>
            </div>
        </td>
        <td class="text-nowrap align-middle">'.$row['firstname']. ' '.$row['lastname'].'</td>
        <td class="text-nowrap align-middle"><span>'.$row['role'].'</span></td>
        <td class="text-center align-middle"><i class="fa fa-circle '.$row['status'].'-circle" id="status" value='.$row['status'].'></i></td>
        <td class="text-center align-middle">
            <div class="btn-group align-top">
                <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user_form_modal" onclick="GetDetails('.$row['id'].')">Edit</button>
                <button class="btn btn-sm btn-outline-secondary badge delete-user" data-toggle="modal" data-target="#modal-confirm" value='.$row['id'].' type="button"><i
                  class="fa fa-trash"></i></button>
            </div>
        </td>
    </tr>';
    
    }
    echo $table;
}
else {
    $responses["status"] = "false";
    $responses["error"] = ["code" => "1", "message" => "data display error"];
    echo json_encode($responses);
}

?>