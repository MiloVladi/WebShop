<?php


class productTypesModel{
    private $dbGateway;
    
    public function productTypesModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function getProductTypes(){
        $query = "SELECT id, name FROM product_types ORDER BY name;";
        
        $productTypes = $this->dbGateway->query($query);
        return $productTypes;   
    }
    
}
