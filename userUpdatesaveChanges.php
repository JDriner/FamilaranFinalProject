<?php
    include_once "config/core.php";
    include "config/database.php";
    include "classes/user.php";


    $database_obj = new Database();
    $db_lv = $database_obj->getConnection();

    if($_POST){
        $user_obj = new User($db_lv);
        $user_obj->UserFirstName_cv = $_POST['UserFirstName_ht'];
        $user_obj->UserLastName_cv = $_POST['UserLastName_ht'];
        $user_obj->Username_cv = $_POST['Username_ht'];
        $user_obj->UserPassword_cv = $_POST['UserPassword_ht'];
        $user_obj->AccessLevel_cv = $_POST['AccessLevel_ht'];
        $user_obj->UserId_cv = $_POST['UserId_ht'];
        $user_obj->updateSelectedUser();
        // read all users from the database
        $stmt = $user_obj->readAll($from_record_num, $records_per_page);

        // count retrieved users
        $num = $stmt->rowCount();
    
        $_SESSION['userFirstName'] = $user_obj->UserFirstName_cv;
        $_SESSION['userLastName'] = $user_obj->UserLastName_cv;
        $_SESSION['username'] = $user_obj->Username_cv;
        $_SESSION['password'] = $user_obj->UserPassword_cv;
        $_SESSION['accessLevel'] = $user_obj->AccessLevel_cv;
}
?>