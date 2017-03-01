<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of authorization
 *
 * @author Michal
 */
class Authorization {
    protected $errors;
    public $pdo;
    //put your code here
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function register($email, $password, $password2) {
			//usuwanie 'białych' znaków z przesłanych danych 
			$email = trim($email);
			$password = trim($password);
			$password2 = trim($password2);
			//Zmienna errors trzyma błędy
			$this->errors = NULL;
                        

			if (strlen($password) < 6) {
				$this->errors .= "Hasło powinno zawierać co najmniej 6 znaków! <br />";
			}
			if ($password !== $password2) {
				$this->errors .= "Hasła nie są takie same! <br />";
			}
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === False) {
				$this->errors .= "Adres email jest niepoprawny! <br />";
			}

			//2.Sprawdzanie danych w bazie login/email
			$zap = $this->pdo->prepare("SELECT email FROM `osoby` WHERE email=:email");
			$zap->bindValue(":email", $email, PDO::PARAM_STR);
			$zap->execute();
			$user = $zap->fetchAll(PDO::FETCH_COLUMN, 0);
			if(count($user)>0) {
				$this->errors .= "Podany adres email jest już w bazie! <br />";
			}

			if (empty($this->errors)) {
				$zap = $this->pdo->prepare("INSERT INTO osoby (haslo, email) VALUES (:password, :email)");
				$zap->bindValue(":password", sha1($password), PDO::PARAM_STR);
                                $zap->bindValue(":email", $email, PDO::PARAM_STR);
				$zap->execute();
                                
                                $zap2 = $this->pdo->prepare('UPDATE osoby SET id_adresu=? WHERE id=?');
                                $zap2->execute(array($this->pdo->lastInsertId(), $this->pdo->lastInsertId()));

				$id = $this->pdo->lastInsertId();
			}
			return $this->errors;
    }
                
    public function login($email, $password){
 	$zap = $this->pdo->prepare("SELECT id, ranga FROM osoby WHERE email=:email AND haslo=:password");
        $zap->bindValue(":email", $email, PDO::PARAM_STR);
        $zap->bindValue(":password", sha1($password), PDO::PARAM_STR);
	$zap->execute();
	$user = $zap->fetchAll(PDO::FETCH_NUM);
	$ile = count($user);
	if($ile == 1){
                $key = sha1("".$_SERVER['HTTP_USER_AGENT']."".$user[0]."ksiegarnia");

                $_SESSION['user'] = $user[0][0];
                $_SESSION['rank'] = $user[0][1];
		$_SESSION['secure'] = (string)$key;
                
		return true;
	}
        else{
            return false;
        }
        
    }
    
    public function logout(){
        //$_SESSION = NULL;
        unset($_SESSION['user']);
        unset($_SESSION['secure']);
        unset($_SESSION['rank']);
        //session_destroy();
    }
}
