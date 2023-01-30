<?php
include_once "../config/core.php";
include "../config/database.php";
include "../classes/service.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();

if ($_POST) {
    $service_obj = new Service($db_lv);
    //passed the value of the html elements to the class variables using the object
    $service_obj->ServiceCode_cv = $_POST['ServiceCode_ht'];
    $service_obj->ServiceName_cv = $_POST['ServiceName_ht'];
    $service_obj->ServiceDescription_cv = $_POST['ServiceDescription_ht'];
    $service_obj->ServicePrice_cv = $_POST['ServicePrice_ht'];
    $service_obj->ServiceStatus_cv = $_POST['ServiceStatus_ht'];
    //$service_obj->Status_cv = $_POST['Status_ht'];<-----to be continued
    // called the method to be executed
    $service_obj->addService();

    // read all services from the database
    $stmt = $service_obj->readAll($from_record_num, $records_per_page);

    // count retrieved services
    $num = $stmt->rowCount();

    include "serviceList.php";
}
?>
