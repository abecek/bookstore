<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categories
 *
 * @author Michal
 */
class Categories {
    protected $cats = array();
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        
        $zap = $this->pdo->prepare("SELECT * FROM `kategorie` ORDER BY 1 ASC");
        $zap->execute();
        $wynik = $zap->fetchAll(PDO::FETCH_ASSOC);
        
        $this->cats = $wynik;
        $this->cats[count($this->cats)+1]['id'] = count($this->cats)+1;
        $this->cats[count($this->cats)+1]['nazwa'] = 'wszystkie';
        print_r($this->cats);
    }
    
    public function print_cats(){
        for ($i = 1; $i <= count($this->cats); $i++) {
            
                if($_GET['s2'] == $this->cats[$i]['id']){ 
                    echo '<option selected="selected" value='.$this->cats[$i]['id'].'>'.$this->cats[$i]['nazwa'].'</option>';
                }
                else{
                   echo '<option value='.$this->cats[$i]['id'].'>'.$this->cats[$i]['nazwa'].'</option>'; 
                }
            
        }
    }
    //put your code here
}
