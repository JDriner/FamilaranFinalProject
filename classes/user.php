<?php

class User
{
    // database connection and table name
    private $conn;
    private $table = "users_tbl";

    //objects
    public $UserId_cv;
    public $UserFirstName_cv;
    public $UserLastName_cv;
    public $Username_cv;
    public $UserPassword_cv;
    public $AccessLevel_cv;
    public $Status_cv;
    public $Modified_cv;
    public $SearchItem_cv;
    private $conn_cv;

    //constructor
    public function __construct($db_lv)
    {
        $this->conn_cv = $db_lv;
    }

    //LOGIN
    // check if given email exist in the database
    function usernameExists()
    {

        // query to check if email exists
        //$sql = "SELECT * FROM users_tbl WHERE userId_fld=?";
        $query = "SELECT * FROM users_tbl WHERE username_fld=? LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn_cv->prepare($query);

        // sanitize
        $this->Username_cv = htmlspecialchars(strip_tags($this->Username_cv));

        // bind given email value
        $stmt->bindParam(1, $this->Username_cv);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->UserId_cv = $row['UserId_fld'];
            $this->UserFirstName_cv = $row['UserFirstName_fld'];
            $this->UserLastName_cv = $row['UserLastName_fld'];
            $this->Username_cv = $row['Username_fld'];
            $this->UserPassword_cv = $row['UserPassword_fld'];
            $this->AccessLevel_cv = $row['AccessLevel_fld'];
            $this->Status_cv = $row['Status'];
            $this->Modified_cv = $row['Modified'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    //CRUD
    public function viewAllUser()
    {
        $sql = "SELECT * FROM users_tbl"; //query
        //connect to the database
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->execute(); //executing the code

        return $stmt; //returns the result of the query 
        //database to UI - needs return statement(SELECT)
        //UI to database - no need to return(INSERT,UPDATE, DELETE)
    }

    public function addUser()
    {
        $sql = "INSERT INTO users_tbl SET UserFirstName_fld=? , UserLastName_fld=? , Username_fld=? , UserPassword_fld=? , AccessLevel_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserFirstName_cv);
        $stmt->bindparam(2, $this->UserLastName_cv);
        $stmt->bindparam(3, $this->Username_cv);
        $stmt->bindparam(4, $this->UserPassword_cv);
        $stmt->bindparam(5, $this->AccessLevel_cv);

        $stmt->execute();
    }

    public function deleteUser()
    {
        $sql = "DELETE FROM users_tbl WHERE UserId_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserId_cv);
        $stmt->execute();
    }

    public function viewOneUser()
    {
        $sql = "SELECT * FROM users_tbl WHERE userId_fld=?";
        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserId_cv);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->UserId_cv = $row['UserId_fld'];
        $this->UserFirstName_cv = $row['UserFirstName_fld'];
        $this->UserLastName_cv = $row['UserLastName_fld'];
        $this->Username_cv = $row['Username_fld'];
        $this->UserPassword_cv = $row['UserPassword_fld'];
        $this->AccessLevel_cv = $row['AccessLevel_fld'];
    }

    public function updateSelectedUser()
    {
        $sql = "UPDATE users_tbl SET UserFirstName_fld=? , UserLastName_fld=? , Username_fld=? , UserPassword_fld=? , AccessLevel_fld=? WHERE UserId_fld=?";

        $stmt = $this->conn_cv->prepare($sql);
        $stmt->bindparam(1, $this->UserFirstName_cv);
        $stmt->bindparam(2, $this->UserLastName_cv);
        $stmt->bindparam(3, $this->Username_cv);
        $stmt->bindparam(4, $this->UserPassword_cv);
        $stmt->bindparam(5, $this->AccessLevel_cv);
        $stmt->bindparam(6, $this->UserId_cv);
        $stmt->execute();
    }
    // read all user records
function readAll($from_record_num, $records_per_page){
 
    // query to read all user records, with limit clause for pagination
    $query = "SELECT * FROM users_tbl ORDER BY UserId_fld LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn_cv->prepare( $query );
 
    // bind limit clause variables
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values
    return $stmt;
}
// used for paging users
public function countClients(){
 
    // query to select all user records
    $query = "SELECT UserId_fld FROM users_tbl";
 
    // prepare query statement
    $stmt = $this->conn_cv->prepare($query);
 
    // execute query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // return row count
    return $num;
}

public function searchUser($from_record_num, $records_per_page){
    $sql = "SELECT * FROM users_tbl WHERE UserId_fld LIKE CONCAT ('%', ?, '%') OR UserFirstName_fld LIKE CONCAT ('%', ?, '%') OR UserLastName_fld LIKE CONCAT ('%', ?, '%') OR AccessLevel_fld LIKE CONCAT ('%', ?, '%')
    LIMIT ?, ?";

    $stmt = $this->conn_cv->prepare($sql);
    $stmt->bindparam(1, $this->SearchItem_cv);
    $stmt->bindparam(2, $this->SearchItem_cv);
    $stmt->bindparam(3, $this->SearchItem_cv);
    $stmt->bindparam(4, $this->SearchItem_cv);
    $stmt->bindParam(5, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(6, $records_per_page, PDO::PARAM_INT);
    $stmt->execute(); //executing the code

    return $stmt;
}
}
