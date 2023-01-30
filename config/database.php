<?php
class Database{
    
    //class variables
    private $host_cv = "localhost";
    private $dbName_cv = "familaranfinalproject_db"; //name of the database
    private $userName_cv = "root"; //default username
    private $password_cv = ""; //default password for mysql

    public $conn_cv;

    //get the database connection
    public function getConnection(){
        $this->conn_cv = null;
        try{
            $this->conn_cv = new PDO("mysql:host=".$this->host_cv . ";dbname=" . $this->dbName_cv, $this->userName_cv, $this->password_cv);//this is the connection string which is used to manipulate the database
            //echo "Database Connection Successful!";

        }catch(PDOException $exception_lv){
            //echo "Database Connection Failed.";
        }
        return $this->conn_cv;
    }
    
}
    


?>