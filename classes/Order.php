<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author Michal
 */
class Order {
    protected $cart = null;
    protected $adress = array();
    protected $liczba_prod = 0;
    //put your code here
    public function __construct($pdo, $cart, $adress = null, $id = null) {
        $this->pdo = $pdo;
        $this->cart = $cart;
        $this->adress = $adress;

        
        if($id != null && is_numeric($id)){
            $zap = $this->pdo->prepare('SELECT * FROM zamowienia WHERE id=?');
            $zap->execute(array($id));
            $wynik = $zap->fetch(PDO::FETCH_ASSOC);
            print_r($wynik);
            
            $zap = $this->pdo->prepare('SELECT * FROM adres WHERE id=?');
            $zap->execute(array($_SESSION['user']));
            $wynik = $zap->fetch(PDO::FETCH_ASSOC);
             print_r($wynik);
        }
    }
    
    public function addNew(){
            $zap = $this->pdo->prepare('INSERT INTO statusy(nazwa) VALUES("W trakcie")');
            $zap->execute();
            
            $zap = $this->pdo->prepare('SELECT * FROM statusy ORDER BY id DESC LIMIT 1');
            $zap->execute();
            $wynik = $zap->fetch(PDO::FETCH_ASSOC);
            $this->id_statusu = $wynik['id'];
            
            $zap = $this->pdo->prepare('INSERT INTO zamowienia(id_klienta,id_statusu,data_zakupu,cena) VALUES(?,?,NOW(),?)');
            $zap->execute(array(
                $_SESSION['user'],
                $this->id_statusu,
                $_SESSION['cart']->getPrice(),
            ));
            
            $zap = $this->pdo->prepare('SELECT * FROM zamowienia ORDER BY id DESC LIMIT 1');
            $zap->execute();
            $wynik = $zap->fetch(PDO::FETCH_ASSOC);
            $this->id_zamowienia = $wynik['id'];
            

            $books = $_SESSION['cart']->getItemsFromCart();
            
            
            foreach($books as $book){      
                $this->liczba_prod += 1;
                
                $zap = $this->pdo->prepare('INSERT INTO ksiazki_w_zamowieniach (id_zamowienia, id_ksiazki, liczba_ksiazek, cena)VALUES(?,?,?,?)');
                $zap->execute(array(
                    $this->id_zamowienia,
                    $book['id'],
                    $book['quantity'],
                    $book['price']
                ));
            }
  
    }
    
    public function getId(){
        return $this->id_zamowienia;
    }
    public function getStatus(){
        $zap = $this->pdo->prepare('SELECT id_statusu FROM zamowienia WHERE id=?');
        $zap->execute(array($this->id_zamowienia));
        $wynik = $zap->fetch(PDO::FETCH_ASSOC);
        
        $zap2 = $this->pdo->prepare('SELECT nazwa FROM statusy WHERE id=?');
        $zap2->execute(array($wynik['id_statusu']));
        $wynik2 = $zap2->fetch(PDO::FETCH_ASSOC);
        
        return $wynik2['nazwa'];
    }
    
    public function getCount(){
        return $this->liczba_prod;
    }
    
    public function getPrice(){
        $zap = $this->pdo->prepare('SELECT cena FROM zamowienia WHERE id=?');
        $zap->execute(array($this->id_zamowienia));
        $wynik = $zap->fetch(PDO::FETCH_ASSOC);
        
        return $wynik['cena'];
    }
    
    public function getDate(){
        $zap = $this->pdo->prepare('SELECT data_zakupu FROM zamowienia WHERE id=?');
        $zap->execute(array($this->id_zamowienia));
        $wynik = $zap->fetch(PDO::FETCH_ASSOC);
        
        return $wynik['data_zakupu'];
    }
    
    public function getAdress(){
        return $this->adress;
    }
}
