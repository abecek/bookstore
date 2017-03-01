<?php
$config;

function isLoggedIn(){
    if(isset($_SESSION["user"])) return true;
    else return false;       
}

//autoloader klas
    function __autoload($classname) {
        $filename = "./classes/". $classname .".php";
        require_once($filename);
    }

//loader configu
    if(file_exists('./config/config.ini')){
        $config = parse_ini_file('./config/config.ini', true);
    }
    else{
        throw new Exception('Nie mozna odczytac pliku config.ini');
    }

//kontrola dostepu
    $ACL = Array(
      'guest' => array('home', 'login', 'register', 'cart', 'checkout', 'shop', 'product', 'categories'),
      'user' => array('home', 'logout', 'cart', 'checkout', 'shop', 'product', 'myprofile','categories', 'completion'),
      'admin' => array('panel', 'products', 'edit', 'newproduct', 'upload', 'orders', 'authors', 'newauthor', 'publishers', 'newpublisher')
    );
  
//tworzenie sesji
$session = new Session();
//print_r($_SESSION);

//tworzenie polaczenia z baza (DO PRZEROBIENIA NA STATYCZNA KLASE)
$db = new Database($config['db']);
$pdo = $db->Get();

/*
*Przyklad zapytania
*$stmt = $pdo->prepare('SELECT * FROM user');
*$stmt->execute();
*/


//tworzy obiekt user, jesli nie jest zalogowany to ranga: -1
$user = new User($pdo, $session->get("user"));

//tworzenie obiektu odpowiedzialnego za logowanie, rejestracje, wylogowywanie
$auth = new Authorization($pdo);

//tworze koszyk
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} 
else {
    $cart = new Cart();
}


//tworzy obiekt obslugujacy dane z POST, ktore przekazuje do danych klas (DO PRZEROBKI NA INTERFEJSY)
$input = new InputController($pdo, $_POST, array($auth, $user, $cart));

//print_r($_SESSION);
/*

$_SESSION['post'] .= $_POST;
foreach($_SESSION['post'] as $p){
    print_r($p);
}
*/


$role = -1;
if(isset($_SESSION['rank'])){
    $role = $_SESSION['rank'];
}
switch ($role){
	//gość
	case -1:
		$access = $ACL['guest'];
		$folder = './public/templates/guest/';
		$start = 'home';
                break;
        case 0:
	//user
		$access = $ACL['user'];
		$folder = './public/templates/user/';
		$start = 'home';
                break;
	case 1:
	//admin
		$access = $ACL['admin'];
		$folder = './public/templates/admin/';
		$start = 'panel';
		break;
        
}
//echo'<br><br>';
//print_r($_POST);
//echo'<br><br>';

/*
print_r($_SESSION);
echo'<br><br>';

print_r($_GET);
echo'<br><br>';

print_r($_SERVER['REQUEST_URI']);
echo'<br><br>';

$tab = explode('/', $_SERVER['REQUEST_URI']);
print_r($tab);
echo'<br><br>';
*/

!empty($_GET['page']) ? $page = $_GET['page'] : $page = $start;
in_array($page, $access) ? $page = $page : $page = 'error';

//print_r($folder.''.$page.'.php');

require_once($folder.'header.php');
require_once($folder.''.$page.'.php');
require_once($folder.'footer.php');

