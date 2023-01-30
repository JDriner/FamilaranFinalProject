<?php
// core configuration
include_once "../config/core.php";

// check if logged in as admin
include_once "login_checker.php";

// include classes
include_once '../config/database.php';
include_once '../classes/service.php';
include_once '../classes/reports.php';

$database_obj = new Database(); //instantiate an object of database class
$db_lv = $database_obj->getConnection(); 

$report_obj = new Report($db_lv);

$page_title = "Admin | Graphical Report";

include "header.php";

$page_url = "reportGraph.php?";

?>

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

<div class="container" style="padding-bottom:50px">

<h3>Generate a Graphical report for a service.</h3>
<form class="form-inline" method="POST" id="generateGraphForm">
	<div class="form-group">
		<input type="text" placeholder="-Select Month and Year-" class="form-control" name="ReportDate_ht" id="datepicker">
	</div>
	<button type="submit" name="generate_pdf" class="btn btn-primary">
	<i class='fas fa-print'></i> Generate Graph</button>
</form>

</div> -->

<?php
 
$dataPoints=array();
$stmt = $report_obj->reportData();
$result= $stmt->fetchAll(\PDO::FETCH_OBJ);
//$num = $stmt->rowCount();

foreach($result as $row){
	         array_push($dataPoints, array("label"=> $row->ServiceName_fld, "y"=> $row->ServiceCount_fld));
    }
	
	
?>

<div class="row" id="reportGraph">

<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Handy Homes most Requested Services"
	},
	subtitles: [{
		text: "2021"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>


</div>

 


<script src="../scripts/report.js"></script>
<?
include "footer.php";
?>