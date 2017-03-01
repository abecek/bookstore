<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cart
 *
 * @author Michal
 */
class Cart{
    protected $products = array();
    protected $price_overall = 0;

    
    public function addItem($id, $quantity, $price) {
        if (isset($this->products[$id])){
            $this->updateItem($id, $quantity);
        } 
        else {
            $this->products[$id] = array('id' => $id, 'quantity' => $quantity, 'price' => $price);
            $this->price_overall += $quantity * $price;
        }
        
    }
    
    
    
    public function updateItem($id, $quantity) {
        if ($quantity === 0) {
            //$this->price_overall -= $this->products[$id]['price'];
            $this->deleteItem($id);
        } 
        elseif ( ($quantity > 0) && ($quantity != $this->products[$id]['quantity'])) {
            $this->products[$id]['quantity'] = $quantity;
           // $this->products[$id]['price'] = $price;
        }
    }
    
    public function deleteItem($id) {
           if (isset($this->products[$id])) {
                echo json_encode($this->products[$id]);
                   if($this->price_overall < 0){
                       $this->price_overall = 0;
                    }
                    else{
                       $this->price_overall -= ($this->products[$id]['price'] * $this->products[$id]['quantity']);
                    }
                unset($this->products[$id]);
           }
    }
    
    public function setQuantity($id, $val){
        $stara = $this->products[$id]['quantity'] * $this->products[$id]['price'];
        $this->price_overall -= $stara;
        $this->products[$id]['quantity'] = $val;
        $this->price_overall += $this->products[$id]['quantity'] * $this->products[$id]['price'];
    }
    
    public function getItemsFromCart(){
        return $this->products;
    }
    
    public function clearCart(){
        $this->products = null;
        $this->price_overall = 0;
    }
    
    public function getPrice(){
        return $this->price_overall;            
    }
    
    public function isEmpty() {
        return (empty($this->products));
    }
    
    public function count() {
        return count($this->products);
    }
}
