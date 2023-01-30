<?php
include_once "../config/core.php";
include "../config/database.php";
include "../classes/reports.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();

if ($_POST) {
    $report_obj = new Report($db_lv);
    $report_obj->ServiceId_cv = $_POST['ServiceId_ht'];
    $report_obj->ReportDate_cv = $_POST['ReportDate_ht'];
    $stmt = $report_obj->generateReport($from_record_num, $records_per_page);
    // read all reports from the database

    // count retrieved reports
    $num = $stmt->rowCount();
    $page_url = "reportTabular.php?";
    $total_rows = $report_obj->countReport();

?>
    <form class="form-inline" method="post" action="generateFPDF.php">
        <div class="form-group">
            <input class="form-control" type="hidden" name="ServiceId_ht" value="<?php echo $_POST['ServiceId_ht'] ?>">
            <input class="form-control" type="hidden" name="ReportDate_ht" value="<?php echo $_POST['ReportDate_ht'] ?>">
        </div>
        <button type="submit" id="pdf" name="generate_pdf" class="btn btn-danger">
            <i class='fas fa-file-alt'></i> Generate PDF Report</button>
    </form>
    <div class='alert alert-success'>
        <strong>Found <?php echo $total_rows ?> result/s.</strong>
    </div>

<?php
    echo "<table class='table table-borderless table-light'>
                <thead>
                    <tr class='table-dark'>
                        <th>Request ID</th>
                        <th>Client Full Name</th>
                        <th>Requested Service</th>
                        <th>Request Date</th>
                        <th>Request Status</th>
                    </tr>
                </thead>
                </thead>
                <tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>
                                <td>{$RequestId_fld}</td>
                                <td>{$UserFirstName_fld} {$UserLastName_fld}</td>
                                <td>{$ServiceName_fld}</td>
                                <td{$ServiceName_fld}</td>
                                <td>{$RequestDate_fld}</td>
                                <td>{$RequestStatus_fld}</td>
                            </tr>";
    }

    echo "<tr><td colspan='3'></td><td>Finished Services: </td><td>";
    echo $report_obj->countStatus('Finished');
    echo "</td></tr>";
    echo "<tr><td colspan='3'></td><td>Cancelled Services: </td><td>";
    echo $report_obj->countStatus('Cancelled');
    echo "</td></tr>";
    echo "<tr><td colspan='3'></td><td>Pending Services: </td><td>";
    echo $report_obj->countStatus('Pending');
    echo "</td></tr>";
    echo "<tr><td colspan='3'></td><td>Ongoing Services: </td><td>";
    echo $report_obj->countStatus('In Progress');
    echo "</td></tr>";
    echo "<tr><td colspan='3'></td><td>Total Services: </td><td>";
    echo $report_obj->countReport();
    echo "</td></tr>";


    echo "</tbody>
            </table>";


    if ($num == 0) {
        echo "<div class='alert alert-danger'>
                            <strong>No Records Found in this month/year given.</strong>
                        </div></div>
                        </div>";
    }
}

?>

<script src="../scripts/report.js"></script>