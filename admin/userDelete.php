<?php
    include_once "../config/core.php";
    include "../config/database.php";
    include "../classes/user.php";


    $database_obj = new Database();
    $db_lv = $database_obj->getConnection();

    $user_obj = new User($db_lv);

if ($_POST) {
    $user_obj->UserId_cv = $_POST['userId_js'];
    $user_obj->deleteUser();

    // read all users from the database
    $stmt = $user_obj->readAll($from_record_num, $records_per_page);

    // count retrieved users
    $num = $stmt->rowCount();
    include "userTable.php";
}
?>
