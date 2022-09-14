<?php
include 'connect.php';

if(isset($_POST['displaySend']) && !empty($_POST['displaySend'])) {
    $table = '<table class="table table-bordered">
    <thead>
        <tr>
            <th class="align-top">
                <div
                    class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0">
                    <input type="checkbox" class="custom-control-input" id="all-items">
                    <label class="custom-control-label" for="all-items"></label>
                </div>
            </th>
            <th class="max-width">Name</th>
            <th class="sortable">Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>';

    $sql = "SELECT * FROM `crud`";
    $result = mysqli_query($conn,$sql);
    // $responses = $result->fetch_all(MYSQLI_ASSOC);
    $number = 1;
    while($row = mysqli_fetch_assoc($result)) {
    // foreach($responses as $row) {
        $table .= '<tr>
        <td class="align-middle">
            <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                <input type="checkbox" class="custom-control-input check-action" id="item_'.$number.'" value='.$row['id'].'>
                <label class="custom-control-label" for="item_'.$number.'"></label>
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
    $number++;
    }
    $table .= '</tbody>
                </table>';
    echo $table;
}
else {
    $responses["status"] = "false";
    $responses["error"] = ["code" => "1", "message" => "data display error"];
    echo json_encode($responses);
}

?>