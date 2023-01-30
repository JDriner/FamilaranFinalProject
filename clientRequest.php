<?php
// core configuration
include_once "config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once 'config/database.php';
include_once 'classes/request.php';
include_once 'classes/user.php';
include_once 'classes/service.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$request_obj = new Requests($db_lv);
$request_obj = new Service($db_lv);

$stmt = $request_obj->servicesArray();
//$num = $stmt->rowCount();
$arrayServices=[];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
        $arrayServices[$ServiceId_fld]= $ServiceName_fld;

    };
    
$page_title = "Client | Request a service";

include "header.php";

$page_url = "clientRequest.php?";

?>

<div class="col-12">
    <div class="jumbotron">
        <form method="POST" id="addRequestForm">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex flex-row align-items-center back">
                    <h3><i class="fa fa-paper-plane"></i> Request a Service</h3>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <label>Service</label>
                    <input class="form-control" type="hidden" name="UserId_ht" value='<?php echo $_SESSION['userId']?>'>
                    <select class="form-control"  name="ServiceId_ht">
                        <option selected>-Select Service-</option>
                        <?php
                            foreach($arrayServices as $x => $x_value){
                                echo '<option value="'.$x.'">' .$x_value. '</option>';
                        }
                        ?>
                    </select>
                    <label>Date</label>
                    <input class="form-control" type="date" name="RequestDate_ht">
                    <label>Address</label>
                    <input class="form-control" type="text" name="UserAddress_ht">
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1">Tell us something about your request!</label>
                    <textarea class="form-control" name="RequestDescription_ht" rows="7"></textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type='submit' class='btn btn-danger float-right'>SUBMIT REQUEST</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script src="scripts/requests.js"></script>
<?php
include "footer.php";
?>