<?php
    include_once "config/core.php";
    include "config/database.php";
    include "classes/request.php";


    $database_obj = new Database();
    $db_lv = $database_obj->getConnection();

    $request_obj = new Requests($db_lv);

if ($_POST) {
    $request_obj->RequestId_cv = $_POST['requestId_js'];
    $request_obj->RequestStatus_cv = $_POST['requestStatus_js'];
    $request_obj->updateSelectedRequest();

    // read all requests from the database
    $request_obj->UserId_cv =  $_SESSION['userId'];
    $stmt = $request_obj->viewMyRequests();
    $num = $stmt->rowCount();
    $total_rows = $request_obj->countMyRequests();

    // count retrieved requests
    $num = $stmt->rowCount();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<div class='col-6'>
        <div class='card border-primary text-primary bg-light mb-3' style='max-width: 100rem;'>
            <div class='card-header'><span class='badge badge-success badge-pill'>Request ID # {$RequestId_fld}</span></div>
            <div class='card-body'>
                <h4 class='card-title'>{$ServiceName_fld} </h4>
                <h6 class='card-primary'><strong>Address:</strong> {$UserAddress_fld}</h6>
                <h6 class='card-primary'><strong>Expected Date of service:</strong> {$RequestDate_fld}</h6>
                <h6 class='card-primary'><strong>Amount to Pay:</strong>₱{$ServicePrice_fld}.00</h6>
                <h6 class='card-primary'><strong>Request Description:</strong>
                <textarea class='form-control' name='ServiceDescription_ht' rows='3' readonly=''>{$RequestDescription_fld}</textarea>
                </h6>   
                <h6 class='card-primary'><strong>Status:</strong> {$RequestStatus_fld}</h6>";
                if ($RequestStatus_fld!='In Progress' && $RequestStatus_fld!='Declined' && $RequestStatus_fld!='Cancelled'){
                    echo "<button type='button' title='Cancel Request' class='btn btn-outline-danger cancelRequestButton' requestIdCheck='$RequestId_fld' requestStatusId='Cancelled'>Cancel Request</button>";
                }if ($RequestStatus_fld=='In Progress'){
                    echo "<button type='button' title='Confirm that this service is completed' class='btn btn-outline-success finishServiceButton' requestIdCheck='$RequestId_fld' requestStatusId='Finished'>Service Completed</button>";
                }
                
            echo "</div>
        </div>
    </div>";
    }
}
?>
