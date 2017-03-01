<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Michal
 */
class User {
    public $pdo;
    
    protected $id;
    protected $email;
    protected $password;
    protected $rank;
    protected $adress;
    
    public function __construct($pdo, $id){
        if (isset($id) && is_numeric($id)){
            $this->pdo =$pdo;
            $zap = $this->pdo->prepare("SELECT * FROM osoby WHERE id = :id");
            $zap->bindValue(":id", $id, PDO::PARAM_INT);
            $zap->execute();
            $wynik = $zap->fetch(PDO::FETCH_ASSOC);

            if(!empty($wynik)){
                $this->id = $id;
                $this->email = $wynik['email'];
                $this->password = $wynik['haslo'];
                
                $this->rank = $wynik['ranga'];
                if(is_numeric($wynik['id_adresu'])){
                   $zap2 = $this->pdo->prepare("SELECT * FROM adres WHERE id = ?");
                   $zap2->execute(array($wynik['id_adresu']));
                   $wynik2 = $zap2->fetch(PDO::FETCH_ASSOC);
                   $this->adress = $wynik2;
                }
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $this->rank = -1;
	}
    }
    
    public function changePassword($old_password, $new_password1, $new_password2){
        if(sha1($old_password) == $this->password){
            if($new_password1 == $new_password2){
                $this->password = sha1($new_password1);    
                return true;
            } 
        }
        return false;
    }
    
    public function addAddress($data){
        $this->adress['id'] = $this->id;
        $this->adress['imie'] = $data['imie'];
        $this->adress['nazwisko'] = $data['nazwisko'];
        $this->adress['telefon'] = $data['telefon'];
        
        $this->adress['ulica'] = $data['ulica'];
        $this->adress['nr_domu'] = $data['nr_domu'];
        $this->adress['nr_lokalu'] = $data['nr_lokalu'];
        $this->adress['kod_poczt'] = $data['kod_poczt'];
        $this->adress['miejscowosc'] = $data['miejscowosc'];
        
            $zap = $this->pdo->prepare('INSERT INTO adres VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $zap->execute(array(
                $this->id,
                $data['ulica'],
                $data['nr_domu'],
                $data['nr_lokalu'],
                $data['kod_poczt'],
                $data['miejscowosc'],
                $data['imie'],
                $data['nazwisko'],
                $data['telefon']
            )); 
        
        return true;
    }
        
    public function update($data){
        $this->adress['id'] = $this->id;
        $this->adress['imie'] = $data['imie'];
        $this->adress['nazwisko'] = $data['nazwisko'];
        $this->adress['telefon'] = $data['telefon'];
        
        $this->adress['ulica'] = $data['ulica'];
        $this->adress['nr_domu'] = $data['nr_domu'];
        $this->adress['nr_lokalu'] = $data['nr_lokalu'];
        $this->adress['kod_poczt'] = $data['kod_poczt'];
        $this->adress['miejscowosc'] = $data['miejscowosc'];
        return true;
    }
    
    public function updateDataBase(){
        $zap = $this->pdo->prepare('UPDATE osoby SET haslo=?, email=?, ranga=? WHERE id=?');
	$zap->execute(array(
            $this->password, 
            $this->email,
            $this->rank,
            $this->id
                ));
        
        if($this->hasAdress()){
            $zap = $this->pdo->prepare('UPDATE adres SET ulica=?, nr_domu=?, nr_lokalu=?, kod_poczt=?, miejscowosc=?, imie=?, nazwisko=?, telefon=? WHERE id=?');
            $zap->execute(array(
                $this->adress['ulica'], 
                $this->adress['nr_domu'],
                $this->adress['nr_lokalu'],
                $this->adress['kod_poczt'],
                $this->adress['miejscowosc'],
                $this->adress['imie'],
                $this->adress['nazwisko'],
                $this->adress['telefon'],
                $this->id
            ));    
        }
        return true;
    }
    
    public function hasAdress(){
        $zap = $this->pdo->prepare("SELECT id FROM adres WHERE id=?");
        $zap->execute(array($this->id));
        $ile = count($zap->fetchAll(PDO::FETCH_NUM));
        
        if ($ile > 0) return true;
        return false;
    }

    public function getAdress(){
        return $this->adress;
    }
    
    public function isLoggedIn(){
        if($this->rank != -1){
           return true; 
        }
        return false;
    }
    
    public function getId(){
	return $this->id;
    }
    
    public function getRole(){
	return $this->rank;
    }
    
    public function setRole($rank){
	$zap = $this->pdo->prepare("UPDATE osoby SET ranga = :rank WHERE id = :id");
	$zap->bindValue(":rank", $rank, PDO::PARAM_INT);
	$zap->bindValue(":id", $this->id, PDO::PARAM_INT);
	$zap->execute();
	$zap->closeCursor();
    }
}
