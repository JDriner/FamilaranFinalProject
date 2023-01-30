<?php
include_once "config/core.php";
include "config/database.php";
include "classes/request.php";



$database_obj = new Database();
$db_lv = $database_obj->getConnection();


if ($_POST) {
    $request_obj = new Requests($db_lv);
    //passed the value of the html elements to the class variables using the object
    $request_obj->UserId_cv = $_POST['UserId_ht'];
    $request_obj->ServiceId_cv = $_POST['ServiceId_ht'];
    $request_obj->RequestDate_cv = $_POST['RequestDate_ht'];
    $request_obj->RequestDescription_cv = $_POST['RequestDescription_ht'];
    $request_obj->UserAddress_cv = $_POST['UserAddress_ht'];
    // called the method to be executed
    $request_obj->addRequest();
}
?>
