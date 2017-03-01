<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of session
 *
 * @author Michal
 */
class Session {
    protected $id;

    public function __construct() {
        $this->init();
        $this->id = session_id();
    }
    
    public function init(){
        if(!isset($_SESSION)){
            session_start();
        }
    }
    
    public function session_exist(){
        if(isset($_SESSION)){
            return true;
        }
        else{
            return false;
        }
    }
        
    public function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
            
            throw new Exception('Nie ma takiego Session Key w sesji!');
        }
    }
    
    public function set($key, $value) {
        if (is_string($key)){
            $_SESSION[$key] = $value;  
        }
        else{
            throw new Exception('Session Key musi byc Stringiem!');
        }
    }
    
    public function remove($type = false)
    {
        if ($type === false) {
            session_destroy();
        } else {
            session_unset();
        }
    }
    
    
}
