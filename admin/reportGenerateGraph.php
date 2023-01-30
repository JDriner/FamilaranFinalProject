<?php
include_once "../config/core.php";
include "../config/database.php";
include "../classes/reports.php";


$database_obj = new Database();
$db_lv = $database_obj->getConnection();
if ($_POST) {
    $report_obj = new Report($db_lv);
    $report_obj->ReportDate_cv = $_POST['ReportDate_ht'];
    echo  $report_obj->ReportDate_cv;
    $dataPoints = array();
    $stmt = $report_obj->reportData();
    $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
    //$num = $stmt->rowCount();

    foreach ($result as $row) {
        array_push($dataPoints, array("label" => $row->ServiceName_fld, "y" => $row->ServiceCount_fld));
    }
    echo "HAYSTT";

?>
<div class="jumbotron jumbotron-fluid">
    <h1 class="display-4">Title</h1>
    <p class="lead">Subtitle</p>
    <hr class="my-4">
    <p>Content</p>
</div><!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer");

    chart.options.axisY = { prefix: "$", suffix: "K" };
    chart.options.title = { text: "Fruits sold in First & Second Quarter" };

    var series1 = { //dataSeries - first quarter
        type: "column",
        name: "First Quarter",
        showInLegend: true
    };

    var series2 = { //dataSeries - second quarter
        type: "column",
        name: "Second Quarter",
        showInLegend: true
    };

    chart.options.data = [];
    chart.options.data.push(series1);
    chart.options.data.push(series2);


    series1.dataPoints = [
            { label: "banana", y: 58 },
            { label: "orange", y: 69 },
            { label: "apple", y: 80 },
            { label: "mango", y: 74 },
            { label: "grape", y: 64 }
    ];

    series2.dataPoints = [
        { label: "banana", y: 63 },
        { label: "orange", y: 73 },
        { label: "apple", y: 88 },
        { label: "mango", y: 77 },
        { label: "grape", y: 60 }
    ];

    chart.render();
}
</script>
<?php
}

?>

<script src="../scripts/report.js"></script>