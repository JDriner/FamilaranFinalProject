<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../classes/reports.php';
include_once '../classes/service.php';
include_once '../classes/request.php';


$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

// $report_obj = new Report($db_lv);
$service_obj = new Service($db_lv);
$request_obj = new Requests($db_lv);

$stmt = $service_obj->servicesArray();
$num = $stmt->rowCount();

$arrayServices = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $arrayServices[$ServiceId_fld] = $ServiceName_fld;
};
$arrayCondition = array("<" => "Below", ">" => "Above", "=" => "Equal to");


$page_title = "Admin | Tabular Report";

include "header.php";

$page_url = "reportTabular.php?";

$stmt = $request_obj->readAll($from_record_num, $records_per_page);

// count retrieved services
$num = $stmt->rowCount();

?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

<div class="container" style="padding-top:50px">

    <h3>Generate a monthly Report for a specific Service.</h3>
    <form class="form-inline" method="POST" id="generateReportForm">
        <div class="form-group">
            <select class="form-control" name="ServiceId_ht">
                <option value="" selected>-Select Service-</option>
                <?php
                foreach ($arrayServices as $x => $x_value) {
                    echo '<option value="' . $x . '">' . $x_value . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" placeholder="-Select Month and Year-" class="form-control" name="ReportDate_ht" id="datepicker">
        </div>
        <button type="submit" name="generate_pdf" class="btn btn-primary">
        <i class='fas fa-print'></i> View Report</button>
    </form>

</div>

<?php
if ($num > 0) {
?>
    <div class="container-fluid">
        <div class="row mt-3" id="reportTable">
            
        </div>
    </div>
<?php

}

// tell the user there are no selfies
if ($num = 0) {
    echo "<div class='alert alert-danger'>
                <strong>No users found.</strong>
            </div></div>
            </div>";
}
?>


<script src="../scripts/report.js"></script>

<?
include "footer.php";
?>