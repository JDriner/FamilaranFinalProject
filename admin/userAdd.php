<?php
include_once "../config/core.php";
include "../config/database.php";
include "../classes/user.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();

if ($_POST) {
    $user_obj = new User($db_lv);
    //passed the value of the html elements to the class variables using the object
    $user_obj->UserFirstName_cv = $_POST['UserFirstName_ht'];
    $user_obj->UserLastName_cv = $_POST['UserLastName_ht'];
    $user_obj->Username_cv = $_POST['Username_ht'];
    $user_obj->UserPassword_cv = $_POST['UserPassword_ht'];
    $user_obj->AccessLevel_cv = $_POST['AccessLevel_ht'];
    //$user_obj->Status_cv = $_POST['Status_ht'];<-----to be continued
    // called the method to be executed
    $user_obj->addUser();

    // read all users from the database
    $stmt = $user_obj->readAll($from_record_num, $records_per_page);

    // count retrieved users
    $num = $stmt->rowCount();

    include "userTable.php";
    echo "<script src='../scripts/alert.js'></script>";
}
?>
