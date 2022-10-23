<?php

class Database{
    protected $db;
    public $lastInsertedId;
    
    
    public function __construct($dbHost, $dbName, $dbUser,$dpPass){
        $this->db = new PDO("mysql:host=".$dbHost.";dbname=".$dbName.";charset=utf8", $dbUser, $dpPass);
    }

    public function query( $sql ){
        $resultTable = array();
        
        try{
            $table = $this->db->query($sql, PDO::FETCH_ASSOC) ;
            foreach ($table as $key => $row) {
                $resultTable[] = $row;
            }
        } catch (PDOException $ex){
            error_log("PDO ERROR: querying database: " . $ex->getMessage()."\n".$sql);
            return $resultTable;
        }
        
        return $resultTable;
    }
    
    public function order( $sql){
        try{
            $this->db->query($sql);
        } catch (PDOException $ex) {
            error_log("PDO ERROR: querying database: " . $ex->getMessage()."\n".$sql);
        }
    }
    
    public function lastInsertedId(){
        return $this->db->lastInsertId('id');
    }
}
