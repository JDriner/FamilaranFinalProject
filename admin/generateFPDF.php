
<?php
//include connection file 
include_once("../config/database.php");
include_once("../config/core.php");
include_once("../classes/request.php");
include_once("../classes/reports.php");

$database_obj = new Database();
$db_lv = $database_obj->getConnection();

if($_POST){
    $pdf = new PDF();
    $report_obj = new Report($db_lv);
    $pdf->ServiceId_cv = $_POST['ServiceId_ht'];
    $report_obj->ServiceId_cv = $_POST['ServiceId_ht'];
    $pdf->ReportDate_cv = $_POST['ReportDate_ht'];
    $stmt = $report_obj->title();
    $ServiceName = $report_obj->ServiceName_cv;

    $pdf->ServiceName_cv = $ServiceName;
    $reportService = $_POST['ServiceId_ht'];
    $reportDate = $_POST['ReportDate_ht'];

    //header
    

    $pdf->AddPage('P', 'A4', 0);
    //footer page
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','B',12);
    $pdf->viewTable($db_lv, $reportService, $reportDate);
    //$pdf->countReport($db_lv, $reportService, $reportDate);
    $pdf->Output();
   


}
 


?>