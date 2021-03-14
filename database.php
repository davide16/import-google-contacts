<?php
/*
Author:Sergio Allegra Garufi

Description: Il file contiene la classe usata per l'interazione con il database
*/


class Database{


    private $DB_host;
    private $DB_user;
    private $DB_password;
    private $DB_name;
    private $conn_db;

    public function getDB_host() {
        return $this->DB_host;
    }

    public function getDB_user() {
        return $this->DB_user;
    }

    public function getDB_password() {
        return $this->DB_password;
    }

    public function getDB_name() {
        return $this->DB_name;
    }

    public function getConn_db() {
        return $this->conn_db;
    }

    public function setDB_host($DB_host) {
        $this->DB_host = $DB_host;
    }

    public function setDB_user($DB_user) {
        $this->DB_user = $DB_user;
    }

    public function setDB_password($DB_password) {
        $this->DB_password = $DB_password;
    }

    public function setDB_name($DB_name) {
        $this->DB_name = $DB_name;
    }

    public function setConn_db($conn_db) {
        $this->conn_db = $conn_db;
    }

    function __construct()
    {
        
        $this->setDB_host("localhost");
        $this->setDB_user("root");
        $this->setDB_password("amala");
        $this->setDB_name("ProjectContact");
        
        /*
         $this->setDB_host("localhost");
       $this->setDB_user("ezaxckhn");
       $this->setDB_password("5w52q5sKwH");
       $this->setDB_name("ezaxckhn_skedulbeta");
         */
         
        $this->setConn_db($this->db_connect());	
    }
    
    public function __destruct() 
    {
        $this->setConn_db(null);
    }

    private function db_connect()
    {
        $conn = mysqli_connect($this->DB_host,$this->DB_user,$this->DB_password,$this->DB_name);
        if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_query($conn,"SET NAMES 'utf8'");
        return $conn;
    }

     function db_disconnect() {
        $conn = $this->getConn_db();       
	mysqli_close($conn);
    }
     public function insert($nome,$cognome,$email,$data)
 {
  $res = mysql_query("INSERT 'contatti'(nome,cognome,email,data) VALUES('$nome','$cognome','$email','$data')");
  return $res;
 }


}




?>