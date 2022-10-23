<?php

class pdoDBGateway extends Database{
    
    public function pdoDBGateway(){
        parent::__construct(DBHost, DBName, DBUsername, DBPassword);
    }
}
