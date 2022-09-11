let response = "";
$(document).ready(function() {
    DisplayData();

    $("#buttonOk").click(function() {
        let arr_id = [];
        response = "";
        $(".check-action:checked").each(function(i) {
            arr_id[i] = $(this).val();
        })

        if(arr_id.length == 0) {
            alert("No users selected! Please select a user!");
        } else {
            if($("#selectAction").val() == "SetActive") {
                for(let i = 0; i < arr_id.length; i++) {
                    SetActivity(arr_id[i], "active");
                }
            } else if($("#selectAction").val() == "SetNotActive") {
                for(let i = 0; i < arr_id.length; i++) {
                    SetActivity(arr_id[i], "not-active");
                } 
            } else if ($("#selectAction").val() == "Delete") {
                if (confirm("Are you sure you want to delete?")) {
                    for(let i = 0; i < arr_id.length; i++) {
                        DeleteUser(arr_id[i]);
                    } 
                }
            } else {
                alert("No action selected! Please select an action!");
            }
        }
    });
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

$(document).on("click", "#buttonAdd", function() {
    $("#UserModalLabel").text("Add Details");
    $("#formId")[0].reset();
    $('#hiddendata').val('');
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
        url:"display.php",
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
        success:function(data, status) {
            $('#user_form_modal').modal('hide');
            DisplayData();
            $('#errors').html(data);
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
                response += data;
                $('#errors').html(response);
            }
    });
}

function SetActivity(activityId,statusUser) {
    $.ajax({
        url:"activity.php",
        type:"post",
        data: {
            activitySend:activityId,
            statusUserSend:statusUser
        },
        success:function(data, status) {
            DisplayData();
            response += data;
            $('#errors').html(response);
        }
    });
}

function GetDetails(updateId) {
    $("#UserModalLabel").text("Update Details");
    $("#formId")[0].reset();
    $('#hiddendata').val(updateId);
    $.post("update.php",
        { updateId:updateId }, 
        function(data, status) {
            let userid=JSON.parse(data);
            $('#first_name').val(userid.firstname);
            $('#last_name').val(userid.lastname);
            $('#role').val(userid.role);
            userid.status == "active" ? $('#switch').prop("checked", true) : $('#switch').prop("checked", false)
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
    }, function(data, status) {
        $('#user_form_modal').modal('hide');
        DisplayData();
        response = data;
        $('#errors').html(response);
    });
}