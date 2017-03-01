<?php
//print_r($_POST);

if(array_key_exists('action', $_POST)){
    switch($_POST['action']){
        case 'edit':
            if($book = new Book($pdo,$_POST)){
                $book->update();
                $book->displayEdit();
            }           
            break;
        case 'delete':
            if($book = new Book($pdo,$_POST)){
                $book->delete();
                echo 'Usunięto książke z bazy.';
            } 
            break;
    }
}
else{
    if (isset($_GET['s2']) && is_numeric($_GET['s2'])) {
        if($book = new Book($pdo, $_GET['s2'])) {
            $book->displayEdit();
        }
    }
    else{
        echo '<div class="container"><h2>Musisz wybrać produkt. </h2></div>';
    }
}