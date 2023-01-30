<?php
include "config/database.php";
include "classes/user.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();

if ($_POST) {
    $user_obj = new User($db_lv);
    $user_obj->UserId_cv = $_POST['userId_js'];
    $user_obj->viewOneUser();


    echo '<form method="POST" id="updateUserForm">
                <div class="modal-body">
                    <label>ID Number</label>
                    <input class="form-control" type="hidden" name="UserId_ht" value=' . $user_obj->UserId_cv . '>
                    <label>First Name</label>
                    <input class="form-control" type="text" name="UserFirstName_ht" value=' . $user_obj->UserFirstName_cv . '>
                    <label>Last Name</label>
                    <input class="form-control" type="text" name="UserLastName_ht" value=' . $user_obj->UserLastName_cv . '>
                    <label>Username</label>
                    <input class="form-control" type="text" name="Username_ht" value=' . $user_obj->Username_cv . '>
                    <label>Password</label>
                    <input class="form-control" type="password" name="UserPassword_ht" value=' . $user_obj->UserPassword_cv . '>
                    <fieldset class="form-group">
                        <div class="form-group">
                            <label for="exampleSelect1">Access Level</label>
                                <select class="custom-select" name="AccessLevel_ht" value=' . $user_obj->AccessLevel_cv.'>
                                    <option selected>' . $user_obj->AccessLevel_cv . '</option>
                                </select>
                      </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>';
}
?>
<script src="../scripts/user.js"></script>