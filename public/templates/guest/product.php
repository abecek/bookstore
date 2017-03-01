<?php

if (isset($_GET['s2']) && is_numeric($_GET['s2'])) {
    if ($book = new Book($pdo, $_GET['s2'])) {
        $book->displayProduct();
    }
    
}
?>

