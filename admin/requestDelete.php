<?php
    include_once "../config/core.php";
    include "../config/database.php";
    include "../classes/request.php";


    $database_obj = new Database();
    $db_lv = $database_obj->getConnection();

    $request_obj = new Requests($db_lv);

if ($_POST) {
    $request_obj->RequestId_cv = $_POST['requestId_js'];
    $request_obj->deleteRequest();

    // read all requests from the database
    $stmt = $request_obj->readAll($from_record_num, $records_per_page);

    // count retrieved requests
    $num = $stmt->rowCount();
    include "requestList.php";
}
?>
