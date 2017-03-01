<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                
                <form action="" method="POST">
                    <div class="checkbox">
                        <div class="form-group col-xs-4">
                        <label for="sel1">Wybierz kategorie:</label>
                        <select class="form-control" id="sel1" name="cat" onchange="this.form.submit()">
                        <?php
                            $cats = new Categories($pdo);
                            $cats->print_cats();  
                        ?>
                        </select>
                        <input type="hidden" name="action" value="chooseCat">
                        <noscript><input type="submit" value="Submit"></noscript>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    if (isset($_GET['s2']) && is_numeric($_GET['s2'])) {
                        $zap = $pdo->prepare("select * from kategorie_ksiazek where id_kategorii=:id_cat");
                        $zap->bindValue(":id_cat", $_GET['s2'], PDO::PARAM_INT);
                        $zap->execute();
                        $wynik = $zap->fetch(PDO::FETCH_NUM);
                        
                        $liczba_ksiazek = count($wynik);
                        
                        $zap2 = $pdo->prepare("select * from kategorie_ksiazek where id_kategorii=:id_cat");
                        $zap2->bindValue(":id_cat", $_GET['s2'], PDO::PARAM_INT);
                        $zap2->execute();
                       
                        while($row = $zap2->fetch(PDO::FETCH_ASSOC)){
                            $book = new Book($pdo, $row['id_ksiazki']);
                            $book->displayProductSmall();
                        }   
                    }
                ?>
            </div>
        </div>
        
    </body>
</html>
