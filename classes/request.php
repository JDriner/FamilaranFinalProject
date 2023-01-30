<?php

class Requests{
    //objects
    public $RequestId_cv;
    public $UserId_cv;
    public $ServiceId_cv;
    public $RequestDate_cv;
    public $RequestDescription_cv;
    public $RequestStatus_cv;
    public $UserAddress_cv;
    private $conn_cv;

    //constructor
    public function __construct($db_lv)
    {
        $this->conn_cv = $db_lv;
    }

    //CRUD
    public function viewAllRequests()
    {
        $sql = "SELECT * FROM requests_tbl"; //query
        //connect to the database
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->execute(); //executing the code

        return $stmt; //returns the result of the query 
        //database to UI - needs return statement(SELECT)
        //UI to database - no need to return(INSERT,UPDATE, DELETE)
    }

    public function addRequest()
    {
        $sql = "INSERT INTO requests_tbl SET UserId_fld=? , ServiceId_fld=? , RequestDate_fld=? , RequestDescription_fld=?, UserAddress_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserId_cv);
        $stmt->bindparam(2, $this->ServiceId_cv);
        $stmt->bindparam(3, $this->RequestDate_cv);
        $stmt->bindparam(4, $this->RequestDescription_cv);
        $stmt->bindparam(5, $this->UserAddress_cv);

        $stmt->execute();
    }

    public function deleteRequest()
    {
        $sql = "DELETE FROM requests_tbl WHERE RequestId_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->RequestId_cv);
        $stmt->execute();
    }

    public function viewOneRequest()
    {
        //$sql = "SELECT RequestId_fld, UserId_fld FROM requests_tbl WHERE RequestId_fld=?";
        $sql = "SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld  WHERE RequestId_fld=?";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->RequestId_cv);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->RequestId_cv = $row['RequestId_fld'];
        $this->UserFirstName_cv = $row['UserFirstName_fld'];
        $this->UserLastName_cv = $row['UserLastName_fld'];
        $this->ServiceName_cv = $row['ServiceName_fld'];
        $this->RequestDate_cv = $row['RequestDate_fld'];
        $this->RequestDescription_cv = $row['RequestDescription_fld'];
        $this->RequestStatus_cv = $row['RequestStatus_fld'];
        $this->UserAddress_cv = $row['UserAddress_fld'];
    }

    public function updateSelectedRequest()
    {
        $sql = "UPDATE requests_tbl SET RequestStatus_fld=? WHERE RequestId_fld=?";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->RequestStatus_cv);
        $stmt->bindparam(2, $this->RequestId_cv);
        $stmt->execute();
    }

    // read all user records
    function readAll($from_record_num, $records_per_page)
    {
        // query to read all user records, with limit clause for pagination
        //$query = "SELECT * FROM requests_tbl ORDER BY RequestId_fld LIMIT ?, ?";
        $query = "SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, ServicePrice_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld ORDER BY RequestId_fld DESC
        LIMIT ?, ?";
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

    // used for paging users
    public function countRequest()
    {
        // query to select all user records
        $query = "SELECT RequestId_fld FROM requests_tbl";
        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);
        // execute query
        $stmt->execute();
        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }
    function viewMyRequests()
    {

        // $sql = "SELECT RequestId_fld, UserFirstName_fld, UserLastName_fld, ServiceName_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl INNER JOIN users_tbl ON requests_tbl.UserId_fld = users_tbl.UserId_fld INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld WHERE UserId_fld=?";
        $sql = "SELECT RequestId_fld, UserId_fld, ServiceName_fld, ServicePrice_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
        INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld
        WHERE UserId_fld=? AND (RequestStatus_fld!='Finished' AND RequestStatus_fld!='Cancelled' AND RequestStatus_fld!='Declined')";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserId_cv);
        $stmt->execute();

        return $stmt;
    }
    function countMyRequests(){
        $query = "SELECT * FROM requests_tbl 
        INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld
        WHERE UserId_fld=? AND RequestStatus_fld!='Finished' AND RequestStatus_fld!='Cancelled' ";
        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);
        $stmt->bindparam(1, $this->UserId_cv);
        // execute query
        $stmt->execute();
        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

    function viewMyTransactions(){

        $sql = "SELECT RequestId_fld, UserId_fld, ServiceName_fld, ServicePrice_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
        INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld
        WHERE UserId_fld=? AND RequestStatus_fld!='Pending' AND RequestStatus_fld!='In Progress' 
        ORDER BY RequestStatus_fld DESC";

        // $sql = "SELECT RequestId_fld, UserId_fld, ServiceName_fld, ServicePrice_fld, RequestDate_fld, RequestDescription_fld, RequestStatus_fld, UserAddress_fld FROM requests_tbl 
        // INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld
        // WHERE UserId_fld=? AND RequestStatus_fld='Finished' AND RequestStatus_fld='Cancelled'
        // ORDER BY RequestStatus_fld DESC";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserId_cv);
        $stmt->execute();

        return $stmt;
    }

    function countMyTransactions(){
        $query =  "SELECT * FROM requests_tbl 
        INNER JOIN services_tbl ON requests_tbl.ServiceId_fld = services_tbl.ServiceId_fld
        WHERE UserId_fld=? AND RequestStatus_fld!='Pending' AND RequestStatus_fld!='In Progress'";
        // prepare query statement
        $stmt = $this->conn_cv->prepare($query);
        $stmt->bindparam(1, $this->UserId_cv);
        // execute query
        $stmt->execute();
        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }
}
