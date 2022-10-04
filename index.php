<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise №3</title>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./js/script.js"></script>
</head>
<body>
<?php require_once 'arrayrole.php' ?>
<div class="container">
    <div class="row flex-lg-nowrap"> 
        <div class="col">
            <div class="d-flex justify-content-center mb-3" id="allbuttuons">
                <button type="button" class="btn btn-outline-secondary mr-3 buttonAdd" data-toggle="modal" data-target="#user_form_modal">
                    Add User
                </button>
                <select class="form-control border-secondary w-50 selectActionUp">
                <option selected value>--- Please select an action ---</option>
                <option value="SetActive">Set active</option>
                <option value="SetNotActive">Set not active</option>
                <option value="Delete">Delete</option>
                </select>
                <button type="button" class="btn btn-outline-secondary ml-3 buttonOkUp">
                    OK
                </button>
            </div>

                    <div class="row flex-lg-nowrap">
                        <div class="col mb-3">
                            <div class="e-panel card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6 class="mr-2"> 
                                            <span>Users</span>
                                        </h6>
                                    </div>
                                    <div class="e-table">
                                        <div class="table-responsive table-lg mt-3">
                                            <table class="table table-bordered">
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
                                                <tbody id="displayDataTable">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="clonebuttons"></div>


                    <!-- Modal Edit/Update -->
                    <div class="modal fade" id="user_form_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="UserModalLabel">Add User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="formId">
                                    <div class="form-group">
                                    <label for="first_name" class="col-form-label">First Name:</label>
                                    <input type="text" class="form-control" id="first_name" placeholder="Enter your first name">
                                    </div>
                                    <div class="form-group">
                                    <label for="last_name" class="col-form-label">Last Name:</label>
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter your last name">
                                    </div>
                                    <div class="form-group">
                                    <label for="role" class="col-form-label">Role:</label>
                                    <select  class='form-control' id='role'>
                                        <?php foreach($arrRole as $id => $role): ?>
                                            <option value=<?=$id?>><?=$role?></option>
                                            <?php endforeach ?>
                                    </select>    
                                    </div>
                                    <div class="form-group">
                                            <input type="checkbox" class="switch"  id="switch">
                                            <label for="switch" class="statuslabel">Status: </label>
                                            <label class="statusactive ml-5">(Not Active / Active) </label>  
                                    </div>
                                </form>
                                <p class="text-danger" id="error"></p>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary save-button" id="buttonSave">Save</button>
                                    <!-- onclick="CheckFunc()" -->
                                    <input type="hidden" id="hiddendata">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Confirm -->
                    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="modal-confirm-title">Delete User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body p-3" id="modal-confirm-body">
                            Are you sure you want to delete?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modal-confirm-close" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="modal-confirm-ok"  data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- Modal Alert -->
                    <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="modal-alert-title">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body p-3" id="modal-alert-body">Modal body
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="modal-alert-ok"  data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                        </div>
                    </div>

        </div>
    </div>
</div>
<script></script>
</body>
</html>