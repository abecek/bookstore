<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author Michal
 */
        
class Database {
    public $db;
    protected $data;
    
    public function __construct($data)
    {
       if(is_array($data)){
           $this->data = $data;     
       }
       else{
           throw new Execption('Zle dane w konstruktorze.');
       }
       if(!isset($this->db) || $this->db=== null){
            try {
                $this->db = new PDO($this->data['driver'] . 'dbname=' . $this->data['db_name'] . ';host=' . $this->data['host'], $this->data['user'], $this->data['password']);
            } 
            catch (PDOException $e)
            {
                echo $e->getMessage();
             }
        }
    }

    public function Get()
    {
        return $this->db;
    }
}
