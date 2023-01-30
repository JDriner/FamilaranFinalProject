
<?php
// core configuration
include_once "config/core.php";
// include classes
include_once 'config/database.php';
include_once 'classes/service.php';

$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); //access the getConnection function from the database class to test for connection if it fails or succeeds

$service_obj = new Service($db_lv);

$page_title = "Client | Index";

include "header.php";

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if login was successful
if ($action == 'login_success') {

    echo "<div class='alert alert-info'>";
    echo "<strong>Hi " . $_SESSION['userFirstName'] . ", welcome back!</strong>";
    echo "</div>";
}

// read all services from the database
$stmt = $service_obj->readAll($from_record_num, $records_per_page);

// count retrieved services
$num = $stmt->rowCount();

?>
<!-- Button trigger modal -->
<div class="row">
    <div class="col">
        <form method="POST" id="searchServiceForm" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-1" type="text" name="Search_ht" placeholder="Search">
            <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>
<!--TABLE-->
<?php
if ($num > 0) {
?>
    <div class="container-fluid">
        <div class="row mt-3" id="serviceTable">
            <table class="table table-borderless table-light">
                <thead>
                    <tr class='table-dark'>
                        <th>Service ID</th>
                        <th>Code</th>
                        <th colspan="2">Name</th>
                        <th colspan="3">Description</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                                <td>{$ServiceId_fld}</td>
                                <td>{$ServiceCode_fld}</td>
                                <td colspan='2'>{$ServiceName_fld}</td>
                                <td colspan='3'>{$ServiceDescription_fld}</td>
                                <td>₱{$ServicePrice_fld}.00</td>
                                <td>{$ServiceStatus_fld}</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $page_url = "index.php?";
            $total_rows = $service_obj->countService();
            // actual paging buttons
            include 'admin/paging.php';
            ?>

        </div>
    </div>
<?php

}
// tell the service there are no selfies
if ($num == 0) {
    echo "<div class='alert alert-danger'>
                <strong>No services found.</strong>
            </div></div>
            </div>";
}
?>

<!--SCRIPT-->
<script src="scripts/service.js"></script>

<?

include "footer.php";
?>