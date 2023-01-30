<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../classes/user.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$user_obj = new User($db_lv);

$page_title = "Admin | Users";

include "header.php";

$page_url = "userMain.php?";

// read all users from the database
$stmt = $user_obj->readAll($from_record_num, $records_per_page);

// count retrieved users
$num = $stmt->rowCount();

?>
<!-- Button trigger modal -->
<div class="row">
    <div class="col">
        <form method="POST"  id="searchUserForm" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-1" type="text" name="Search_ht" placeholder="Search for name, ID or access Level">
            <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="col">
        <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#addUserModal">
            Add User
        </button>
    </div>

</div>
<!-- Modal for ADD USER-->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="addUserForm">
                <div class="modal-body">
                    <label>First Name</label>
                    <input class="form-control" type="text" name="UserFirstName_ht">
                    <label>Last Name</label>
                    <input class="form-control" type="text" name="UserLastName_ht">
                    <label>Username</label>
                    <input class="form-control" type="text" name="Username_ht">
                    <label>Password</label>
                    <input class="form-control" type="password" name="UserPassword_ht">
                    <fieldset class="form-group">
                        <label>Access Level</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="AccessLevel_ht" id="optionsRadios1" value="Client">Client</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="AccessLevel_ht" id="optionsRadios2" value="Admin">Admin</label>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-info addSuccess">Add User</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--TABLE-->
<?php
if ($num > 0) {
?>
    <div class="container-fluid">
        <div class="row mt-3" id="userTable">
            <table class="table table-borderless table-light">
                <thead>
                    <tr class='table-dark'>
                        <th>id (A_I)</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Access Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                                <td>{$UserId_fld}</td>
                                <td>{$UserFirstName_fld}</td>
                                <td>{$UserLastName_fld}</td>
                                <td>{$Username_fld}</td>
                                <td>{$UserPassword_fld}</td>
                                <td>{$AccessLevel_fld}</td>";
                        echo "<td>";
                                if($AccessLevel_fld=='Admin'){
                                        echo "<button type='button' class='btn btn-outline-danger deleteButton' userIdDelete='$UserId_fld'><i class='fas fa-trash-alt'></i></button>";
                                }else if ($AccessLevel_fld=='Client'){
                                            echo "<button type='button' class='btn btn-outline-danger deleteButton' userIdDelete='$UserId_fld'><i class='fas fa-trash-alt'></i></button>
                                            <button type='button' class='btn btn-outline-success'><i class='fas fa-eye'></i></button>";
                                }
                                echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}

$page_url = "userMain.php?";
$total_rows = $user_obj->countClients();

// actual paging buttons
include 'paging.php';

// tell the user there are no selfies
if ($num = 0) {
    echo "<div class='alert alert-danger'>
                <strong>No users found.</strong>
            </div></div>
            </div>";
}
?>

<!--SCRIPT-->
<script src="../scripts/user.js"></script>

<?

include "footer.php";
?>