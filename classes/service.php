<?php

class Service
{

    //objects
    public $ServiceId_cv;
    public $ServiceCode_cv;
    public $ServiceName_cv;
    public $ServiceDescription_cv;
    public $ServicePrice_cv;
    public $ServiceStatus_cv;
    public $SearchItem_cv;
    public $arrayServices;
    private $conn_cv;

    //constructor
    public function __construct($db_lv) {
        $this->conn_cv = $db_lv;
    }

    //CRUD
    public function viewAllService() {
        $sql = "SELECT * FROM services_tbl"; //query
        //connect to the database
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->execute(); //executing the code

        return $stmt; //returns the result of the query 
        //database to UI - needs return statement(SELECT)
        //UI to database - no need to return(INSERT,UPDATE, DELETE)
    }

    public function addService() {
        $sql = "INSERT INTO services_tbl SET ServiceCode_fld=? , ServiceName_fld=? , ServiceDescription_fld=? , ServicePrice_fld=? , ServiceStatus_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->ServiceCode_cv);
        $stmt->bindparam(2, $this->ServiceName_cv);
        $stmt->bindparam(3, $this->ServiceDescription_cv);
        $stmt->bindparam(4, $this->ServicePrice_cv);
        $stmt->bindparam(5, $this->ServiceStatus_cv);

        $stmt->execute();
    }

    public function deleteService() {
        $sql = "DELETE FROM services_tbl WHERE ServiceId_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->ServiceId_cv);
        $stmt->execute();
    }

    public function viewOneService() {
        $sql = "SELECT * FROM services_tbl WHERE serviceId_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->ServiceId_cv);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->ServiceId_cv = $row['ServiceId_fld'];
        $this->ServiceCode_cv = $row['ServiceCode_fld'];
        $this->ServiceName_cv = $row['ServiceName_fld'];
        $this->ServiceDescription_cv = $row['ServiceDescription_fld'];
        $this->ServicePrice_cv = $row['ServicePrice_fld'];
        $this->ServiceStatus_cv = $row['ServiceStatus_fld'];
    }

    public function updateSelectedService() {

        $sql = "UPDATE services_tbl SET ServiceCode_fld=? , ServiceName_fld=? , ServiceDescription_fld=? , ServicePrice_fld=? , ServiceStatus_fld=? WHERE ServiceId_fld=?";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->ServiceCode_cv);
        $stmt->bindparam(2, $this->ServiceName_cv);
        $stmt->bindparam(3, $this->ServiceDescription_cv);
        $stmt->bindparam(4, $this->ServicePrice_cv);
        $stmt->bindparam(5, $this->ServiceStatus_cv);
        $stmt->bindparam(6, $this->ServiceId_cv);
        $stmt->execute();
    }
    // read all service records
    function readAll($from_record_num, $records_per_page) {

        // query to read all service records, with limit clause for pagination
        $query = "SELECT * FROM services_tbl ORDER BY ServiceId_fld LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);

        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values
        return $stmt;
    }

    // used for paging services
    public function countService() {

        // query to select all service records
        $query = "SELECT ServiceId_fld FROM services_tbl";

        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);

        // execute query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

    public function searchService($from_record_num, $records_per_page) {
        $sql = "SELECT * FROM services_tbl WHERE ServiceName_fld LIKE CONCAT ('%', ?, '%') OR ServiceDescription_fld LIKE CONCAT ('%', ?, '%') OR ServicePrice_fld LIKE CONCAT ('%', ?, '%')
        LIMIT ?, ?";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->SearchItem_cv);
        $stmt->bindparam(2, $this->SearchItem_cv);
        $stmt->bindparam(3, $this->SearchItem_cv);
        $stmt->bindParam(4, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(5, $records_per_page, PDO::PARAM_INT);
        $stmt->execute(); //executing the code

        return $stmt;
    }

    public function countSearchService() {
        $sql = "SELECT * FROM services_tbl WHERE ServiceName_fld LIKE CONCAT ('%', ?, '%') OR ServiceDescription_fld LIKE CONCAT ('%', ?, '%') OR ServicePrice_fld LIKE CONCAT ('%', ?, '%')";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->SearchItem_cv);
        $stmt->bindparam(2, $this->SearchItem_cv);
        $stmt->bindparam(3, $this->SearchItem_cv);
        $stmt->execute(); //executing the code

        // execute query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

    public function servicesArray() {

        //your sql statement here
          $sql=  "SELECT DISTINCT ServiceName_fld, ServiceId_fld FROM services_tbl WHERE ServiceStatus_fld='Available'";
          $stmt = $this->conn_cv->prepare($sql);
          $stmt->execute(); //executing the code
  
          return $stmt;

}
}
