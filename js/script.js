
$(document).ready(function() {
    DisplayData();
    let buttons = $("#allbuttuons").clone();
    $("#clonebuttons").append(buttons);
    buttons.find(".selectActionUp").removeClass("selectActionUp").addClass("selectActionDown");
    buttons.find(".buttonOkUp").removeClass("buttonOkUp").addClass("buttonOkDown");
});

$(document).on("click", "#all-items", function() {
    $(".check-action").prop("checked", $(this).prop("checked"));
});

$(document).on("click", ".check-action", function() {
    if($(this).prop("checked")==false){
        $("#all-items").prop("checked", false)
    }
    if($(".check-action:checked").length == $(".check-action").length) {
        $("#all-items").prop("checked", true)
    }
});

$(document).on("click", ".buttonAdd", function() {
    $("#UserModalLabel").text("Add User");
    $("#formId")[0].reset();
    $('#hiddendata').val('');
});

$(document).on("click", ".delete-user", function() {
    DeleteConfirm($(this).val());
});

$(document).on("click", ".buttonOkUp", function() {
    let arr_id = [];
    $(".check-action:checked").each(function(i) {
        arr_id[i] = $(this).val();
    })

    if(arr_id.length == 0) {
        AlertWindow("Alert!","No users selected! Please select a user!");
    } else {
        if($(".selectActionUp").val() == "SetActive") {
            for(let i = 0; i < arr_id.length; i++) {
                SetActivity(arr_id[i], "active");
            }
        } else if($(".selectActionUp").val() == "SetNotActive") {
            for(let i = 0; i < arr_id.length; i++) {
                SetActivity(arr_id[i], "not-active");
            } 
        } else if ($(".selectActionUp").val() == "Delete") {
            for(let i = 0; i < arr_id.length; i++) {
                DeleteConfirm(arr_id[i]);
            }
        } else {
            AlertWindow("Alert!","No action selected! Please select an action!");
        }
    }
});




$(document).on("click", ".buttonOkDown", function() {
    let arr_id = [];
    $(".check-action:checked").each(function(i) {
        arr_id[i] = $(this).val();
    })

    if(arr_id.length == 0) {
        AlertWindow("Alert!","No users selected! Please select a user!");
    } else {
        if($(".selectActionDown").val() == "SetActive") {
            for(let i = 0; i < arr_id.length; i++) {
                SetActivity(arr_id[i], "active");
            }
        } else if($(".selectActionDown").val() == "SetNotActive") {
            for(let i = 0; i < arr_id.length; i++) {
                SetActivity(arr_id[i], "not-active");
            } 
        } else if ($(".selectActionDown").val() == "Delete") {
                for(let i = 0; i < arr_id.length; i++) {
                    DeleteConfirm(arr_id[i]);
                } 
        } else {
            AlertWindow("Alert!","No action selected! Please select an action!");
        }
    }
});

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
            $('#displayDataTable').html(data);
        }
    });
}

function AddUser(){
    let first_nameAdd = $('#first_name').val();
    let last_nameAdd = $('#last_name').val();
    let roleAdd = $('#role').val();
    let statusAdd = $('#switch').prop("checked") ? "active" : "not-active";

    $.ajax({
        url:"insert.php",
        type:"post",
        data:{
            first_nameSend:first_nameAdd,
            last_nameSend:last_nameAdd,
            roleSend:roleAdd,
            statusSend:statusAdd
        },
        success:function() {
            $('#user_form_modal').modal('hide');
            DisplayData();
        }
    });
}

function DeleteUser(deleteId) {
        $.ajax({
            url:"delete.php",
            type:"post",
            data: {
                deleteSend:deleteId
            },
            success:function(data, status) {
                    DisplayData();
                }
        });
}

function DeleteConfirm(deleteId) {
    $("#modal-confirm").modal("show");
    $("#modal-confirm-ok").on("click", function() {
        DeleteUser(deleteId);      
    });

}

function AlertWindow(title, body) {
    $("#modal-alert").modal("show");
    $("#modal-alert-title").text(title);
    $("#modal-alert-body").text(body);
    $("#modal-alert-close").hide();

}

function SetActivity(activityId,statusUser) {
    $.ajax({
        url:"activity.php",
        type:"post",
        data: {
            activitySend:activityId,
            statusUserSend:statusUser
        },
        success:function() {
            DisplayData();
        }
    });
}

function GetDetails(updateId) {
    $("#UserModalLabel").text("Update Details");
    $("#formId")[0].reset();
    $('#hiddendata').val(updateId);
    $.post("get.php",
        { updateId:updateId }, 
        function(data) {
            let userid=JSON.parse(data);
            $('#first_name').val(userid.user.firstname);
            $('#last_name').val(userid.user.lastname);
            $('#role').val(userid.user.role);
            userid.user.status == "active" ? $('#switch').prop("checked", true) : $('#switch').prop("checked", false)
        });
}

function UpdateDetails() {
    let update_first_name = $('#first_name').val();
    let update_last_name = $('#last_name').val();
    let update_role = $('#role').val();
    let update_status = $('#switch').prop("checked") ? "active" : "not-active";
    let hiddendata=$('#hiddendata').val();

    $.post("update.php", {
        update_first_name:update_first_name,
        update_last_name:update_last_name,
        update_role:update_role,
        update_status:update_status,
        hiddendata:hiddendata
    }, function() {
        $('#user_form_modal').modal('hide');
        DisplayData();
    });
}