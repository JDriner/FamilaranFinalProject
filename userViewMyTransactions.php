<?php
// core configuration
include_once "config/core.php";

// include login checker
$require_login = true;
include_once "login_checker.php";


// include classes
include_once 'config/database.php';
include_once 'classes/request.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$request_obj = new Requests($db_lv);


$page_title = "Client | My Transactions";
// include page header HTML
include_once 'header.php';
$page_url = "userViewMyTransactions.php?";

// count retrieved requests
$request_obj->UserId_cv =  $_SESSION['userId'];
$stmt = $request_obj->viewMyTransactions();
$num = $stmt->rowCount();
$total_rows = $request_obj->countMyTransactions();


?>
<?php
    if($num>0){
?>
<div class="alert alert-dismissible alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    You have <?php echo $total_rows ?> finished Transaction/s.
</div>

<div class="row" id="clientTransactions">
    <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            echo "<div class='col-6'>
            <div class='card border-primary text-primary bg-light mb-3' style='max-width: 100rem;'>
                <div class='card-header'><span class='badge badge-success badge-pill'>Request ID # {$RequestId_fld}</span></div>
                <div class='card-body'>
                    <h4 class='card-title'>{$ServiceName_fld} </h4>
                    <h6 class='card-primary'><strong>Address:</strong> {$UserAddress_fld}</h6>
                    <h6 class='card-primary'><strong>Expected Date of service:</strong> {$RequestDate_fld}</h6>
                    <h6 class='card-primary'><strong>Service Price:</strong>₱{$ServicePrice_fld}.00</h6>
                    <h6 class='card-primary'><strong>Request Description:</strong>
                    <textarea class='form-control' name='ServiceDescription_ht' rows='3' readonly=''>{$RequestDescription_fld}</textarea>
                    </h6>   
                    <h6 class='card-primary'><strong>Status:</strong> {$RequestStatus_fld}</h6>";                 
                echo "</div>
            </div>
        </div>";
        }
    }else{
        echo "<div class='alert alert-dismissible alert-danger'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        You do not have any finished transactions yet!
    </div>";
    }
    ?>
</div>
<script src="scripts/requests.js"></script>
<?php
// footer HTML and JavaScript codes
include 'footer.php';
?>
