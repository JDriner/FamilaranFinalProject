<?php
include_once "../config/core.php";
include "../config/database.php";
include "../classes/service.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();
$service_obj = new Service($db_lv);

if ($_POST) {
    $service_obj->SearchItem_cv = $_POST['Search_ht'];

    // read all services from the database
    $stmt = $service_obj->searchService($from_record_num, $records_per_page);

    // count retrieved services
    $num = $stmt->rowCount();
    $page_url = "serviceMain.php?";
    $total_rows = $service_obj->countSearchService();



    if ($num > 0) {
        echo "<div class='alert alert-success'>
                <strong>Found $total_rows result/s.</strong>
                </div></div>
                </div>";
                    echo "<table class='table table-borderless table-light'>
            <thead>
                <tr class='table-dark'>
                    <th>Service ID</th>
                    <th>Code</th>
                    <th colspan='2'>Name</th>
                    <th colspan='3'>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th colspan='2'>Actions</th>
                </tr>
            </thead>
            <tbody>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                        <td>{$ServiceId_fld}</td>
                        <td>{$ServiceCode_fld}</td>
                        <td colspan='2'>{$ServiceName_fld}</td>
                        <td colspan='3'>{$ServiceDescription_fld}</td>
                        <td>₱{$ServicePrice_fld}.00</td>
                        <td>{$ServiceStatus_fld}</td>
                        <td colspan='2'>
                            <button type='button' class='btn btn-outline-danger deleteButton' serviceIdDelete='$ServiceId_fld'><i class='fas fa-trash-alt'></i></button>

                            <button type='button' class='btn btn-outline-success updateButton' serviceIdUpdate='$ServiceId_fld'><i class='fas fa-pencil-alt'></i></button>
                        </td>
                    </tr>";
                    }

                    echo "</tbody>
            </table>";
        // actual paging buttons
        include 'paging.php';
    } else if ($num == 0) {
        echo "<div class='alert alert-danger'>
                <strong>No Results found.</strong>
            </div></div>
            </div>";
    }
}
?>

