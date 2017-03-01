<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InputController
 *
 * @author Michal
 */
class InputController{
    public $pdo;
    
    public function __construct($pdo, $data, $objects){
        $this->pdo = $pdo;
        $auth = $objects[0];
        $user = $objects[1];
        $cart = $objects[2];
        
        //print_r($objects);
        if (!empty($data)){        
            if(array_key_exists('action', $data)){
                //print_r($data);
                switch($data['action']){
                    case 'login':
                        if($auth->login($data['email'], $data['password'])){
                            header("Location: http://localhost/books/".$_GET['s2']);
                        }
                        else {
                            $_SESSION['msg'] = 'Nie zalogowano<br>';
                            header("Location: http://localhost/books/error/");
                        }
                        
                        break;
                    case 'register':
                        $_SESSION['msg'] = $auth->register($data['email'], $data['password1'], $data['password2']);
                        if($_SESSION['msg'] == ''){
                            $auth->login($data['email'], $data['password1']);
                            header("Location: http://localhost/books/");
                        }
                        else{
                            header("Location: http://localhost/books/error/");
                        }
                        
                        break;
                    case 'logout':
                        $auth->logout();
                        header("Location: http://localhost/books/");
                        break;
                    
                    case 'checkout_with_registration':
                        $_SESSION['msg'] .= $auth->register($data['email'], $data['password1'], $data['password2']);
                        if($_SESSION['msg'] == ''){
                            $auth->login($data['email'], $data['password1']);
                            $user = new User($this->pdo, $_SESSION['user']);

                            $user->addAddress($data);
                            $user->updateDataBase();
                            header("Location: http://localhost/books/checkout/");
                        }
                        else{
                            header("Location: http://localhost/books/error/");
                        }
                        
                        break;
                    case 'checkout':
                        if ($user->hasAdress()) $user->update($data);
                        else $user->addAddress ($data);
                        $user->updateDataBase();
                        //header("Location: http://localhost/books/completion/");
                        
                        break;
                    case 'change_password':
                        $user->changePassword($data['old_password'], $data['password1'], $data['password2']);
                        $user->updateDataBase();
                        break;
                    case 'update_profile':
                        if ($user->hasAdress()) $user->update($data);
                        else $user->addAddress ($data);
                        
                        $user->updateDataBase();
                        break;
                        
                    case 'addToCart':
                        $cart->addItem($data['id'], $data['quantity'], $data['price']);
                        $_SESSION['cart'] = $cart;
                        break;
                    case 'deleteItem':
                        $cart->deleteItem($data['id']);
                        break;
                    case 'checkQuantity':
                        $cart->setQuantity($data['id'], $data['quantity']);
                        break;
                    case 'clearCart':
                        $_SESSION['cart'] = null;
                        header("Location: http://localhost/books/cart/");
                        break;
                    
                    case 'chooseCat':
                        header("Location: http://localhost/books/categories/".$data['cat']);
                        break;
                    case 'addOpinion':
                        $book = new Book($pdo, $data['id_ksiazki']);
                        $book->addOpinion($data);
                        
                        //header("Location: http://localhost/books/product/".$_GET['s2']);
                        break;
                    case 'editOpinion':
                        $book = new Book($pdo, $data['id_ksiazki']);
                        $book->editOpinion($data);
                        
                        //header("Location: http://localhost/books/product/".$_GET['s2']);
                        break;
                }  
            }
        }
        else{
            return false;
        }
    }
}
