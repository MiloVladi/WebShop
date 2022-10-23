<?php


class ShopController {
    
    private $jsonView;
    private $cart;
    
    public function ShopController(){
        $this->jsonView = new JsonView();
        $this->cart = new cartModel();
    }

    public function route(){
        $action = filter_input(INPUT_GET, "action",FILTER_SANITIZE_STRING);

        switch(strtolower($action))
        {
            case 'listtypes':
                $this->listProductTypes();
                break;
            case 'listproductsbytypeid':
                $typeId = filter_input(INPUT_GET, "typeId", FILTER_SANITIZE_NUMBER_INT);
                $this->listProductsByTypeId($typeId);
                break;
            case 'addarticle':
                $articleId = filter_input(INPUT_GET, "articleId", FILTER_SANITIZE_NUMBER_INT);
                $this->addProductToCart($articleId);
                break;
            case 'removearticle':
                $articleId = filter_input(INPUT_GET, "articleId", FILTER_SANITIZE_NUMBER_INT);
                $this->removeProductFromCart($articleId);
                break;
            case 'listcart':
                $this->listCart();
                break;
            case 'unset':
                unset($_SESSION['cart']);
                break;
            default:
                $this->jsonView->streamOutput(
                    [
                        "error" => "Interface not found.",
                        "possible parameters" => "action (listTypes, listProductsByTypeId), typeId"
                    ]);
                return false;
        }
    }
    
    private function listProductTypes(){
        $productsTypesModel = new productTypesModel();
        $types = $productsTypesModel->getProductTypes();
        
        $backUrl = APP_URL . "?action=listProductsByTypeId&typeId=";
        foreach($types as &$type){
            $type['url'] = $backUrl . $type['id'];
        }
        
        $this->jsonView->streamOutput($types);
    }
    
    private function listProductsByTypeId($typeId){
        $productsModel = new productsModel();
        $products = $productsModel->listProductsByTypeId($typeId);
        
        $backUrl = APP_URL . "?action=listTypes";
        foreach($products as &$product){
            $product['url'] = $backUrl;
        }
        
        $this->jsonView->streamOutput($products);
    }

    private function addProductToCart($articleId)
    {
        $productModel = new productsModel();
        $products = $productModel->getProductById($articleId);


        if($products != [] ) {

            $this->cart->add($products['name'], $products['id'], $products['price_of_sale']);
            $this->jsonView->streamOutput(['state'=>'OK']);
        } else {
            $this->jsonView->streamOutput(['state'=>'ERROR']);
        }

    }

    private function removeProductFromCart($articleId)
    {
        if(!$this->cart->remove($articleId)) {
            $this->jsonView->streamOutput(['state'=>'ERROR']);
        } else {
            $this->jsonView->streamOutput(['state'=>'OK']);
        }
    }

    private function listCart()
    {
        //todo: map product ids to product name
        $this->jsonView->streamOutput($this->cart->listCart());
    }

}
