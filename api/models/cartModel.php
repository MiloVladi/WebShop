<?php

class cartModel
{

    private $articleList;
    private $session;

    public function __construct()
    {
        $this->session = new Session();

        if($this->session->exists("cart")) {
            $this->articleList = $this->session->read("cart");
        } else {
            $this->articleList = [];
            $this->updateSession();
        }
    }

    public function add($articleName, $articleId, $articlePrice)
    {
        if( ! isset($this->articleList[$articleId])) {
            $cartItem = [
                'name' => $articleName,
                'id' => $articleId,
                'price' => $articlePrice,
                'amount' => 1
            ];

            $this->articleList[$articleId] = $cartItem;
        } else {
            $this->articleList[$articleId]['amount'] ++;
        }

        $this->updateSession();
    }

    public function remove($articleId)
    {
        if(isset($this->articleList[$articleId])) {
            $this->articleList[$articleId]['amount'] --;
        } else {
            //todo: log error message
            return false;
        }

        $this->tryToClearFromList($articleId);
        $this->updateSession();

        return true;
    }

    private function tryToClearFromList($articleId) {

        if($this->articleList[$articleId]['amount'] <= 0) {

            unset($this->articleList[$articleId]);
        }
    }

    public function listCart()
    {
        return $this->articleList;
    }

    private function updateSession()
    {
        $this->session->write("cart", $this->articleList);
    }
}