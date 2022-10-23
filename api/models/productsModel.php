<?php

class productsModel{
    
    private $dbGateway;
    
    public function productsModel(){
        $this->dbGateway = new pdoDBGateway();
    }
    
    public function listProductsByTypeId($productTypeId){
        $query = "SELECT t.name AS productTypeName, p.name AS productName, p.id AS id
            FROM product_types t
            JOIN products p ON t.id = p.id_product_types
            WHERE t.id = {$productTypeId};";
        $products = $this->dbGateway->query($query);
        
        return $products;
    }

    public function getProductById($productId)
    {
        $query = "SELECT name, id, price_of_sale FROM products WHERE id = {$productId} LIMIT 1";
        $products = $this->dbGateway->query($query);

        if(count($products) == 0 ){
            return [];
        } else {
            return $products[0];
        }
    }
        
}
