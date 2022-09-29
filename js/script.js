$(document).ready(function() {
    DisplayData();
    let buttons = $("#allbuttuons").clone();
    $("#clonebuttons").append(buttons);
    buttons.find(".selectActionUp").removeClass("selectActionUp").addClass("selectActionDown");
    buttons.find(".buttonOkUp").removeClass("buttonOkUp").addClass("buttonOkDown");

    // $("#user_form_modal").on("keyup", function() {
    //     if ($("#first_name").val() != "") {
    //         $("#error").text('');
    //         if ($("#last_name").val() != "") {
    //             $("#error").text('');
    //             $("#role").on("change", function() {
    //                 if ($("#role").val() != "") {
    //                     $("#error").text('');
    //                 }
    //             });
    //         }
    //     }
    // });

    $("#displayDataTable").bind("DOMSubtreeModified", function() {
        if ($("#all-items").prop("checked")==true) {
            $(".check-action").prop("checked", true);
        }
    });

    $(".buttonAdd").on("click", function() {
        $("#UserModalLabel").text("Add User");
        $("#formId")[0].reset();
        $("#hiddendata").val('');
        $("#error").text('');
    });
    
    $(".buttonOkUp").on("click", function() {
        let arr_id = [];

        // $(".check-action:checked").each(function(i) {
        //     arr_id[i] = $(this).val();
        // })

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
    DeleteUser(arr_id);
});

const arrStatus = ["not-active","active"];

function AlertWindow(title, body) {
    $("#modal-alert").modal("show");
    $("#modal-alert-title").text(title);
    $("#modal-alert-body").text(body);
}

function CheckFunc() {
    if($('#hiddendata').val() == '') {
        AddUser();
    } else {
        UpdateDetails();
    }
}

function DisplayData() {
    let displayData = "true";
    $.ajax({
        url: "display.php",
        type:"post",
        data: {
            displaySend:displayData
        },
        success:function(data, status){
            $(".table").append(data);
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
        data:{
            first_nameSend:first_nameAdd,
            last_nameSend:last_nameAdd,
            roleSend:roleAdd,
            statusSend:statusAdd
        },
        success:function(data, status) {
            let adddata=JSON.parse(data);
            if(adddata.status == true) {
                $('#user_form_modal').modal('hide');
                let table = "";
                table += `<tr id="row_${adddata.user.id}">
                <td class="align-middle">
                    <div class="custom-control custom-control-inline custom-checkbox custom-control-naeless m-0 align-top">
                        <input type="checkbox" class="custom-control-input check-action" id="item_${adddata.user.id}" value="${adddata.user.id}">
                        <label class="custom-control-label" for="item_${adddata.user.id}"></label>
                    </div>
                </td>
                <td class="text-nowrap align-middle first-last-name">${first_nameAdd} ${last_nameAdd}</td>
                <td class="text-nowrap align-middle role-name"><span>${adddata.user.role}</span></td>
                <td class="text-center align-middle status-name"><i class="fa fa-circle ${arrStatus[statusAdd]}-circle" id="status" value=${statusAdd}></i></td>
                <td class="text-center align-middle">
                    <div class="btn-group align-top">
                        <button class="btn btn-sm btn-outline-secondary badge" type="button" onclick="GetDetails(${adddata.user.id})">Edit</button>
                        <button class="btn btn-sm btn-outline-secondary badge delete-user" data-toggle="modal" data-target="#modal-confirm" value=${adddata.user.id} type="button"><i
                        class="fa fa-trash"></i></button>
                    </div>
                </td> 
            </tr>`;
                $(".table").append(table);
            } else {
                $('#user_form_modal').modal('show');
                $("#error").text("Error: " + adddata.error.message);
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
            data: {
                arr_idSend:arr_id
            },
            success:function(data, status) {
                if (arr_id.length == $(".check-action").length) {
                    $("#all-items").removeAttr("checked"); 
                }    
                for(let i=0; i<arr_id.length; i++) {
                    $("#row_"+arr_id[i]).remove();
                }
                arr_id = [];
            }
        });
    });
}

function SetActivity(activityIdArr,statusUser) {
    $.ajax({
        url:"activity.php",
        type:"post",
        data: {
            activitySend:activityIdArr,
            statusUserSend:statusUser
        },
        success:function(data, status) {
            let setdata=JSON.parse(data);
            if(setdata.status == true) {
                let activity = `<i class="fa fa-circle ${arrStatus[statusUser]}-circle" id="status" value="${statusUser}"></i>`;
                for(let i=0; i<setdata.users.length; i++) {
                    $("#row_"+setdata.users[i].id).find("i.fa-circle").replaceWith(activity);
                }
            } else {
                let strUsers = "";
                for(let i=0; i<setdata.error.users.length; i++) {
                    strUsers += $("#row_"+setdata.error.users[i].id).find("td.first-last-name").text() + ", ";
                }
                strUsers = strUsers.slice(0,-2);
                AlertWindow("Error!", strUsers + " - " + setdata.error.message);
            }
        }
    });
}

function GetDetails(updateId) {
    $.post("get.php",
        { updateId:updateId }, 
        function(data, status) {
            let userid=JSON.parse(data);
            if(userid.status == true) {
                $("#UserModalLabel").text("Update Details");
                $("#formId")[0].reset();
                $('#hiddendata').val(Number(updateId));
                $('#user_form_modal').modal('show'); 
                $('#first_name').val(userid.user.firstname);
                $('#last_name').val(userid.user.lastname);
                $('#role').val(userid.user.role);
                userid.user.status == 1 ? $('#switch').prop("checked", true) : $('#switch').prop("checked", false);
                $("#error").text('');
            } else {
                AlertWindow("Error!", userid.error.message);
            }
        });
}

function UpdateDetails() {
    let update_first_name = $('#first_name').val();
    let update_last_name = $('#last_name').val();
    let update_role = $('#role').val();
    let update_status = $('#switch').prop("checked") ? 1 : 0;
    let hiddendata=$('#hiddendata').val();

    $.post("update.php", {
        update_first_name:update_first_name,
        update_last_name:update_last_name,
        update_role:update_role,
        update_status:update_status,
        hiddendata:hiddendata
    }, function(data, status) {
        let updatedata=JSON.parse(data);
        if(updatedata.status == true) {
            let tdname = `<td class="text-nowrap align-middle first-last-name">${update_first_name} ${update_last_name}</td>`;
            let tdrole = `<td class="text-nowrap align-middle role-name"><span>${updatedata.user.role}</span></td>`;
            let tdstatus = `<td class="text-center align-middle status-name"><i class="fa fa-circle ${arrStatus[update_status]}-circle" id="status" value=${update_status}></i></td>`;
            $("#row_"+hiddendata).find("td.first-last-name").replaceWith(tdname);
            $("#row_"+hiddendata).find("td.role-name").replaceWith(tdrole);
            $("#row_"+hiddendata).find("td.status-name").replaceWith(tdstatus);
            $('#user_form_modal').modal('hide');
        } else {
            $('#user_form_modal').modal('show');
            $("#error").text("Error: " + updatedata.error.message );
        }
    });
}