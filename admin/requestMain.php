<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../classes/request.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$request_obj = new Requests($db_lv);

$page_title = "Admin | Client Requests";

include "header.php";

$page_url = "requestMain.php?";

    // read all requests from the database
    $stmt = $request_obj->readAll($from_record_num, $records_per_page);

    // count retrieved requests
    $num = $stmt->rowCount();
?>


<!--Button and modal for update-->
<div class="modal fade" id="checkRequestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
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
        <div class="row mt-3" id="requestsTable">
            <table class="table table-borderless table-light">
                <thead>
                    <tr class='table-dark'>
                        <th>Request ID</th>
                        <th colspan='2'>Client Full Name</th>
                        <th colspan='2'>Requested Service</th>
                        <th colspan='2'>Request Date</th>
                        <th>Request Status</th>
                        <th colspan='2'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                                <td>{$RequestId_fld}</td>
                                <td colspan='2'>{$UserFirstName_fld} {$UserLastName_fld}</td>
                                <td colspan='2'>{$ServiceName_fld}</td>
                                <td colspan='2'>{$RequestDate_fld}</td>
                                <td>{$RequestStatus_fld}</td>
                                <td colspan='2'>";
                                if ($RequestStatus_fld =='Finished' || $RequestStatus_fld =='Declined' || $RequestStatus_fld =='Cancelled' ){
                                    echo "<button type='button' title='View Request' class='btn btn-outline-success checkButton' requestIdCheck='$RequestId_fld'><i class='fas fa-eye'></i></button>
                                    <button type='button' title='Delete Request' class='btn btn-outline-danger deleteButton' requestIdDelete='$RequestId_fld'><i class='fas fa-trash-alt'></i></button>";  
                                }else{
                                    echo "<button type='button' title='View Request' class='btn btn-outline-success checkButton' requestIdCheck='$RequestId_fld'><i class='fas fa-eye'></i></button>";
                                }
                                    
                                echo "</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $page_url = "requestMain.php?";
            $total_rows = $request_obj->countRequest();
            
            // actual paging buttons
            include 'paging.php';
            ?>
        </div>
    </div>
<?php
}
?>

<?php
// tell the user there are no selfies
if ($num = 0) {
    echo "<div class='alert alert-danger'>
                <strong>No users found.</strong>
            </div></div>
            </div>";
}
?>

<script src="../scripts/requests.js"></script>

<?php
include "footer.php";
?>