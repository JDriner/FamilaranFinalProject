<?php
// core configuration
include_once "config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once 'config/database.php';
include_once 'classes/user.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$user_obj = new User($db_lv);

$page_title = "Client | Edit Account";

include "header.php";

$page_url = "userViewAccount.php?";

?>

<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Account</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="showModalBodyFooter"></div>
        </div>
    </div>
</div>
<div class="container rounded bg-white mt-5">
    <div class="row">
        <div class="col-md-4 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" src="assets/images/userIcon.png" width="130">
                    <span class="font-weight-bold"><?php echo $_SESSION['userFirstName']." ".$_SESSION['userLastName']; ?></span>
                    <span class="text-black-50"><?php echo $_SESSION['username']; ?></span>
                    <span><?php echo $_SESSION['accessLevel']; ?></span>
        </div>
        </div>
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex flex-row align-items-center back"><i class="fa fa-user mr-1 mb-1"></i>
                        <h6>Account Information</h6>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">First Name</label>
                            <input class="form-control" id="readOnlyInput" type="text" value="<?php echo $_SESSION['userFirstName']; ?>" readonly="">
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Last Name</label>
                            <input class="form-control" id="readOnlyInput" type="text" value="<?php echo $_SESSION['userLastName']; ?>" readonly="">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                            <label for="exampleInputEmail1">Access Level</label>
                            <input class="form-control" id="readOnlyInput" type="text" value="<?php echo $_SESSION['accessLevel']; ?>" readonly="">
                    </div>
                </div>
            </div>
            <div class="p-3 py-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex flex-row align-items-center back"><i class="fa fa-th-list mr-1 mb-1"></i>
                        <h6>Personal Information</h6>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                            <label for="exampleInputEmail1">Username</label>
                            <input class="form-control" id="readOnlyInput" type="text" value="<?php echo $_SESSION['username']; ?>" readonly="">
                    </div>
                    <div class="col-md-6">
                            <label for="exampleInputPassword1">Password</label>
                            <input class="form-control" id="readOnlyInput" type="password" value="<?php echo $_SESSION['password']; ?>" readonly="">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type='button' class='btn btn-danger float-right updateButton' userIdUpdate='<?php echo $_SESSION["userId"]; ?>'>UPDATE ACCOUNT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts/user.js"></script>

<?php
include "footer.php";
?>