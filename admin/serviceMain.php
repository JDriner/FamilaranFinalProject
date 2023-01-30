<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../classes/service.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$service_obj = new Service($db_lv);

$page_title = "Admin | Services";

include "header.php";

$page_url = "serviceMain.php?";

// read all services from the database
$stmt = $service_obj->readAll($from_record_num, $records_per_page);

// count retrieved services
$num = $stmt->rowCount();
?>
<!-- Button trigger modal -->
<div class="row">
    <div class="col">
        <form method="POST" id="searchServiceForm" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-1" type="text" name="Search_ht" placeholder="Search">
            <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="col">
        <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#addServiceModal">
            Add Service
        </button>
    </div>

</div>
<!-- Modal for ADD SERVICE-->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="addServiceForm">
                <div class="modal-body">
                    <label>Service Code</label>
                    <input class="form-control" type="text" name="ServiceCode_ht">
                    <label>Service Name</label>
                    <input class="form-control" type="text" name="ServiceName_ht">
                    <label>Service Description</label>
                    <textarea class="form-control" name="ServiceDescription_ht" rows="3"></textarea>
                    <label>Price</label>
                    <input class="form-control" type="text" name="ServicePrice_ht">
                    <fieldset class="form-group">
                        <label>Status</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="ServiceStatus_ht" id="optionsRadios1" value="Available">Available</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="ServiceStatus_ht" id="optionsRadios2" value="Unavailable">Unavailable</label>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Button and modal for update-->
<div class="modal fade" id="updateServiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Service</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="showModalBodyFooter"></div>
        </div>
    </div>
</div>
<!--TABLE-->
<?php
if ($num > 0) {
?>
    <div class="container-fluid">
        <div class="row mt-3" id="serviceTable">
            <table class="table table-borderless table-light">
                <thead>
                    <tr class='table-dark'>
                        <th>Service ID</th>
                        <th>Code</th>
                        <th colspan="2">Name</th>
                        <th colspan="3">Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th colspan='2'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                                <td>{$ServiceId_fld}</td>
                                <td>{$ServiceCode_fld}</td>
                                <td colspan='2'>{$ServiceName_fld}</td>
                                <td colspan='3'>{$ServiceDescription_fld}</td>
                                <td>₱{$ServicePrice_fld}.00</td>
                                <td>{$ServiceStatus_fld}</td>
                                <td colspan='2'>
                                    <button type='button' class='btn btn-outline-danger deleteButton' serviceIdDelete='$ServiceId_fld'><i class='fas fa-trash-alt'></i></button>
                                    <button type='button' class='btn btn-outline-success updateButton' serviceIdUpdate='$ServiceId_fld'><i class='fas fa-pencil-alt'></i></button>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $page_url = "serviceMain.php?";
            $total_rows = $service_obj->countService();
            // actual paging buttons
            include 'paging.php';
            ?>

        </div>
    </div>
<?php

}
// tell the service there are no selfies
if ($num == 0) {
    echo "<div class='alert alert-danger'>
                <strong>No services found.</strong>
            </div></div>
            </div>";
}
?>

<!--SCRIPT-->
<script src="../scripts/service.js"></script>

<?

include "footer.php";
?>