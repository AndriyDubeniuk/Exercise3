$(document).ready(function() {
    DisplayData();
    
    $(".buttonOkUp").on("click", function() {
        let arr_id = [];

        $(".check-action:checked").each(function() {
            arr_id.push(this.value);
        })
    
        if(arr_id.length == 0) {
            AlertWindow("Alert!","No users selected! Please select a user!");
        } else {
            if($(".selectActionUp").val() == "SetActive") {
                SetActivity(arr_id, 1);
            } else if($(".selectActionUp").val() == "SetNotActive") {
                SetActivity(arr_id, 0);
            } else if ($(".selectActionUp").val() == "Delete") {
                DeleteUser(arr_id);
            } else {
                AlertWindow("Alert!","No action selected! Please select an action!");
            }
        }
    });

    $(".buttonOkDown").on("click", function() {
        let arr_id = [];
        $(".check-action:checked").each(function(i) {
            arr_id[i] = $(this).val();
        })
    
        if(arr_id.length == 0) {
            AlertWindow("Alert!","No users selected! Please select a user!");
        } else {
            if($(".selectActionDown").val() == "SetActive") {
                SetActivity(arr_id, 1);
            } else if($(".selectActionDown").val() == "SetNotActive") {
                SetActivity(arr_id, 0);
            } else if ($(".selectActionDown").val() == "Delete") {
                DeleteUser(arr_id);
            } else {
                AlertWindow("Alert!","No action selected! Please select an action!");
            }
        }
    });

});

$(document).on("click", ".buttonAddEdit", function() {
    let dataid = $(this).data("id");
    if (dataid == "") {
        $("#UserModalLabel").text("Add User");
        $("#formId")[0].reset();
        $("#error").text('');
    } else {
        GetDetails(dataid);
    }
    $("#buttonSave").off("click").on("click", function() {
        if (dataid == "") {
            AddUser();
        } else {
            UpdateDetails(dataid);
        }
    });
});

$(document).on("click", "#all-items", function() {
    $(".check-action").prop("checked", $(this).prop("checked"));
});

$(document).on("click", ".check-action", function() {
    if($(this).prop("checked")==false){
        $("#all-items").prop("checked", false);
    }
    if($(".check-action:checked").length == $(".check-action").length) {
        $("#all-items").prop("checked", true);
    }
});

$(document).on("click", ".delete-user", function() {
    let arr_id = [];
    arr_id.push($(this).val());
    console.log(arr_id); 
    DeleteUser(arr_id);
});

const arrStatus = ["not-active","active"];

function AlertWindow(title, body) {
    $("#modal-alert").modal("show");
    $("#modal-alert-title").text(title);
    $("#modal-alert-body").text(body);
}

function DisplayData() {
    let displayData = "true";
    $.ajax({
        url: "display.php",
        type:"post",
        dataType: "json",
        data: {
            displaySend:displayData
        },
        success:function(data, status){
            if(data.status == true) {
                let table = "";
                for(let i=0; i<data.users.length; i++) {
                    table += `<tr id="row_${data.users[i].id}">
                    <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-naeless m-0 align-top">
                            <input type="checkbox" class="custom-control-input check-action" id="item_${data.users[i].id}" value=${data.users[i].id}>
                            <label class="custom-control-label" for="item_${data.users[i].id}"></label>
                        </div>
                    </td>
                    <td class="text-nowrap align-middle first-last-name">${data.users[i].firstname} ${data.users[i].lastname}</td>
                    <td class="text-nowrap align-middle role-name"><span>${data.users[i].role}</span></td>
                    <td class="text-center align-middle status-name"><i class="fa fa-circle ${arrStatus[data.users[i].status_user]}-circle" id="status" value=${data.users[i].status_user}></i></td>
                    <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <button class="btn btn-sm btn-outline-secondary badge buttonAddEdit" data-id="${data.users[i].id}" type="button">Edit</button>
                            <button class="btn btn-sm btn-outline-secondary badge delete-user" data-toggle="modal" data-target="#modal-confirm" value=${data.users[i].id} type="button"><i
                            class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
                }
                $(".table").append(table);
            } else {
                $(".card-body").text(data.error.message);
            }
        }
    });
}

function AddUser(){
    let first_nameAdd = $('#first_name').val();
    let last_nameAdd = $('#last_name').val();
    let roleAdd = $('#role').val();
    let statusAdd = $('#switch').prop("checked") ? 1 : 0;

    $.ajax({
        url:"insert.php",
        type:"post",
        dataType: "json",
        data:{
            first_nameSend:first_nameAdd,
            last_nameSend:last_nameAdd,
            roleSend:roleAdd,
            statusSend:statusAdd
        },
        success:function(data, status) {
            if(data.status == true) {
                $('#user_form_modal').modal('hide');
                let table = "";
                table += `<tr id="row_${data.user.id}">
                <td class="align-middle">
                    <div class="custom-control custom-control-inline custom-checkbox custom-control-naeless m-0 align-top">
                        <input type="checkbox" class="custom-control-input check-action" id="item_${data.user.id}" value="${data.user.id}">
                        <label class="custom-control-label" for="item_${data.user.id}"></label>
                    </div>
                </td>
                <td class="text-nowrap align-middle first-last-name">${data.user.firstname} ${data.user.lastname}</td>
                <td class="text-nowrap align-middle role-name"><span>${data.user.role}</span></td>
                <td class="text-center align-middle status-name"><i class="fa fa-circle ${arrStatus[data.user.statususer]}-circle" value=${data.user.statususer}></i></td>
                <td class="text-center align-middle">
                    <div class="btn-group align-top">
                        <button class="btn btn-sm btn-outline-secondary badge buttonAddEdit" data-id="${data.user.id}" type="button">Edit</button>
                        <button class="btn btn-sm btn-outline-secondary badge delete-user" data-toggle="modal" data-target="#modal-confirm" value=${data.user.id} type="button"><i
                        class="fa fa-trash"></i></button>
                    </div>
                </td> 
            </tr>`;
                $(".table").append(table);
                if ($("#all-items").prop("checked")==true) {
                    $("#item_"+data.user.id).prop("checked", true);
                }
            } else {
                $('#user_form_modal').modal('show');
                $("#error").text("Error: " + data.error.message);
            }
        }
    });
}

function DeleteUser(arr_id) {
    let strUsers = "";
    for(let i=0; i<arr_id.length; i++) {
        strUsers += $("#row_"+arr_id[i]).find("td.first-last-name").text() + ", ";
    }
    strUsers = strUsers.slice(0,-2);
    $("#modal-confirm-body").text("Are you sure you want to delete this user: " + strUsers + "?");
    $("#modal-confirm").modal("show");
    $("#modal-confirm-ok").one("click", function() {
        $.ajax({
            url:"delete.php",
            type:"post",
            dataType: "json",
            data: {
                arr_idSend:arr_id
            },
            success:function(data, status) {
                if(data.status == true) {
                    if (data.users.length == $(".check-action").length) {
                        $("#all-items").removeAttr("checked"); 
                    }    
                    for(let i=0; i<data.users.length; i++) {
                        $("#row_"+data.users[i]).remove();
                    }
                } else {
                    AlertWindow("Error!", data.error.message);
                }
            }
        });
    });
}

function SetActivity(activityIdArr,statusUser) {
    $.ajax({
        url:"activity.php",
        type:"post",
        dataType: "json",
        data: {
            activitySend:activityIdArr,
            statusUserSend:statusUser
        },
        success:function(data, status) {
            if(data.status == true) {
                let activity = `<i class="fa fa-circle ${arrStatus[data.status_user]}-circle" value="${data.status_user}"></i>`;
                for(let i=0; i<data.users.length; i++) {
                    $("#row_"+data.users[i]).find("i.fa-circle").replaceWith(activity);
                }
            } else {
                AlertWindow("Error!", data.error.message);
            }
        }
    });
}

function GetDetails(updateId) {
    $.ajax({
        url:"get.php",
        type:"post",
        dataType: "json",
        data: { 
            updateId:updateId 
        }, 
        success:function(data, status) {
            if(data.status == true) {
                $("#UserModalLabel").text("Update Details");
                $("#formId")[0].reset();
                $('#user_form_modal').modal('show'); 
                $('#first_name').val(data.user.firstname);
                $('#last_name').val(data.user.lastname);
                $('#role').val(data.user.role);
                data.user.status == 1 ? $('#switch').prop("checked", true) : $('#switch').prop("checked", false);
                $("#error").text('');
            } else {
                AlertWindow("Error!", data.error.message);
            }
        }
    });
}

function UpdateDetails(updateId) {
    let update_first_name = $('#first_name').val();
    let update_last_name = $('#last_name').val();
    let update_role = $('#role').val();
    let update_status = $('#switch').prop("checked") ? 1 : 0;

    $.ajax({
        url:"update.php",
        type:"post",
        dataType: "json",
        data: { 
            update_first_name:update_first_name,
            update_last_name:update_last_name,
            update_role:update_role,
            update_status:update_status,
            updateId:updateId
        },
        success:function(data, status) {
            if(data.status == true) {
                let tdname = `<td class="text-nowrap align-middle first-last-name">${data.user.firstname} ${data.user.lastname}</td>`;
                let tdrole = `<td class="text-nowrap align-middle role-name"><span>${data.user.role}</span></td>`;
                let tdstatus = `<td class="text-center align-middle status-name"><i class="fa fa-circle ${arrStatus[data.user.statususer]}-circle" value=${data.user.statususer}></i></td>`;
                $("#row_"+data.user.id).find("td.first-last-name").replaceWith(tdname);
                $("#row_"+data.user.id).find("td.role-name").replaceWith(tdrole);
                $("#row_"+data.user.id).find("td.status-name").replaceWith(tdstatus);
                $('#user_form_modal').modal('hide');
            } else {
                $('#user_form_modal').modal('show');
                $("#error").text("Error: " + data.error.message );
            }
        }
    });
}