<?php
    include_once "../config/core.php";
    include "../config/database.php";
    include "../classes/service.php";


    $database_obj = new Database();
    $db_lv = $database_obj->getConnection();

    $service_obj = new Service($db_lv);

if ($_POST) {
    $service_obj->ServiceId_cv = $_POST['serviceId_js'];
    $service_obj->deleteService();

    // read all services from the database
    $stmt = $service_obj->readAll($from_record_num, $records_per_page);

    // count retrieved services
    $num = $stmt->rowCount();

    include_once "serviceList.php";
}
?>
