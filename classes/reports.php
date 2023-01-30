<?php
include_once('../fpdf/fpdf.php');
class PDF extends FPDF {


    public $ServiceId_cv;
    public $ReportDate_cv;
    public $ServiceName_cv;
    

    // Page header
    function header(){
        // Logo
        $this->Image('../assets/images/logo.png',10,5,35);
        $this->SetFont('Courier','B',18);
        // // Move to the right
        $this->Cell(40);
        // // Title
        $this->Cell(140,10, $this->ServiceName_cv.' Report for '.$this->ReportDate_cv ,0,0,'C');
        $this->Ln(20);
        // // Line break
        $this->SetFont('Courier','B',15);
        $this->Cell(15,12,"ID", 1, 0, 'C');
        $this->Cell(45,12,"Name", 1, 0, 'C');
        $this->Cell(60,12,"Service", 1, 0, 'C');
        $this->Cell(30,12,"Date", 1, 0, 'C');
        $this->Cell(30,12,"Status", 1, 0, 'C');
        $this->Ln(13);
    }
 
    function viewTable($db_lv, $reportService, $reportDate){
        $this->SetFont('Courier','B',12);
        //Finished
        $stmt = $db_lv->query("SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
                    INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld 
                    INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld WHERE requests_tbl.ServiceId_fld=$reportService AND RequestDate_fld LIKE CONCAT ('$reportDate', '%') ORDER BY RequestId_fld DESC, RequestStatus_fld ASC");
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $this->Cell(15,12,$RequestId_fld, 1, 0, 'C');
            $this->Cell(45,12,$UserFirstName_fld." ".$UserLastName_fld,1);
            $this->Cell(60,12,$ServiceName_fld, 1, 0, 'C');
            $this->Cell(30,12,$RequestDate_fld,1);
            $this->Cell(30,12,$RequestStatus_fld, 1, 0, 'C');
            $this->Ln();
        }
        $this->Ln(10);
        $this->countReport($db_lv, $reportService, $reportDate, 'Finished', 'Finished Services:');
        $this->countReport($db_lv, $reportService, $reportDate, 'Cancelled', 'Cancelled Services:');
        $this->countReport($db_lv, $reportService, $reportDate, 'Pending', 'Pending Services:');
        $this->countReport($db_lv, $reportService, $reportDate, 'In Progress', 'Ongoing Services:');
        $this->countAllReport($db_lv, $reportService, $reportDate);
        //$this->countReport($db_lv, $reportService, $reportDate);
        //$this->countReport($db_lv, $reportService, $reportDate);
    }

    function countReport($db_lv, $reportService, $reportDate, $Status, $Label){
        $this->SetFont('Courier','B',13);
        $stmt = $db_lv->query("SELECT COUNT(RequestId_fld) AS ReportCount FROM requests_tbl WHERE ServiceId_fld=$reportService AND RequestDate_fld LIKE CONCAT ('$reportDate', '%') AND RequestStatus_fld LIKE '$Status'");
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $this->Cell(80);
            $this->Cell(70,12,$Label,1,0, 'R');
            $this->Cell(30,12,$ReportCount, 1, 0, 'C');
            $this->Ln();
        }
    }
    function countAllReport($db_lv, $reportService, $reportDate){
        $this->SetFont('Courier','B',16);
        $stmt = $db_lv->query("SELECT COUNT(RequestId_fld) AS ReportCount FROM requests_tbl WHERE ServiceId_fld=$reportService AND RequestDate_fld LIKE CONCAT ('$reportDate', '%')");
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $this->Cell(80);
            $this->Cell(70,12,"Total Services: ",1,0, 'R');
            $this->Cell(30,12,$ReportCount, 1, 0, 'C');
            $this->Ln();
        }
    }

    // Page footer
    function footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Courier italic 8
        $this->SetFont('Courier','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

    }
}


class Report{
    //objects
    public $ServiceId_cv;
    public $ReportDate_cv;
    public $ServiceName_cv;

    
    private $conn_cv;

    public function __construct($db_lv)
    {
        $this->conn_cv = $db_lv;
    }

    function title(){
        $sql = "SELECT * FROM services_tbl WHERE ServiceId_fld=?";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->ServiceId_cv);
        $stmt->execute(); //executing the code

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->ServiceName_cv = $row['ServiceName_fld'];
    }
    function generateReport($from_record_num, $records_per_page){

        // query to read all user records, with limit clause for pagination
        //$query = "SELECT * FROM requests_tbl ORDER BY RequestId_fld LIMIT ?, ?";
        $query = "SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
                    INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld 
                    INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld WHERE requests_tbl.ServiceId_fld=? AND RequestDate_fld LIKE CONCAT (?, '%')";
        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);
        $stmt->bindparam(1, $this->ServiceId_cv);
        $stmt->bindparam(2, $this->ReportDate_cv);


        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

        function countStatus($Status){
            $query = "SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
            INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld 
            INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld WHERE requests_tbl.ServiceId_fld=? AND RequestDate_fld LIKE CONCAT (?, '%') AND RequestStatus_fld='$Status'";
            // prepare query statement
            $stmt = $this->conn_cv->prepare($query);
            $stmt->bindparam(1, $this->ServiceId_cv);
            $stmt->bindparam(2, $this->ReportDate_cv);


            // execute query
            $stmt->execute();
            $num = $stmt->rowCount();

            // return values
            return $num;
    }

    function countReport(){
        $query = "SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
                    INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld 
                    INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld WHERE requests_tbl.ServiceId_fld=? AND RequestDate_fld LIKE CONCAT (?, '%')";
        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);
        $stmt->bindparam(1, $this->ServiceId_cv);
        $stmt->bindparam(2, $this->ReportDate_cv);


        // execute query
        $stmt->execute();
        $num = $stmt->rowCount();

        // return values
        return $num;
    }

    function reportData(){
        $query = "SELECT ServiceName_fld, COUNT(ServiceName_fld) AS ServiceCount_fld FROM requests_tbl INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld GROUP BY ServiceName_fld";
        $stmt = $this->conn_cv->prepare($query);
  
        // execute query
        $stmt->execute();

        // return values
        return $stmt;

    }
}

?>