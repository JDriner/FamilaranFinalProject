<?php
    include_once "../config/core.php";
    include "../config/database.php";
    include "../classes/request.php";


    $database_obj = new Database();
    $db_lv = $database_obj->getConnection();

    if($_POST){
        $request_obj = new Requests($db_lv);
        $request_obj->RequestStatus_cv = $_POST['RequestStatus_ht'];
        $request_obj->RequestId_cv = $_POST['RequestId_ht'];
        $request_obj->updateSelectedRequest();
        // read all requests from the database
        $stmt = $request_obj->readAll($from_record_num, $records_per_page);


        // count retrieved requests
        $num = $stmt->rowCount();

    
        include "requestList.php";
        $page_url = "requestMain.php?";
}
